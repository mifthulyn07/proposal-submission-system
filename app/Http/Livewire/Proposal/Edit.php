<?php

namespace App\Http\Livewire\Proposal;

use App\Models\Topic;
use App\Models\Student;
use Livewire\Component;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $proposal;
    public $empty = false;

    public $topic_id;
    public $student_id;
    public $name;
    public $nim;
    public $type;
    public $title;
    public $year;
    public $status;

    public function mount()
    {
        $proposal = Proposal::find($this->proposal->id);
        if(!empty($proposal)){
            $this->topic_id     = $proposal->topic_id;
            $this->student_id   = $proposal->student_id;
            $this->name         = $proposal->name;
            $this->nim          = $proposal->nim;
            $this->type         = $proposal->type;
            $this->title        = $proposal->title;
            $this->year         = $proposal->year;
            $this->status       = $proposal->status;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        if(!empty($this->student_id)){
            $student    = Student::where('id', $this->student_id)->first();
            $this->name = $student->user->name;
            $this->nim  = $student->nim;
        }else{
            $this->reset(['name', 'nim']);
        }

        return view('livewire.proposal.edit', [
            'students'  => Student::all(),
            'topics'    => Topic::all(), 
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'topic_id'      => ['exists:topics,id'],
            'student_id'    => ['exists:students,id'],
            'name'          => ['required','max:100'],
            'nim'           => ['required','max_digits:12','numeric','unique:proposals,nim,'.$this->proposal->id],
            'type'          => ['in:skripsi,teknologi_tepat_guna,jurnal'],
            'title'         => ['required','max:255','unique:proposals,title,'.$this->proposal->id],
            'year'          => ['required','max_digits:4','numeric'],
            'status'        => ['in:done,on_process'],
        ]);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
                'topic_id'      => ['exists:topics,id'],
                'student_id'    => ['exists:students,id'],
                'name'          => ['required','max:100'],
                'nim'           => ['required','max_digits:12','numeric','unique:proposals,nim,'.$this->proposal->id],
                'type'          => ['in:skripsi,teknologi_tepat_guna,jurnal'],
                'title'         => ['required','max:255','unique:proposals,title,'.$this->proposal->id],
                'year'          => ['required','max_digits:4','numeric'],
                'status'        => ['in:done,on_process'],
            ]);

            $proposal = Proposal::findOrFail($this->proposal->id);
            $proposal->fill($validatedData);
            $proposal->save();

            session()->flash('success', 'Proposal successfully updated.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
