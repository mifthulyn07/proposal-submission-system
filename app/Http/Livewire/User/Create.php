<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rules;

class Create extends Component
{
    public $role;
    public $name;
    public $unique_numbers;
    public $gender;
    public $phone;
    public $semester;
    public $email;
    public $password;
    public $password_confirmation;
    
    public function render()
    {
        return view('livewire.user.create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'role'                  => ['required', 'in:admin,lecturer,student'],
            'name'                  => ['required', 'max:100'],
            'unique_numbers'        => ['max_digits:12', 'numeric', 'unique:users,unique_numbers'],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone'],
            // 'semester'              => ['max:2', 'numeric'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['confirmed', Rules\Password::defaults(), ],
            'password_confirmation' => ['same:password'],
        ]);
    }

    public function store()
    {
        try{
            $validatedData = $this->validate([
                'role'                  => ['required', 'in:admin,lecturer,student'],
                'name'                  => ['required', 'max:100'],
                'unique_numbers'        => ['max_digits:12', 'numeric', 'unique:users,unique_numbers'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone'],
                // 'semester'              => ['max:2', 'numeric'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
                'password'              => ['confirmed', Rules\Password::defaults(), ],
                'password_confirmation' => ['same:password'],
            ]);
            
            $user = new User();
            $user->fill($validatedData);
            $user->save();

            $this->reset();

            session()->flash('success', 'User successfully stored.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
