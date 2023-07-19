<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Lecturer;

class Create extends Component
{
    public $user_id;
    public $nip;

    public function render()
    {
        return view('livewire.lecturer.create',[
            'users' => User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'lecturer');
            })->get(),
        ]);
    }

    protected $rules = [
        'user_id'  => ['required', 'exists:users,id'],
        'nip'      => ['required', 'numeric', 'unique:lecturers,nip'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate();

            $lecturer = Lecturer::create([
                'nip'       => $validatedData['nip'],
                'user_id'   => $validatedData['user_id'],
            ]);
            
            $lecturer_role = Role::where('name', 'lecturer')->first();
            $lecturer->user->roles()->attach($lecturer_role);

            $this->reset();
            session()->flash('success', 'Lecturer successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
