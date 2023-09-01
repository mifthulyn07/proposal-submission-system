<?php

namespace App\Http\Livewire\SubmitProposal;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SubmitProposal;

class Edit extends Component
{
    use WithFileUploads;
    
    // otomatis dari parameter route
    public $submitProposal;
    public $empty = false;

    // submitProposal model 
    public $topic_id;
    public $title;
    public $similarity;
    public $proposal;

    // proposalProcess model 
    public $student_id;

    public $filename;

    public function mount($submitProposal)
    {
        if(!empty($submitProposal)){
            $this->topic_id     = $submitProposal->topic_id;
            $this->title        = $submitProposal->title;
            $this->similarity   = $submitProposal->similarity;
            $this->proposal     = $submitProposal->proposal;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.submit-proposal.edit', [
            'topics' => Topic::all(),
        ]);
    }

    // realtime validation file 
    public function updatedProposal()
    {
        $validatedData = $this->validate([
            'proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        // menggunakan store untuk mengatur nama scara bebas di storage/public/avatars/blabla.png
        $this->filename = $validatedData['proposal']->store('public/proposals');
    }

    // realtime validation the property that have classes
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'topic_id'      => 'exists:topics,id',
            'title'         => 'required|max:255|unique:proposals,title,'.$this->submitProposal->id,
            // 'similarity'            => 'numeric',
        ]);
    }

    public function update()
    {
        try{
            // for validation
            $validatedData = $this->validate([
                'topic_id'      => 'exists:topics,id',
                'title'         => 'required|max:255|unique:proposals,title,'.$this->submitProposal->id,
                'proposal'      => 'required|file|mimes:pdf|max:2048',
                // 'similarity'            => 'numeric',
            ]);

            $submitProposal = SubmitProposal::findOrFail($this->submitProposal->id);

            // update proposal pdf
            $validatedData['proposal'] = $this->filename;

            $submitProposal->fill($validatedData);
            $submitProposal->save();

            session()->flash('success', 'proposal successfully updated.');
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
