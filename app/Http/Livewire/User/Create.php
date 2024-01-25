<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Livewire\WithFileUploads;
use App\Models\ProposalProcess;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    use WithFileUploads; 

    // User model 
    public $avatar;
    public $name;
    public $email;
    public $gender;
    public $phone;
    public $password;

    // many to many 
    public $role;
    
    public $password_confirmation;
    public $show_password = false;
    
    public function render()
    {
        return view('livewire.user.create',[
            'roles' => Role::all(),
            'userWithRoleKaprodiExists' => User::whereHas('roles', fn($query) => $query->where('name', 'kaprodi'))->exists(),
        ]);
    }

    protected function propertyValidation()
    {
        return [
            'name'                  => ['required', 'max:100'],
            'gender'                => ['in:male,female'],
            'phone'                 => ['numeric', 'unique:users,phone'],
            'avatar'                => ['nullable','image','max:1024','mimes:jpeg,png,jpg'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => [Rules\Password::defaults()],
            'password_confirmation' => ['same:password'],
            'role'                  => ['required', 'exists:roles,id'],
        ];
    }

    // realtime validation property
    protected function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function store()
    {
        try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            $validatedData['name'] = ucwords($validatedData['name']);
            $validatedData['email'] = strtolower($validatedData['email']);
            $validatedData['password'] = Hash::make($validatedData['password']);
            
            // letak file avatar ke folder avatars
            if(isset($this->avatar)){
                $extension = $validatedData['avatar']->getClientOriginalExtension();//mime:jpg,png,dll
                $imageName = 'avatar'.time().'-'.str_replace(' ', '', $validatedData['name']).'.'.$extension;
                $validatedData['avatar']->storeAs('public/avatars', $imageName);
                $validatedData['avatar'] = $imageName;
            }
            
            $user = new User();
            $user->fill($validatedData);
            $user->save();

            // buat role 
            $user->roles()->attach($validatedData['role']);

            // isi tabel student
            if($user->hasRole('student')){
                // buat student 
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();

                // buat proposal process
                $proposal_process = new ProposalProcess;
                $proposal_process->student_id = User::with('student')->find($student->user_id)->student->id;
                $proposal_process->save();
            }

            // isi tabel lecturer 
            if($user->hasRole('lecturer') || $user->hasRole('kaprodi') || $user->hasRole('coordinator')){
                $lecturer = new Lecturer();
                $lecturer->user_id = $user->id;
                $lecturer->save();
            }

            $this->reset();
            session()->flash('success', 'User account successfully stored.');
            redirect()->to('/users');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
