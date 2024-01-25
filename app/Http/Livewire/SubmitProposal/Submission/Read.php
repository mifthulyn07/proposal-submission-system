<?php

namespace App\Http\Livewire\SubmitProposal\Submission;

use Livewire\Component;
use App\Models\SubmitProposal;

class Read extends Component
{
    // from parameter 
    public $proposalProcess;

    public $deleteIdSubmitProposalTitle;
    public $deleteIdSubmitProposal;
    public $selectedProposals = [];
    public $selectAll = false;

    public function render()
    {
        return view('livewire.submit-proposal.submission.read', [
            'submit_proposals' => SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get(),
        ]);
    }

    public function mount()
    {
        $this->selectedProposals = collect();
    }

    protected function updatedSelectedProposals()
    {
        if(count($this->selectedProposals) > 3){
            return session()->flash('error', 'Please select exactly 3 proposals to proceed with your submission.');
        }
    }

    protected function updatedSelectAll($value)
    {   
        // jika di klik maka select semua, jika tidak di kosongkan semua
        if($value){
            $this->selectedProposals = SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get()->pluck('id');
        }else{
            $this->selectedProposals = [];
        }
    }

    public function editIdSubmitProposal($id)
    {
        $submit_proposal = SubmitProposal::findOrFail($id);
        return redirect()->route('submit-proposal.edit', ['submitProposal' => $submit_proposal->slug]);
    }

    public function deleteIdSubmitProposal($id)
    {        
        $submit_proposal = SubmitProposal::findOrFail($id);
        $this->deleteIdSubmitProposalTitle = $submit_proposal->title;
        $this->deleteIdSubmitProposal = $submit_proposal->id;
    }

    public function deleteSubmitProposal()
    {
        try{
            SubmitProposal::findOrFail($this->deleteIdSubmitProposal)->delete();

            session()->flash('success-submit', 'Proposal successfully deleted.');
            $this->emit('alert_remove');
        } catch (\Exception $e){
            session()->flash('error-submit', 'An error occurred while deleting the Proposal: '.$e->getMessage());
            $this->emit('alert_remove');
        }
    }

    public function proposalSubmit()
    {
        if(count($this->selectedProposals) > 3 || count($this->selectedProposals) < 3){
            if(count($this->selectedProposals) > 3){
                return session()->flash('error', 'Oops! You can only submit up to 3 proposals. Please review your selections.');
            }elseif(count($this->selectedProposals) < 3){
                return session()->flash('error', 'Oops! To proceed, please select exactly 3 proposals.');
            }
        }else{
            $this->emit('showVerification');
        }
    }
}
