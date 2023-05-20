<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteIdProposal;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.proposal.read', [
            'proposals' => Proposal::latest()->where('title', 'like', '%'.$this->search.'%')->paginate(12),
        ]);
    }

    public function deleteIdProposal($id)
    {
        $this->deleteIdProposal = $id;
    }

    public function deleteProposal()
    {
        try{
            Proposal::find($this->deleteIdProposal)->delete();
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
}
