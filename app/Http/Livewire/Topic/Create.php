<?php

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Create extends Component
{
    public $name;
    public $date;

    public function mount()
    {
        $date = Carbon::now();
        $this->date = $date->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.topic.create');
    }

    protected $rules = [
        'name'  => 'required|max:100',
        'date'  => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            $proposal = new Topic();
            $proposal->fill($validatedData);
            
            $proposal->save();

            $this->reset('name');

            session()->flash('success', 'Proposal successfully stored.');

            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
