<?php

namespace App\Http\Livewire\Student;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use App\Models\ProposalProcess;

class Create extends Component
{
    // student modal 
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

    // realtime validation property
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate();

            $validatedData['class'] = ucwords($validatedData['class']);

            $student = new Student;
            $student->fill($validatedData);
            $student->save();
            
            // buat role studentnya 
            $student->user->roles()->attach(Role::where('name', 'student')->first());

            // buat proposal processnya 
            if(!$student->proposal_process){
                $proposal_process = new ProposalProcess;
                $proposal_process->student_id = $student->id;
                $proposal_process->save();
            }

            $this->reset();
            session()->flash('success', 'Student successfully stored.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
