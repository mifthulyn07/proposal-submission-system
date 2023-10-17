<?php

namespace App\Http\Livewire\Proposal;

use App\Models\Topic;
use App\Models\Student;
use Livewire\Component;
use App\Models\Proposal;

class Edit extends Component
{
    // from parameter 
    public $proposal;

    // modal proposal 
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
    public $empty = false;

    public function mount($proposal)
    {
        if(!empty($proposal)){
            $this->topic_id     = $proposal->topic_id;
            $this->student_id   = $proposal->student_id;
            $this->name         = $proposal->name;
            $this->nim          = $proposal->nim;
            $this->type         = $proposal->type;
            $this->title        = $proposal->title;
            $this->year         = $proposal->year;
            $this->status       = $proposal->status;
            $this->adding_topic = $proposal->adding_topic;

            if($this->adding_topic){
                $this->another_topic = true;
            }
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.proposal.edit', [
            'students'  => Student::all(),
            'topics'    => Topic::all(), 
        ]);
    }
    protected function propertyValidation()
    {
        if(!$this->another_topic){
            return [
                'topic_id'      => 'required|exists:topics,id',
                'student_id'    => 'exists:students,id',
                'name'          => 'required|max:100',
                'nim'           => 'required|max_digits:12|numeric|unique:proposals,nim,'.$this->proposal->id,
                'type'          => 'in:thesis,appropriate_technology,journal',
                'title'         => 'required|max:255|unique:proposals,title,'.$this->proposal->id,
                'year'          => 'required|max_digits:4|numeric',
                'status'        => 'in:done,on_process',
                'adding_topic'  => 'nullable|string|unique:topics,name'
            ];
        }else{
            return [
                'topic_id'      => 'nullable|exists:topics,id',
                'student_id'    => 'exists:students,id',
                'name'          => 'required|max:100',
                'nim'           => 'required|max_digits:12|numeric|unique:proposals,nim,'.$this->proposal->id,
                'type'          => 'in:thesis,appropriate_technology,journal',
                'title'         => 'required|max:255|unique:proposals,title,'.$this->proposal->id,
                'year'          => 'required|max_digits:4|numeric',
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

    public function update()
    {
       try{
            // for bug 
            if($this->student_id == ""){
                $this->student_id = null;
            }
            
            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            $validatedData['name'] = ucwords($validatedData['name']);

            $proposal = Proposal::findOrFail($this->proposal->id);
            $proposal->fill($validatedData);
            $proposal->save();

            session()->flash('success', 'Proposal successfully updated.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
