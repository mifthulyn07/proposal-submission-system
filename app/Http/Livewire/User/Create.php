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

    public $selected_roles = [];
    
    public $password_confirmation;
    public $show_password = false;
    
    public function render()
    {
        return view('livewire.user.create',[
            'roles' => Role::all(),
        ]);
    }

    // realtime validation file 
    protected function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'nullable|image|max:1024|mimes:jpeg,png,jpg', // 1MB Max
        ]);
    }

    // realtime validation property
    protected function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name'                  => ['required', 'max:100'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone'],
            'password'              => [Rules\Password::defaults()],
            'selected_roles'        => ['required', 'array', 'exists:roles,id'],
        ]);
    }

    public function store()
    {
        try{
            // every realtime validation, must do this for twice
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

            // store avatar ke avatars 
            $extension = $validatedData['avatar']->getClientOriginalExtension();//mime:jpg,png,dll
            $imageName = time().'-'.uniqid().'.'.$extension;
            $validatedData['avatar']->storeAs('public/avatars', $imageName);

            // create 
            $user = User::create([
                'avatar'    => $imageName,
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'gender'    => $validatedData['gender'],
                'phone'     => $validatedData['phone'],
                'password'  => Hash::make($validatedData['password'])
            ]);

            // buat role 
            $user->roles()->attach($validatedData['selected_roles']);

            // isi tabel student
            if($user->hasRole('student')){
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();
            }

            // isi tabel lecturer 
            if($user->hasRole('lecturer')){
                $lecturer = new Lecturer();
                $lecturer->user_id = $user->id;
                $lecturer->save();
            }

            $this->reset();
            session()->flash('success', 'User successfully stored.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
