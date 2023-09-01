<?php

namespace App\Http\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;

class Edit extends Component
{
    public $student;
    public $empty = false;

    public $name;
    public $email;
    public $nim;
    public $class;
    public $lecturer_id;

    public function mount($student)
    {
        if(!empty($student)){
            $this->name         = $student->user->name;
            $this->email        = $student->user->email;
            $this->nim          = $student->nim;
            $this->class        = $student->class;
            $this->lecturer_id  = $student->lecturer_id;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.student.edit',[
            'lecturers' => Lecturer::all(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'nim'           => ['required', 'numeric', 'unique:students,nim,'.$this->student->id],
            'class'         => ['required', 'string'],
            'lecturer_id'   => ['required', 'exists:lecturers,id']
        ]);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
                'nim'           => ['required', 'numeric', 'unique:students,nim,'.$this->student->id],
                'class'         => ['required', 'string'],
                'lecturer_id'   => ['required', 'exists:lecturers,id']
            ]);

            $student = Student::findOrFail($this->student->id);
            $student->fill($validatedData);
            $student->save();

            session()->flash('success', 'Student successfully updated.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}

