<?php

namespace App\Http\Livewire\Similarity;
use Livewire\Component;
use App\Models\Proposal;
use Illuminate\Http\Request;

class Check extends Component
{
    // from parameter 
    public $proposalProcess;

    // model
    public $text;
    
    // for results google scholar 
    public $resultsGoogleScholar            = [];
    public $similaritiesForGoogleScholar    = [];
    public $highestScoreCosimGoogleScholar  = null;
    public $notFoundForGoogleScholar        = false;

    // for results from uinsu student 
    public $resultsUinsuStudent             = [];
    public $similaritiesForUinsuStudent     = [];
    public $highestScoreCosimUinsuStudent   = null;
    public $notFoundForUinsuStudent         = false;

    public $isSimilarityChecked = false;

    public function render()
    {   
        return view('livewire.similarity.check');
    }

    protected $rules = [
        'text' => 'required|min:20|not_regex:/[\n\r]/',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function getProposal()
    {
        // cari title seperti text di database
        $search     = trim($this->text);
        $search     = strtolower($search);
        $keywords   = str_word_count($search, 1);

        // Inisialisasi array untuk menyimpan hasil perbandingan
        $results = [];

        // Ambil semua judul dari tabel proposal
        $proposals = Proposal::select('name', 'year', 'title')->get();

        // Looping untuk membandingkan var1 dengan judul-judul proposal
        foreach ($proposals as $proposal) {
            $title = strtolower($proposal->title);

            $countCommonKeywords = 0;
            // Buat query untuk mencari kata-kata yang sama antara var1 dan judul
            foreach ($keywords as $key) {
                // Menggunakan strpos untuk mencari kata yang sama dalam judul (case-insensitive)
                if (strpos($title, $key) !== false) {
                    $countCommonKeywords++;
                }
            }

            // Jika ada kata yang sama, simpan hasil perbandingan
            if ($countCommonKeywords > 0) {
                $results[] = [
                    'name' => $proposal->name,
                    'year' => $proposal->year,
                    'title' => $proposal->title,
                    'common_keywords_count' => $countCommonKeywords,
                ];
            }
        }

        $topResults = collect($results)
            ->sortByDesc('common_keywords_count')
            ->take(10);

        $plucked = [
            'name' => $topResults->pluck('name')->all(),
            'year' => $topResults->pluck('year')->all(),
            'title' => $topResults->pluck('title')->all(),
        ];

        // Output hasil akhir
        return $plucked;
    }

    protected function executeForUinsuStudent($getTitleRequest)
    {
        // ambil semua judul proposal
        $getProposal = $this->getProposal();

        if(empty($getProposal)){
            $result    = null;
        }else{
            $merge_array        = array_merge_recursive($getTitleRequest, $getProposal);
            $change_to_json     = json_encode($merge_array);
            $command            = "C:/Users/Administrator/anaconda3/python.exe " . public_path("\cosine_similarity\cosimForUinsuStudent.py 2>&1 ") . json_encode($change_to_json);
            $execution          = exec($command, $output);
            $result             = json_decode(json_decode($execution));
        }

        return $result;
    }

    protected function executeForGoogleScholar($getTitleRequest)
    {
        if($getTitleRequest){
            $change_to_json     = json_encode($getTitleRequest);
            $command            = "C:/Users/Administrator/anaconda3/python.exe " . public_path("\cosine_similarity\cosimForGoogleScholar.py 2>&1 ") . json_encode($change_to_json);
            $execution          = exec($command, $output);
            $result             = json_decode(json_decode($execution));
        }else{
            $result = null;
        }

        return $result;
    }
    
    public function checkSimilarities()
    {
        // make time limit for executing
        set_time_limit(240);
        
        $validatedData = $this->validate();

        // ambil pengajuan judul
        $getTitleRequest = [
            'name'  => 'data uji',
            'year'  => 'data uji',
            'title' => $validatedData['text']
        ];

        // execute 
        $resultsGoogleScholar = $this->executeForGoogleScholar($getTitleRequest);
        $resultsUinsuStudent = $this->executeForUinsuStudent($getTitleRequest);

        if($resultsGoogleScholar === null || count($resultsGoogleScholar) === 1){
            $this->notFoundForGoogleScholar         = true;
            $this->highestScoreCosimGoogleScholar   = null;
            $this->similaritiesForGoogleScholar     = [];
        }else{
            // masukkan kedalam property
            $results = collect($resultsGoogleScholar);
            $this->resultsGoogleScholar = $results;

            // urutkan
            $similaritiesForGoogleScholar = $results->slice(1)->sortByDesc('cosim')->values();
            $this->similaritiesForGoogleScholar = $similaritiesForGoogleScholar;

            // nilai cosim yg paling tinggi di google scholar
            $highestScoreCosimGoogleScholar = $similaritiesForGoogleScholar->first()->cosim;
            $this->highestScoreCosimGoogleScholar = intval($highestScoreCosimGoogleScholar);
        }

        if($resultsUinsuStudent === null || count($resultsUinsuStudent) === 1){
            $this->notFoundForUinsuStudent          = true;
            $this->highestScoreCosimUinsuStudent    = null;
            $this->similaritiesForUinsuStudent      = [];
        }else{
            // masukkan kedalam property
            $results = collect($resultsUinsuStudent);
            $this->resultsUinsuStudent = $results;

            // ambil semua index kecuali index pertama 
            $similaritiesForUinsuStudent = $results->slice(1)->sortByDesc('cosim')->values();
            $this->similaritiesForUinsuStudent = $similaritiesForUinsuStudent;

            // nilai cosim yg paling tinggi 
            $highestScoreCosimUinsuStudent = $similaritiesForUinsuStudent->first()->cosim;
            $this->highestScoreCosimUinsuStudent = intval($highestScoreCosimUinsuStudent);
        }

        $this->isSimilarityChecked = true;
    }

    public function submitProposal(Request $request)
    {
        if($this->highestScoreCosimUinsuStudent == null){
            session()->flash('error', 'No similarity found. Unable to proceed further.');
        }else{
            $request->session()->put('title', $this->text);
            $request->session()->put('googleScholarSimilarity', $this->highestScoreCosimGoogleScholar);
            $request->session()->put('uinsuStudentSimilarity', $this->highestScoreCosimUinsuStudent);

            return redirect()->route('submit-proposal.create', ['proposalProcess' => $this->proposalProcess->slug]);
        }
    }

    public function recheck()
    {
        if(isset($this->proposalProcess)){
            return redirect()->route('submit-proposal.similarity.create', ['proposalProcess' => $this->proposalProcess->slug]);
        }else{
            return redirect()->route('similarity.check');
        }
    }
}
