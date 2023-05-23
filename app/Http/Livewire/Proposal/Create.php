<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;

class Create extends Component
{
    public $name;
    public $nim;
    public $year;
    public $title;

    public function render()
    {
        return view('livewire.proposal.create');
    }

    protected $rules = [
        'name'  => 'required|max:100',
        'nim'   => 'required|max_digits:12|numeric|unique:proposals,nim',
        'year'  => 'required|max_digits:4|numeric',
        'title' => 'required|max:255|unique:proposals,title',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            //melihat ada perbedaan di nim & title
            Proposal::firstOrCreate([
                'nim'   => $validatedData['nim'],
                'title' => $validatedData['title'],
                'name'  => $validatedData['name'],
                'year'  => $validatedData['year'],
            ]);

            $this->reset();
            session()->flash('success', 'Proposal successfully stored.');

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while storing the Proposal: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }
}
