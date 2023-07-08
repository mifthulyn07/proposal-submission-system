<?php

namespace App\Http\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdStudent;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.student.read', [
            'students' => Student::whereHas('user', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
                $query->orWhere('email', 'like', $this->search.'%');
                $query->orWhere('gender', 'like', $this->search.'%');
                $query->orWhere('phone', 'like', $this->search.'%');
            })
            // ->orwhereHas('dosen_pa', function (Builder $query) {
            //     $query->orWhereHas('user', function (Builder $query) {
            //         $query->orWhere('name', 'like', $this->search.'%');
            //     });
            // })
            ->orWhere('nim', 'like', $this->search.'%')
            ->orWhere('class', 'like', $this->search.'%')
            ->paginate(12)
        ]);
    }

    public function editIdStudent($id)
    {
        return redirect()->route('student.edit', ['student' => $id]);
    }
}
