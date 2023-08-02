<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads; 

    public $avatar;
    public $name;
    public $email;
    public $gender;
    public $phone;
    public $password;
    public $password_confirmation;

    public $selected_roles = [];

    public $filename;
    
    public function render()
    {
        return view('livewire.user.create',[
            'roles' => Role::all(),
        ]);
    }

    // realtime validation property if use classes
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

    // realtime validation file 
    public function updatedAvatar()
    {
        $validatedData = $this->validate([
            'avatar' => 'nullable|image|max:1024|mimes:jpeg,png,jpg', // 1MB Max
        ]);

        // menggunakan store untuk mengatur nama scara bebas di storage/public/avatars/blabla.png
        $this->filename = $validatedData['avatar']->store('public/avatars');
    }

    public function store()
    {
        try{
            // realtime validation property if use classes, must do this twice
            $validatedData = $this->validate([
                'avatar'                => ['nullable','image','max:1024','mimes:jpeg,png,jpg'],
                'name'                  => ['required', 'max:100'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone'],
                'password'              => [Rules\Password::defaults()],
                'password_confirmation' => ['same:password'],
                'selected_roles'        => ['required', 'exists:roles,id'],
            ]);

            // create 
            $user = User::create([
                'avatar'    => $this->filename,
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'gender'    => $validatedData['gender'],
                'phone'     => $validatedData['phone'],
                'password'  => Hash::make($validatedData['password'])
            ]);

            // buat role 
            $user->roles()->attach($validatedData['selected_roles']);

            // isi tabel student/lecturer 
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
