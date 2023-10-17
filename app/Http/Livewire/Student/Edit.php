<?php

namespace App\Http\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;

class Edit extends Component
{
    // from parameter 
    public $student;
    
    // modal student 
    public $nim;
    public $class;
    public $lecturer_id;
    
    // modal user realtionship
    public $name;
    public $email;

    public $empty = false;
    
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

    protected function propertyValidation()
    {
        return [
            'nim'           => ['required', 'numeric', 'unique:students,nim,'.$this->student->id],
            'class'         => ['required', 'string'],
            'lecturer_id'   => ['required', 'exists:lecturers,id']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function update()
    {
        try{
            $validatedData = $this->validate($this->propertyValidation());

            $validatedData['class'] = ucwords($validatedData['class']);

            $student = Student::findOrFail($this->student->id);
            $student->fill($validatedData);
            $student->save();

            session()->flash('success', 'Student successfully updated.');
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}

