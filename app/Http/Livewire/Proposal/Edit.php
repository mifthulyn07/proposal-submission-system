<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public $proposal;
    public $proposal_id;
    public $empty = false;

    public $name;
    public $nim;
    public $year;
    public $title;

    public function mount()
    {
        // masukin ke view
        $proposal = $this->proposal;
        $proposal = Proposal::find($this->proposal_id);
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

    protected $rules = [
        'name'  => ['required','max:100'],
        'nim'   => ['required','max_digits:12','numeric'],
        'year'  => ['required','max_digits:4','numeric'],
        'title' => ['required','max:255','unique:proposals,title'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
       try{
            //sudah di validate
            $this->validate([
                'nim'   => Rule::unique(Proposal::class)->ignore($this->proposal_id),
                'title' => Rule::unique(Proposal::class)->ignore($this->proposal_id),
            ]);

            $proposal = Proposal::find($this->proposal_id);

            $proposal->name     = $this->name;
            $proposal->nim      = $this->nim;
            $proposal->year     = $this->year;
            $proposal->title    = $this->title;

            $proposal->save();
            session()->flash('success', 'Proposal successfully updated.');

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while updating the Proposal: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }
}
