<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Lecturer;

class Create extends Component
{
    // modal lecturer 
    public $user_id;
    public $nip;
    public $expertise;

    public function render()
    {
        return view('livewire.lecturer.create',[
            'users' => User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['lecturer', 'student']);
            })->get(),
        ]);
    }

    protected $rules = [
        'user_id'       => ['required', 'exists:users,id'],
        'nip'           => ['required', 'numeric', 'unique:lecturers,nip'],
        'expertise'     => ['required'],
    ];

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate();

            $lecturer = Lecturer::create([
                'user_id'   => $validatedData['user_id'],
                'nip'       => $validatedData['nip'],
                'expertise' => $validatedData['expertise'],
            ]);
            
            // buat role lecturernya 
            $lecturer->user->roles()->attach(Role::where('name', 'lecturer')->first());

            $this->reset();
            session()->flash('success', 'Lecturer successfully stored.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
