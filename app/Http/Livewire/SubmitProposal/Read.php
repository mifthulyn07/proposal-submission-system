<?php

namespace App\Http\Livewire\SubmitProposal;

use App\Models\User;
use Livewire\Component;
use App\Models\Proposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Auth;

class Read extends Component
{
    public $proposalProcess;

    protected $listeners = [
        'showSubmit'        => 'showSubmit',
        'showFinishSubmit'  => 'showFinishSubmit',
        'showResultSubmit'  => 'showResultSubmit',
    ];

    public $showSubmit          = false;
    public $showFinishSubmit    = false;
    public $showResultSubmit    = false;

    public $submission_done = false;

    public function mount()
    {
        $proposals_process  = ProposalProcess::where('student_id', auth()->user()->student->id)->get();
        $proposal_onProcess = Proposal::where('student_id', auth()->user()->student->id)->get();

        if($proposals_process->isEmpty() && $proposal_onProcess){
            $this->submission_done = true;
        }else{
            foreach($proposals_process as $proposal_process){
                if(!isset($proposal_process->type) && !isset($proposal_process->date) || !isset($proposal_process->explanation)){
                    if(isset($proposal_process->type) && isset($proposal_process->date) && !isset($proposal_process->explanation)){
                        $this->showSubmit       = false;
                        $this->showFinishSubmit = false;
                        $this->showResultSubmit = true;
                    }else{
                        $this->showSubmit       = true;
                        $this->showFinishSubmit = false;
                        $this->showResultSubmit = false;
                    }
                    
                    $this->proposalProcess = $proposal_process;
                }else{
                    $this->showSubmit       = false;
                    $this->showFinishSubmit = false;
                    $this->showResultSubmit = true;
    
                    $this->proposalProcess = $proposal_process;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.submit-proposal.read');
    }

    public function showSubmit()
    {
        $this->showSubmit       = true;
        $this->showFinishSubmit = false;
        $this->showResultSubmit = false;
    }

    public function showFinishSubmit()
    {
        $this->showSubmit       = false;
        $this->showFinishSubmit = true;
        $this->showResultSubmit = false;
    }

    public function showResultSubmit()
    {
        $this->showSubmit       = false;
        $this->showFinishSubmit = false;
        $this->showResultSubmit = true;
    }
}
