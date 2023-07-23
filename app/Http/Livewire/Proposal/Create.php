<?php

namespace App\Http\Livewire\Proposal;

use App\Models\Topic;
use App\Models\Student;
use Livewire\Component;
use App\Models\Proposal;

class Create extends Component
{
    public $topic_id;
    public $student_id;
    public $name;
    public $nim;
    public $type;
    public $title;
    public $year;
    public $status;

    protected $rules = [
        'topic_id'      => 'exists:topics,id|nullable',
        'student_id'    => 'exists:students,id|nullable',
        'name'          => 'required|max:100',
        'nim'           => 'required|max_digits:12|numeric|unique:proposals,nim',
        'type'          => 'in:skripsi,teknologi_tepat_guna,jurnal',
        'title'         => 'required|max:255|unique:proposals,title',
        'year'          => 'required|max_digits:4|numeric',
        'status'        => 'in:done,on_process',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        if(!empty($this->student_id)){
            $student    = Student::where('id', $this->student_id)->first();
            $this->name = $student->user->name;
            $this->nim  = $student->nim;
        }

        return view('livewire.proposal.create', [
            'students'  => Student::whereDoesntHave('proposal')->get(),
            'topics'    => Topic::all(), 
        ]);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            $proposal = new Proposal();
            $proposal->fill($validatedData);
            $proposal->save();

            $this->reset();
            session()->flash('success', 'Proposal successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
