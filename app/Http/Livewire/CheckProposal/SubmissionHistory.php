<?php

namespace App\Http\Livewire\CheckProposal;

use Livewire\Component;
use App\Models\ProposalProcess;

class SubmissionHistory extends Component
{
    // from parameter 
    public $proposalProcess;

    public function render()
    {
        return view('livewire.check-proposal.submission-history', [
            'proposals_process' => ProposalProcess::where('student_id', $this->proposalProcess->student->id)
            ->whereNotNull('type')
            ->whereNotNull('date')
            ->whereNotNull('comment')
            ->get(),
        ]);
    }
}
