<?php

namespace App\Http\Livewire\Lecturer;

use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdLecturer;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.lecturer.read', [
            'lecturers' => Lecturer::whereHas('user', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
                $query->orWhere('email', 'like', $this->search.'%');
                $query->orWhere('gender', 'like', $this->search.'%');
                $query->orWhere('phone', 'like', $this->search.'%');
            })
            ->orWhere('nip', 'like', $this->search.'%')
            ->paginate(12)
        ]);
    }

    public function editIdLecturer($id)
    {
        return redirect()->route('lecturer.edit', ['lecturer' => $id]);
    }
}
