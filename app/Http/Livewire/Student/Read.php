<?php

namespace App\Http\Livewire\Student;

use App\Models\Role;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdStudent;
    public $deleteIdStudentName;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::whereHas('user', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
                $query->orWhere('gender', 'like', $this->search.'%');
                $query->orWhere('phone', 'like', $this->search.'%');
            })
            ->orWhereHas('lecturer', function (Builder $query) {
                $query->whereHas('user', function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orWhere('nim', 'like', $this->search.'%')
            ->orWhere('class', 'like', $this->search.'%')
            ->paginate(12);

        return view('livewire.student.read', [
            'students'      => $students,
        ]);
    }

    public function editIdStudent($id)
    {
        return redirect()->route('student.edit', ['student' => $id]);
    }

    public function deleteIdStudent($id)
    {        
        $student = Student::findOrFail($id);
        $this->deleteIdStudentName = $student->user->name;
        $this->deleteIdStudent = $student->id;
    }

    public function deleteStudent()
    {
        try{
            $student = Student::findOrFail($this->deleteIdStudent);
            $student->delete();
            
            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $student->user->roles()->detach($studentRole->id);

                // Jika pengguna tidak memiliki peran lain selain "student", hapus juga account pengguna
                if ($student->user->roles()->count() === 0) {
                    $student->user->delete();
                }
            }

            session()->flash('success', 'Student successfully deleted.');
            
            // for hide alert for 3 sec
            $this->emit('alert_remove');
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Student: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
        }
    }
}
