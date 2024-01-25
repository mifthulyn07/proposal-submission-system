<?php

namespace App\Http\Livewire\SubmitProposal;

use Livewire\Component;
use App\Models\Proposal;
use App\Models\ProposalProcess;

class Read extends Component
{
    public $proposalProcess;
    public $proposal_onProcess;

    protected $listeners = [
        'showSubmission'    => 'showSubmission', //step-1
        'showVerification'  => 'showVerification', //step-2
        'showResults'       => 'showResults', //step-3
    ];

    public $showSubmission      = false;
    public $showVerification    = false;
    public $showResults         = false;

    public $waitingAdvisor      = false;
    public $submissionIsDone    = false;
    public $proposalIsDone      = false;

    public function mount()
    {
        $proposals_process  = ProposalProcess::where('student_id', auth()->user()->student->id)->get();
        $proposal_onProcess = Proposal::whereHas('lecturers')->where('student_id', auth()->user()->student->id)->where('status', 'on_process')->get();
        $proposal_done_has_lecturer= Proposal::whereHas('lecturers')->where('student_id', auth()->user()->student->id)->where('status', 'done')->get();
        $proposal_done= Proposal::where('student_id', auth()->user()->student->id)->where('status', 'done')->get();
        
        if($proposals_process->isEmpty() && !$proposal_onProcess->isEmpty()){
            $this->submissionIsDone = true;
            if(!$proposal_onProcess->isEmpty()){
                foreach($proposal_onProcess as $proposal){
                    $this->proposal_onProcess = $proposal;
                }
            }else{
                foreach($proposal_done_has_lecturer as $proposal){
                    $this->proposal_onProcess = $proposal;
                }
            }
        }elseif($proposals_process->isEmpty() && $proposal_onProcess->isEmpty() && $proposal_done->isEmpty()){
            $this->waitingAdvisor = true;
        }elseif(!$proposal_done->isEmpty()){
            $this->proposalIsDone = true;
        }else{
            foreach($proposals_process as $proposal_process){
                if(!isset($proposal_process->type) && !isset($proposal_process->date)){
                    if(isset($proposal_process->type) && isset($proposal_process->date)){
                        $this->showSubmission       = false;
                        $this->showVerification     = false;
                        $this->showResults          = true;
                    }else{
                        $this->showSubmission       = true;
                        $this->showVerification     = false;
                        $this->showResults          = false;
                    }

                    $this->proposalProcess = $proposal_process;
                }else{
                    $this->showSubmission       = false;
                    $this->showVerification     = false;
                    $this->showResults          = true;

                    $this->proposalProcess = $proposal_process;
                }
            }

        }
    }

    public function render()
    {
        return view('livewire.submit-proposal.read');
    }

    public function showSubmission() //step-1
    {
        $this->showSubmission       = true;
        $this->showVerification     = false;
        $this->showResults          = false;
    }

    public function showVerification() //step-2
    {
        $this->showSubmission       = false;
        $this->showVerification     = true;
        $this->showResults          = false;
    }

    public function showResults() //step-3
    {
        $this->showSubmission       = false;
        $this->showVerification     = false;
        $this->showResults          = true;
    }
}
