<?php

namespace App\Http\Livewire\Proposal;

use App\Models\Topic;
use App\Models\Student;
use Livewire\Component;
use App\Models\Proposal;

class Create extends Component
{
    // model proposal 
    public $topic_id;
    public $student_id;
    public $name;
    public $nim;
    public $type;
    public $title;
    public $year;
    public $status;
    public $adding_topic;

    public $another_topic = false;

    public function render()
    {
        return view('livewire.proposal.create', [
            'students'  => Student::whereDoesntHave('proposal')->get(),
            'topics'    => Topic::all(), 
        ]);
    }

    protected function propertyValidation()
    {
        if(!$this->another_topic){
            return [
                'topic_id'      => 'required|exists:topics,id',
                'student_id'    => 'nullable|exists:students,id',
                'name'          => 'required|max:100',
                'nim'           => 'required|max_digits:12|numeric|unique:proposals,nim',
                'type'          => 'in:thesis,appropriate_technology,journal',
                'title'         => 'required|max:255|unique:proposals,title',
                'year'          => 'required|max_digits:4|numeric|min:2016',
                'status'        => 'in:done,on_process',
                'adding_topic'  => 'nullable|string|unique:topics,name'
            ];
        }else{
            return [
                'topic_id'      => 'nullable|exists:topics,id',
                'student_id'    => 'nullable|exists:students,id',
                'name'          => 'required|max:100',
                'nim'           => 'required|max_digits:12|numeric|unique:proposals,nim',
                'type'          => 'in:thesis,appropriate_technology,journal',
                'title'         => 'required|max:255|unique:proposals,title',
                'year'          => 'required|max_digits:4|numeric|min:2016',
                'status'        => 'in:done,on_process',
                'adding_topic'  => 'required|string|unique:topics,name'
            ];
        }
    }

    public function updatedAnotherTopic()
    {
        $this->reset('adding_topic', 'topic_id');
    }

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function updatedStudentId()
    {
        if(!empty($this->student_id)){
            $student    = Student::where('id', $this->student_id)->first();
            $this->name = $student->user->name;
            $this->nim  = $student->nim;
        }else{
            $this->reset(['name', 'nim']);
        }
    }

    public function store()
    {
        try{
            // for bug 
            if($this->student_id == ""){
                $this->student_id = null;
            }

            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            $validatedData['name'] = ucwords($validatedData['name']);

            $proposal = new Proposal();
            $proposal->fill($validatedData);
            $proposal->save();

            $this->reset();
            session()->flash('success', 'Proposal successfully stored.');
            redirect()->to('/proposals');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
