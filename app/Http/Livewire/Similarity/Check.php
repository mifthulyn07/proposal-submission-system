<?php

namespace App\Http\Livewire\Similarity;
use Livewire\Component;
use App\Models\Proposal;

class Check extends Component
{
    public $text;
    public $similarities = [];
    public $result_cosim = null;
    // public $me = [];

    protected $rules = [
        'text' => 'required',
    ];

    public function render()
    {   
        return view('livewire.similarity.check');
    }
    
    public function checkSimilarities(){
        // make time limit for executing
        set_time_limit(240);

        $this->validate();

        // ambil data
        $text = [
            'name'  => 'data uji',
            'nim'   => 'data uji',
            'year'  => 'data uji',
            'title' => $this->text
        ];

        // filter 
        $search     = trim($this->text);
        $keywords   = explode(' ', $search);
        $query      = Proposal::query();
        foreach ($keywords as $key) {
            $query->orWhere('title', 'like', "%{$key}%");
        }
        $query->get();

        // make an array 
        $corpus = [
            'name'  => $query->pluck('name')->toArray(),
            'nim'   => $query->pluck('nim')->toArray(),
            'year'  => $query->pluck('year')->toArray(),
            'title' => $query->pluck('title')->toArray(),
        ];
        $new_cospus = array_merge_recursive($text, $corpus);

        // encode->run->decode
        $all_similarities = json_encode($new_cospus);
        $command = "C:/Users/Administrator/anaconda3/python.exe " . public_path("\cosine_similarity\cosim.py 2>&1 ") . json_encode($all_similarities);
        $all_similarities = exec($command, $output);
        // dd($output);
        $all_similarities = json_decode(json_decode($all_similarities));

        // Convert $all_similarities to a collection
        $all_similarities = collect($all_similarities);

        // ambil semua index kecuali index pertama 
        $similarities = $all_similarities->slice(1)->sortByDesc('cosim')->values();
        $this->similarities = $similarities;
        dd($similarities);

        // nilai cosim yg paling tinggi 
        $result_cosim1 = $similarities->first()->cosim;
        $this->result_cosim = $result_cosim1;
        
        // ambil index pertama
        $me = $all_similarities->first(); 
        // $this->me = $me;
    }
}
