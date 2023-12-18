<?php

namespace App\Http\Livewire\Lecturer;

use Livewire\Component;
use App\Models\Proposal;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ShowStudent extends Component
{
    use WithPagination;
    
    // from parameter 
    public $lecturer;

    public $search = '';

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $proposals = Proposal::whereHas('lecturers.user', function (Builder $query) {
            $query->where('name', $this->lecturer->user->name);
            })
            ->where(function ($query) {
            $query->where('year', 'like', $this->search . '%')
                ->orWhere('title', 'like', $this->search . '%')
                ->orWhere('type', 'like', $this->search . '%')
                ->orWhere('status', 'like', $this->search . '%')
                ->orWhereHas('topic', function ($query) {
                    $query->where('name', 'like', $this->search . '%');
                })
                ->orWhereHas('student.user', function ($query) {
                    $query->where('name', 'like', $this->search . '%');
                });
            })
            ->paginate(12);    
        return view('livewire.lecturer.show-student', compact('proposals'));
    }
}
