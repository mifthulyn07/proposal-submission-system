<?php

namespace App\Http\Livewire\Student;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;

class Create extends Component
{
    public $student;
    public $empty = false;

    public $user_id;
    public $nim;
    public $class;
    public $lecturer_id;

    public function render()
    {
        return view('livewire.student.create', [
            'lecturers' => Lecturer::all(),
            'users'     => User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'student');
            })->orderBy('name', 'desc')->get(),
        ]);
    }

    protected $rules = [
        'user_id'       => ['required', 'exists:users,id'],
        'nim'           => ['required', 'numeric', 'unique:students,nim'],
        'class'         => ['required', 'string'],
        'lecturer_id'   => ['required', 'exists:lecturers,id']
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            $student = Student::create([
                'user_id'       => $validatedData['user_id'],
                'nim'           => $validatedData['nim'],
                'class'         => $validatedData['class'],
                'lecturer_id'   => $validatedData['lecturer_id'],
            ]);
            
            $student_role = Role::where('name', 'student')->first();
            $student->user->roles()->attach($student_role);

            $this->reset();
            session()->flash('success', 'Student successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
