<?php

namespace App\Http\Livewire\Similarity;
// use Symfony\Component\Process\Process;
use Livewire\Component;
use App\Models\Proposal;

use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Check extends Component
{
    public $text;
    public $similarities = [];
    public $first_percent;

    protected $rules = [
        'text' => 'required',
    ];

    public function render()
    {
        return view('livewire.similarity.check');
    }
    
    public function checkSimilarities(){
        $this->validate();
        set_time_limit(240);

        // ambil data
        $text = [
            'name' => 'data uji',
            'nim'  => 'data uji',
            'year' => 'data uji',
            'title' => $this->text
        ];
        $corpus = [
            'name'  => Proposal::select('name')->get()->pluck('name')->toArray(),
            'nim'   => Proposal::select('nim')->get()->pluck('nim')->toArray(),
            'year'  => Proposal::select('year')->get()->pluck('year')->toArray(),
            'title' => Proposal::select('title')->get()->pluck('title')->toArray(),
        ];
        $similarities = array_merge_recursive($text, $corpus);
        $similarities = json_encode($similarities);
        $command = "C:/Users/Administrator/anaconda3/python.exe " . public_path("\cosine_similarity\cosim.py 2>&1 ") . json_encode($similarities);
        $similarities = exec($command, $output);
        $similarities = json_decode(json_decode($similarities, true), true);
        // buang index pertama 
        $restSimilarities = array_slice($similarities, 1);
        $similarities = collect($restSimilarities)->sortByDesc('percent')->values();
        // dd($similarities);
        $this->similarities = $similarities;

        $firstSimilarity = $similarities->first(); 
        $this->first_percent = $firstSimilarity['percent'];
    }
}
