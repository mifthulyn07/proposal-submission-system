<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Edit extends Component
{
    public $user;
    public $empty = false;

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
        return view('livewire.user.edit');
    }

    public function mount()
    {
        $user = User::find($this->user->id);
        if(!empty($user)){
            $this->role                 = $user->role;
            $this->name                 = $user->name;
            $this->unique_numbers       = $user->unique_numbers;
            $this->gender               = $user->gender;
            $this->phone                = $user->phone;
            $this->semester             = $user->semester;
            $this->email                = $user->email;
            // $this->password             = $user->password;
            // $this->password_confirmation= $user->password_confirmati;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'role'                  => ['required', 'in:admin,lecturer,student'],
            'name'                  => ['required', 'max:100'],
            'unique_numbers'        => ['max_digits:12', 'numeric', 'unique:users,unique_numbers,'.$this->user->id],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone,'.$this->user->id],
            // 'semester'              => ['max:2', 'numeric'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'password'              => ['confirmed'],
            'password_confirmation' => ['same:password'],
        ]);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
                'role'                  => ['required', 'in:admin,lecturer,student'],
                'name'                  => ['required', 'max:100'],
                'unique_numbers'        => ['max_digits:12', 'numeric', 'unique:users,unique_numbers,'.$this->user->id],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone,'.$this->user->id],
                // 'semester'              => ['max:2', 'numeric'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
                'password'              => ['confirmed'],
                'password_confirmation' => ['same:password'],
            ]);

            $user = User::find($this->user->id);

            if (!empty($validatedData['password'])) {
                // Jika password baru diisi, update password
                $user->password = $validatedData['password'];
            }else {
                // Jika password baru tidak diisi, gunakan password lama
                $validatedData['password'] = $this->user->password;
            }
            $user->fill($validatedData);

            $this->reset(['password', 'password_confirmation']);

            $user->save();

            session()->flash('success', 'Proposal successfully updated.');

            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
