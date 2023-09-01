<?php

namespace App\Http\Livewire\SubmitProposal;

use App\Models\User;
use Livewire\Component;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Read extends Component
{
    public $currentStep = 1;
    public $deleteIdSubmitProposalTitle;
    public $deleteIdSubmitProposal;

    public function mount(){
        $check_proposal_process = ProposalProcess::where('student_id', User::with('student')->find(Auth::id())->student->id)->first();
        if($check_proposal_process == null){
            $proposal_process = new ProposalProcess;
            $proposal_process->student_id = User::with('student')->find(Auth::id())->student->id;
            $proposal_process->save();
        }
    }

    public function render()
    {
        $proposal_process = ProposalProcess::where('student_id', User::with('student')->find(Auth::id())->student->id)->first();

        return view('livewire.submit-proposal.read', [
            'submit_proposals' => SubmitProposal::where('proposal_process_id', $proposal_process->id)->get(),
        ]);
    }

    public function export($id){
        $user = User::findOrFail($id); 
        // return Storage::disk("proposals/")->download($user->proposal_pdf);
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

            session()->flash('success', 'Proposal successfully deleted.');
            
            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Proposal: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }

    public function step_advisor()
    {
        $this->currentStep = 2;
    }

    public function step_coordinator()
    {
        $this->currentStep = 3;
    }


}
