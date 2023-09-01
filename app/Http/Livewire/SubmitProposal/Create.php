<?php

namespace App\Http\Livewire\SubmitProposal;

use App\Models\Topic;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;

class Create extends Component
{
    use WithFileUploads;

    // submitProposal model 
    public $topic_id;
    public $title;
    public $similarity;
    public $proposal;

    // proposalProcess model 
    public $student_id;

    public $filename;

    public function updatedProposal()
    {
        $validatedData = $this->validate([
            'proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        // menggunakan store untuk mengatur nama scara bebas di storage/public/avatars/blabla.png
        $this->filename = $validatedData['proposal']->store('proposals');
    }

    protected $rules = [
        'topic_id'      => 'exists:topics,id',
        'title'         => 'required|max:255|unique:proposals,title',
        'proposal'      => 'required|file|mimes:pdf|max:2048',
        // 'similarity'            => 'numeric',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.submit-proposal.create', [
            'topics' => Topic::all(),
        ]);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            // masukkan ke table proposal process 
            $proposal_process = ProposalProcess::where('student_id', auth()->user()->student->id)->first(); 
            if(!$proposal_process){
                $proposal_process = new ProposalProcess();
                $proposal_process['student_id'] = auth()->user()->student->id;
                $proposal_process->save();
            }
            
            // masukkan ke table submit proposal 
            $submit_proposal = new SubmitProposal();
            $submit_proposal['proposal_process_id'] = $proposal_process->id;
            $submit_proposal['proposal'] = $this->filename;
            $submit_proposal->fill($validatedData);
            $submit_proposal->save();

            $this->reset();
            $this->proposal = null;
            session()->flash('success', 'Proposal successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
