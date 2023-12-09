<?php

namespace App\Http\Livewire\Proposal;

use Livewire\Component;
use App\Models\Proposal;
use Livewire\WithPagination;
use App\Charts\ProposalsChart;
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
        $search = trim($this->search);
        $keywords = explode(' ', $search);

        $query = Proposal::query()
            ->where('name', 'like', $search.'%')
            ->orWhere('status', 'like', $search.'%')
            ->orWhere('type', 'like', $search.'%')
            ->orWhere('adding_topic', 'like', $search.'%')
            ->orWhereHas('topic', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
            })
            ->OrWhere(function ($query) use ($keywords) {
                foreach ($keywords as $key) {
                    $query->orWhere('title', 'like', "%{$key}%");
                }
            });

        return view('livewire.proposal.read', [
            'proposals'         => $query->paginate(12),
        ]);
    }

    public function editIdProposal($id)
    {
        return redirect()->route('proposal.edit', ['proposal' => $id]);
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
