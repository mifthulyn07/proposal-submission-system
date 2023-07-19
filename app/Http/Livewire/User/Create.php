<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $name;
    public $email;
    public $gender;
    public $phone;
    public $password;
    public $password_confirmation;

    public $selected_roles = [];
    
    public function render()
    {
        return view('livewire.user.create',[
            'roles' => Role::all(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name'                  => ['required', 'max:100'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone'],
            'password'              => [Rules\Password::defaults()],
            'password_confirmation' => ['same:password'],
            'selected_roles'        => ['required', 'array', 'exists:roles,id'],
        ]);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate([
                'name'                  => ['required', 'max:100'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone'],
                'password'              => [Rules\Password::defaults()],
                'password_confirmation' => ['same:password'],
                'selected_roles'        => ['required', 'exists:roles,id'],
            ]);
            
            $user = User::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'gender'    => $validatedData['gender'],
                'phone'     => $validatedData['phone'],
                'password'  => Hash::make($validatedData['password'])
            ]);

            $user->roles()->attach($validatedData['selected_roles']);

            if($user->hasRole('student')){
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();
            }
            if($user->hasRole('lecturer')){
                $lecturer = new Lecturer();
                $lecturer->user_id = $user->id;
                $lecturer->save();
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
