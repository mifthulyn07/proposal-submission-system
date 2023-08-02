<?php

namespace App\Http\Livewire\SubmitProposal;

use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // submitProposal model 
    public $proposal_process_id;
    public $topic_id;
    public $title;
    public $similarity;
    public $proposal_pdf;
    public $requirements_pdf;

    public function updatedProposal_pdf()
    {
        $this->validate([
            'proposal_pdf' => 'image|max:1024',
        ]);
        $this->proposal_pdf->store('proposal_pdf');
    }

    // proposalProcess model 
    public $student_id;

    protected $rules = [
        'proposal_process_id'   => 'exists:proposal_processes,id',
        'topic_id'              => 'exists:topics,id',
        'title'                 => 'required|max:225',
        'similarity'            => 'float|numeric',
        'proposal_pdf'          => 'required|string',
        'requirements_pdf'      => 'required|string',

        'student_id'            => 'required|exists:students,id',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.submit-proposal.create');
    }
}
