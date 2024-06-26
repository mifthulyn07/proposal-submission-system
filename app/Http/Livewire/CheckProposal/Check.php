<?php

namespace App\Http\Livewire\CheckProposal;

use Livewire\Component;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;

class Check extends Component
{
    // from parameter 
    public $proposalProcess;
    public $submitProposals;
    
    // modal  proposal process
    public $comment;

    // for modal submitProposals 
    public $proposal_selected; 

    public $accept              = false;
    public $decline             = false;
    public $show                = false;
    public $showResultSubmit    = false;
    public $count_submission;

    public function mount()
    {
        $this->submitProposals = SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get();
        $this->count_submission = ProposalProcess::where('student_id', $this->proposalProcess->student->id)->count();
    }

    public function render()
    {
        return view('livewire.check-proposal.check', [
            'lecturers'         => Lecturer::all(),
            'submit_proposals'  => $this->submitProposals,
        ]);
    }

    public function propertyValidation()
    {
        if($this->decline === true){
            return [
                'proposal_selected'     => 'exists:submit_proposals,id|nullable',
                'comment'           => 'required',
            ];
        }else{
            return [
                'proposal_selected'     => 'required|exists:submit_proposals,id',
                'comment'           => 'nullable',
            ];
        }
    }

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function showAccept()
    {

        $this->show = true;

        $this->accept = true;
        $this->decline = false;

        $this->reset('proposal_selected', 'comment');
    }

    public function showDecline()
    {
        $this->show = true;

        $this->accept = false;
        $this->decline = true;

        $this->reset('proposal_selected', 'comment');
    }

    public function submit()
    {
        try{
            // validation when button clicking 
            $this->validate($this->propertyValidation());
            
            // edit submit proposal 
            foreach($this->submitProposals as $submitProposal){
                if($submitProposal->id == $this->proposal_selected){
                    $submitProposal->accord = true;
                }else{
                    $submitProposal->accord = false;
                }
                $submitProposal->save();
            }

            // edit proposal process 
            $proposalProcess = ProposalProcess::findOrFail($this->proposalProcess->id);
            $proposalProcess->comment = $this->comment;
            $proposalProcess->save();

            // if there is proposal is accepted then submit to proposals table  
            foreach($this->submitProposals as $submitProposal){
                if($submitProposal->accord == true){
                    // edit proposals 
                    $check_proposal = Proposal::where('student_id', $submitProposal->proposal_process->student_id);
                    if(!$check_proposal->exists()){
                        $proposal               = new Proposal;
                        $proposal->topic_id     = $submitProposal->topic_id;
                        $proposal->student_id   = $submitProposal->proposal_process->student_id;
                        $proposal->name         = $submitProposal->proposal_process->student->user->name;
                        $proposal->nim          = $submitProposal->proposal_process->student->nim;
                        $proposal->type         = $submitProposal->proposal_process->type;
                        $proposal->title        = $submitProposal->title;
                        $proposal->year         = now()->year;
                        $proposal->status       = 'on_process';
                        $proposal->adding_topic = $submitProposal->adding_topic;
                        $proposal->comment      = $proposalProcess->comment;
                        $proposal->save();

                        // delete proposal process and related table 
                        ProposalProcess::where('student_id', $this->proposalProcess->student->id)->delete();
                    }
                }
            }
            session()->flash('success', 'accord successfully send.');
            redirect()->to('/submissions');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            redirect()->to('/submissions');
        }
    }

    public function showResultSubmit()
    {
        $this->showResultSubmit = true;
    }
}
