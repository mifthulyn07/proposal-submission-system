<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\Role;
use Livewire\Component;
use App\Models\Lecturer;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdLecturer;
    public $deleteIdLecturerName;

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

    public function deleteIdLecturer($id)
    {        
        $lecturer = Lecturer::findOrFail($id);
        $this->deleteIdLecturerName = $lecturer->user->name;
        $this->deleteIdLecturer = $lecturer->id;
    }

    public function deleteLecturer()
    {
        try{
            $lecturer = Lecturer::findOrFail($this->deleteIdLecturer);
            $lecturer->delete();
            
            $lecturerRole = Role::where('name', 'lecturer')->first();
            if ($lecturerRole) {
                $lecturer->user->roles()->detach($lecturerRole->id);

                // Jika pengguna tidak memiliki peran lain selain "lecturer", hapus juga pengguna
                if ($lecturer->user->roles()->count() === 0) {
                    $lecturer->user->delete();
                }
            }

            session()->flash('success', 'Lecturer successfully deleted.');
            
            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Lecturer: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }
}
