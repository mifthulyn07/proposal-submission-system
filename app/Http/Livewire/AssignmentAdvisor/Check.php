<?php

namespace App\Http\Livewire\AssignmentAdvisor;

use Livewire\Component;
use App\Models\Lecturer;

class Check extends Component
{
    // from parameter 
    public $proposal;

    // many to many 
    public $lecturer_selected1;
    public $lecturer_selected2;

    public function render()
    {
        return view('livewire.assignment-advisor.check', [
            'lecturers'         => Lecturer::all(),
        ]);
    }

    public function propertyValidation()
    {
        if($this->proposal->type == 'journal'){
            return [
                'lecturer_selected1'    => 'required|exists:lecturers,id|different:lecturer_selected2',
                'lecturer_selected2'    => 'exists:lecturers,id|nullable|different:lecturer_selected1',
            ];
        }else{
            return [
                'lecturer_selected1'    => 'required|exists:lecturers,id|different:lecturer_selected2',
                'lecturer_selected2'    => 'required|exists:lecturers,id|different:lecturer_selected1',
            ];
        }
    }

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function assign()
    {
        try{
            // validation when button clicking 
            $this->validate($this->propertyValidation());

            // many to many
            $this->proposal->lecturers()->attach($this->lecturer_selected1);
            $this->proposal->lecturers()->attach($this->lecturer_selected2);

            session()->flash('success', 'accord successfully send.');
            return redirect()->to('/list-student-submission');
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect()->to('/list-student-submission');
        }
    }
}
