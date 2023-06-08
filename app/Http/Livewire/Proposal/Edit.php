<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $proposal;
    public $empty = false;

    public $name;
    public $nim;
    public $year;
    public $title;

    public function mount()
    {
        $proposal = Proposal::find($this->proposal->id);
        if(!empty($proposal)){
            $this->name     = $proposal->name;
            $this->nim      = $proposal->nim;
            $this->year     = $proposal->year;
            $this->title    = $proposal->title;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.proposal.edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'name'  => ['required','max:100'],
            'year'  => ['required','max_digits:4','numeric'],
            'nim'   => ['required','max_digits:12','numeric', 'unique:proposals,nim,'.$this->proposal->id],
            'title' => ['required','max:255', 'unique:proposals,title,'.$this->proposal->id],
        ]);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
                'name'  => ['required','max:100'],
                'year'  => ['required','max_digits:4','numeric'],
                'nim'   => ['required','max_digits:12','numeric', 'unique:proposals,nim,'.$this->proposal->id],
                'title' => ['required','max:255'],
            ]);

            $proposal = Proposal::find($this->proposal->id)->fill($validatedData);
            
            $proposal->save();

            session()->flash('success', 'Proposal successfully updated.');

            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());

            return;
        }
    }
}
