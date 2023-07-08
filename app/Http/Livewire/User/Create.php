<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rules;

class Create extends Component
{
    public $name;
    public $email;
    public $role;
    public $gender;
    public $phone;
    public $password;
    public $password_confirmation;
    
    public function render()
    {
        return view('livewire.user.create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name'                  => ['required', 'max:100'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'                  => ['required', 'in:coordinator,lecturer,student'],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone'],
            'password'              => [Rules\Password::defaults()],
            'password_confirmation' => ['same:password'],
        ]);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate([
                'name'                  => ['required', 'max:100'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
                'role'                  => ['required', 'in:admin,lecturer,student'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone'],
                'password'              => [Rules\Password::defaults()],
                'password_confirmation' => ['same:password'],
            ]);
            
            $user = new User();
            $user->fill($validatedData);
            $user->save();

            // buat class lecturer atau student 
            if($user->role == 'lecturer'){
                $lecturer = new Lecturer();
                $lecturer->user_id = $user->id;
                $lecturer->save();
            }elseif($user->role == 'student'){
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();
            }

            $this->reset();

            session()->flash('success', 'User successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
