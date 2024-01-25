<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteIdProposalTitle;
    public $deleteIdProposal;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Proposal::WhereHas('topic', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
            })
            ->orWhere('name', 'like', $this->search.'%')
            ->orWhere('status', 'like', $this->search.'%')
            ->orWhere('type', 'like', $this->search.'%')
            ->orWhere('adding_topic', 'like', $this->search.'%')
            ->orWhere('title', 'like', $this->search.'%');

        return view('livewire.proposal.read', [
            'proposals'         => $query->paginate(12),
        ]);
    }

    public function editIdProposal($id)
    {
        $proposal = Proposal::findOrFail($id);
        return redirect()->route('proposal.edit', ['proposal' => $proposal->slug]);
    }

    public function deleteIdProposal($id)
    {
        $proposal = Proposal::findOrFail($id);
        $this->deleteIdProposalTitle = $proposal->title;
        $this->deleteIdProposal = $proposal->id;
    }

    public function deleteProposal()
    {
        try{
            Proposal::find($this->deleteIdProposal)->delete();
            session()->flash('success', 'Proposal successfully deleted.');

            // for hide alert for 3 sec
            $this->emit('alert_remove');
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Proposal: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
        }
    }
}
