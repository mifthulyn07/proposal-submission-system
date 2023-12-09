<?php

namespace App\Http\Livewire\SubmitProposal\Submission;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SubmitProposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;
    
    // otomatis dari parameter route
    public $submitProposal;

    // submitProposal model 
    public $topic_id;
    public $title;
    public $similarity;
    public $proposal;
    public $adding_topic;

    // proposalProcess model 
    public $student_id;

    public $oldProposal;
    public $empty = false;
    public $another_topic = false;

    public function render()
    {
        return view('livewire.submit-proposal.submission.edit', [
            'topics' => Topic::all(),
        ]);
    }

    public function mount($submitProposal)
    {
        if(!empty($submitProposal)){
            $this->topic_id     = $submitProposal->topic_id;
            $this->title        = $submitProposal->title;
            $this->similarity   = $submitProposal->similarity;
            $this->adding_topic = $submitProposal->adding_topic;

            $this->oldProposal  = $submitProposal->proposal;

            if($this->adding_topic){
                $this->another_topic = true;
            }
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    protected function propertyValidation()
    {
        if(!$this->another_topic && !isset($this->proposal)){
            return [
                'topic_id'      => 'required|exists:topics,id',
                'title'         => 'required|max:255|unique:proposals,title|unique:submit_proposals,title,'.$this->submitProposal->id,
                'similarity'    => 'numeric|nullable|integer',
                'adding_topic'  => 'nullable|string|unique:topics,name'
            ];
        }elseif(!$this->another_topic && isset($this->proposal)){
            return [
                'topic_id'      => 'required|exists:topics,id',
                'title'         => 'required|max:255|unique:proposals,title|unique:submit_proposals,title,'.$this->submitProposal->id,
                'similarity'    => 'numeric|nullable|integer',
                'proposal'      => 'required|file|mimes:pdf|max:2048',
                'adding_topic'  => 'nullable|string|unique:topics,name'
            ];
        }elseif($this->another_topic && !isset($this->proposal)){
            return [
                'topic_id'      => 'nullable|exists:topics,id',
                'title'         => 'required|max:255|unique:proposals,title|unique:submit_proposals,title,'.$this->submitProposal->id,
                'similarity'    => 'numeric|nullable|integer',
                'adding_topic'  => 'required|string|unique:topics,name'
            ];
        }elseif($this->another_topic && isset($this->proposal)){
            return [
                'topic_id'      => 'nullable|exists:topics,id',
                'title'         => 'nullable|max:255|unique:proposals,title|unique:submit_proposals,title,'.$this->submitProposal->id,
                'similarity'    => 'numeric|nullable|integer',
                'proposal'      => 'required|file|mimes:pdf|max:2048',
                'adding_topic'  => 'required|string|unique:topics,name'
            ];
        }
        
    }

    // realtime validation the property
    protected function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function updatedAnotherTopic()
    {
        $this->reset('adding_topic', 'topic_id');
    }

    public function update()
    {
        try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            if(isset($this->proposal)){
                // hapus old proposal 
                if($this->oldProposal){
                    Storage::disk('public')->delete('proposals/'.$this->oldProposal);
                }

                // masukkan file ke folder
                $extension = $validatedData['proposal']->getClientOriginalExtension();//mime:jpg,png,dll
                $proposalName = 'proposal'.time().'-'.str_replace(' ', '', Auth::user()->name).'.'.$extension;
                $validatedData['proposal']->storeAs('public/proposals', $proposalName);
                $validatedData['proposal'] = $proposalName;
            }

            $submitProposal = SubmitProposal::findOrFail($this->submitProposal->id);
            $submitProposal->update($validatedData);     
            $submitProposal->save();

            session()->flash('success', 'proposal successfully updated.');
           
            // harus dilakukan refresh untuk dir file 
            return redirect()->to('edit-submit-proposal/'.$submitProposal->id);
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
