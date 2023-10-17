<?php

namespace App\Http\Livewire\CheckProposal;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProposalProcess;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.check-proposal.read',[
            'proposals_process' => ProposalProcess::whereNull('explanation')
            ->whereNotNull('type')
            ->whereNotNull('date')
            ->whereHas('student', function (Builder $query) {
                $query->whereHas('user', function (Builder $userQuery) {
                    $userQuery->where('name', 'like', $this->search.'%');
                });
            })
            ->where('type', 'like', $this->search.'%')
            ->latest()
            ->paginate(12),
        ]);
    }

    public function checkProposal($id)
    {
        return redirect()->route('check-proposal.check', ['proposalProcess' => $id]);
    }
}
