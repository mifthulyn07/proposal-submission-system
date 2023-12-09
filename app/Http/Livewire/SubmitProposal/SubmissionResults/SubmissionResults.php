<?php

namespace App\Http\Livewire\SubmitProposal\SubmissionResults;

use Livewire\Component;
use App\Models\Proposal;
use App\Models\ProposalProcess;

class SubmissionResults extends Component
{
    // from parameter
    public $proposalProcess;

    public $proposal_onProcess;
    
    public function mount()
    {
        $this->proposal_onProcess = Proposal::whereHas('lecturers')->where('student_id', auth()->user()->student->id)->where('status', 'on_process')->get();
    }
    public function render()
    {
        return view('livewire.submit-proposal.submission-results.submission-results', [
            'proposals_process' => ProposalProcess::where('student_id', $this->proposalProcess->student->id)
            ->whereNotNull('type')
            ->whereNotNull('date')
            ->whereNotNull('comment')
            ->get(),
        ]);
    }

    public function resubmit()
    {
        $proposalProcess =  ProposalProcess::where('student_id', auth()->user()->student->id)->whereNull('type')->whereNull('date')->get();
        if($proposalProcess){
            $proposalProcess = new ProposalProcess;
            $proposalProcess->student_id = auth()->user()->student->id;
            $proposalProcess->save();
        }
        return redirect()->to('/list-submit-proposal');
    }
}
