<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;

class Create extends Component
{
    public $user_id;
    public $nip;

    public function render()
    {
        return view('livewire.lecturer.create',[
            'users' => User::whereNotIn('id', function ($query) {
                $query->select('user_id')->from('lecturers');
            })->get(),
        ]);
    }

    protected $rules = [
        'user_id'   => ['required'],
        'nip'       => ['required', 'numeric', 'unique:lecturers,nip'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();
            $lecturer = new Lecturer();
            $lecturer->fill($validatedData);
            
            if($lecturer->isDirty('user_id')){
                // ubah role di user account
                $user = User::where('id', $lecturer->user_id)->first();
                if ($user) {
                    $user->role = 'lecturer'; 
                    $user->save(); 
                }

                // hapus user_id yang ada di student 
                $student = Student::where('user_id', $lecturer->user_id);
                if($student->exists()){
                    $student->delete();
                }   
            }            
            $lecturer->save();

            $this->reset();
            session()->flash('success', 'Lecturer successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
