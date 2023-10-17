<?php

namespace App\Http\Livewire\SubmitProposal;

use Livewire\Component;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Auth;

class ResultSubmit extends Component
{
    // from parameter
    public $proposalProcess;
    
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

    public function render()
    {
;        return view('livewire.submit-proposal.result-submit', [
            'proposals_process' => ProposalProcess::where('student_id', Auth::user()->student->id)
            ->whereNotNull('type')
            ->whereNotNull('date')
            ->whereNotNull('explanation')
            ->get(),
        ]);
    }
}
