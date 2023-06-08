<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

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

            $proposal = new Proposal();
            $proposal->fill($validatedData);
            $proposal->user_id = Auth::user()->id;
            
            $proposal->save();

            $this->reset();

            session()->flash('success', 'Proposal successfully stored.');

            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());

            return;
        }
    }
}
