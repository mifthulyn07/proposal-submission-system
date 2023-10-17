<?php

namespace App\Http\Livewire\SubmitProposal;

use Livewire\Component;
use App\Models\SubmitProposal;
use Illuminate\Support\Facades\Storage;

class Submit extends Component
{
    // from parameter 
    public $proposalProcess;

    public $deleteIdSubmitProposalTitle;
    public $deleteIdSubmitProposal;
    public $selectedProposals = [];
    public $selectAll = false;

    public function mount()
    {
        $this->selectedProposals = collect();
    }

    protected function updatedSelectedProposals()
    {
        if(count($this->selectedProposals) > 3){
            return session()->flash('error', 'you have to select min & max 3 (three) proposal to submit');
        }
    }

    public function render()
    {  
        return view('livewire.submit-proposal.submit', [
            'submit_proposals' => SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get(),
        ]);
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

    public function export($id){
        $submitProposal = SubmitProposal::findOrFail($id);
        if($submitProposal){
            return Storage::disk("public")->download('proposals/'.$submitProposal->proposal);
        } 
    }

    public function editIdSubmitProposal($id)
    {
        return redirect()->route('submit-proposal.edit', ['submitProposal' => $id]);
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
                return session()->flash('error', 'you can select only 3 proposal to submit');
            }elseif(count($this->selectedProposals) < 3){
                return session()->flash('error', 'you have to select min & max 3 proposal');
            }
        }else{
            $this->emit('showFinishSubmit');
        }
    }
}
