<?php

namespace App\Http\Livewire\AssignmentAdvisor;

use Livewire\Component;
use App\Models\Proposal;
use Livewire\WithPagination;

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
        $proposals = Proposal::where('status', 'on_process')
            ->whereDoesntHave('lecturers')
            ->where(function ($query) {
                $query->where('name', 'like', $this->search.'%')
                    ->orWhere('type', 'like', $this->search.'%');
            })
            ->latest()
            ->paginate(12);
            
        return view('livewire.assignment-advisor.read', [
            'proposals' => $proposals,
        ]);
    }

    public function checkProposal($id)
    {
        $proposal = Proposal::findOrFail($id);
        return redirect()->route('assignment-advisor.check', ['proposal' => $proposal->slug]);
    }
}
