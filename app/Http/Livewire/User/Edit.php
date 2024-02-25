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
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    // from parameter
    public $user;

    // User model 
    public $avatar;
    public $name;
    public $email;
    public $gender;
    public $phone;
    public $password;

    // many to many 
    public $role;

    public $avatar_null = false;
    public $make_avatar_null = false;
    public $show_password = false;
    public $empty = false;
    public $password_confirmation;
    public $oldAvatar;

    public function mount($user)
    {
        if(!empty($user)){
            $this->name             = $user->name;
            $this->email            = $user->email;
            $this->gender           = $user->gender;
            $this->phone            = $user->phone;
            $this->oldAvatar        = $user->avatar;
            $this->role             = $user->roles->pluck('id')->toArray();
        }else{
            // for 404 not found
            $this->empty = true;
        }

        // Memeriksa apakah avatar sudah ada atau tidak
        if($user->avatar == null){
            $this->avatar_null = true;
        }
    }

    public function render()
    {
        return view('livewire.user.edit', [
            'roles' => Role::all(),
            'userWithRoleKaprodiExists' => User::whereHas('roles', fn($query) => $query->where('name', 'kaprodi'))->exists(),
        ]);
    }

    protected function propertyValidation()
    {
        if(isset($this->password) || isset($this->password_confirmation)){
            return [
                'name'                  => ['required', 'max:100'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone,'.$this->user->id],
                'avatar'                => ['nullable','image','max:1024','mimes:jpeg,png,jpg'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
                'password'              => [Rules\Password::defaults()],
                'password_confirmation' => ['same:password'],
                'role'                  => ['required', 'exists:roles,id'],
            ];
        }else{
            return [
                'name'                  => ['required', 'max:100'],
                'gender'                => ['in:male,female'],
                'phone'                 => ['numeric', 'unique:users,phone,'.$this->user->id],
                'avatar'                => ['nullable','image','max:1024','mimes:jpeg,png,jpg'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
                'role'                  => ['required', 'exists:roles,id'],
            ];
        }
    }

    // realtime validation the property
    protected function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function make_avatar_null()
    {
        $this->make_avatar_null = true;
    }

    protected function fixingRoles($user)
    {
        if($user->hasRole('student')){
            if(!$user->student){
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();
    
                if(!$student->proposal_process){
                    $proposal_process = new ProposalProcess;
                    $proposal_process->student_id = $student->id;
                    $proposal_process->save();
                }
            }
        }

        if($user->hasRole('lecturer')){
            if(!$user->lecturer){
                $lecturer = new Lecturer();
                $lecturer->user_id = $user->id;
                $lecturer->save();
            }
        }
        
        if(!$user->hasRole('student')){
            if($user->student){
                if($user->student->proposal_process){
                    $user->student->proposal_process->delete();
                }

                $user->student->delete();
            }
        }
        
        if(!$user->hasRole('lecturer')){
            if($user->lecturer){
                $user->lecturer->delete();
            }
        }
    }

    public function update()
    {
        try{
            // for bug 
            if($this->password == ""){
                $this->password = null;
            }

            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            $validatedData['name'] = ucwords($validatedData['name']);
            $validatedData['email'] = strtolower($validatedData['email']);

            // update password 
            if(!isset($this->password)) {
                // Jika password baru tidak diisi, gunakan password lama
                $validatedData['password'] = $this->user->password;
            }else{
                // Jika password baru diisi, update password
                $validatedData['password'] = Hash::make($validatedData['password']);
            }
            
            // update avatar 
            if($this->make_avatar_null == true){
                if($this->oldAvatar){
                    Storage::disk('public')->delete('avatars/'.$this->oldAvatar);
                }
                $validatedData['avatar'] = null;
            }
            
            if(isset($this->avatar)){
                $extension = $validatedData['avatar']->getClientOriginalExtension();//mime:jpg,png,dll
                $imageName = 'avatar'.time().'-'.str_replace(' ', '', $validatedData['name']).'.'.$extension;
                $validatedData['avatar']->storeAs('public/avatars', $imageName);
                $validatedData['avatar'] = $imageName;
            }
            
            $user = User::findOrFail($this->user->id);
            $user->fill($validatedData);
            // for making update on slug 
            $user->slug = null;
            $user->save();

            // update roles 
            $user->roles()->sync($validatedData['role']);
            $this->fixingRoles($user);

            $this->reset(['password', 'password_confirmation', 'avatar']);
            session()->flash('success', 'User account successfully updated.');
            return redirect()->to('/users');
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect()->to('/users');
        }
    }
}
