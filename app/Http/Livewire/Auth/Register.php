<?php

namespace App\Http\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    
    public $role;

    public function render()
    {
        return view('livewire.auth.register',[
            'roles' => Role::whereNotIn('name', ['coordinator'])->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'role'                  => ['required', 'exists:roles,id'],
        ]);
    }

    public function store(){
        $validatedData = $this->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'role'                  => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => Hash::make($this->password),
        ]);

        $user->roles()->attach($validatedData['role']);

        if($user->hasRole('student')){
            $student = new Student();
            $student->user_id = $user->id;
            $student->save();
        }elseif($user->hasRole('lecturer')){
            $lecturer = new Lecturer();
            $lecturer->user_id = $user->id;
            $lecturer->save();
        }
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
