<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rules;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $user;
    public $empty = false;

    public $avatar;
    public $name;
    public $email;
    public $gender;
    public $phone;
    public $password;
    public $password_confirmation;

    public $selected_roles;

    public $filename;
    public $isUploaded =false;

    public function mount()
    {
        $user = User::findorFail($this->user->id);
        if(!empty($user)){
            $this->avatar         = $user->avatar;
            $this->name           = $user->name;
            $this->email          = $user->email;
            $this->gender         = $user->gender;
            $this->phone          = $user->phone;
            $this->selected_roles = $user->roles->pluck('id')->toArray();
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.user.edit', [
            'roles' => Role::all()
        ]);
    }

    // realtime validation the property that have classes
    public function updated($propertyName)
    {
        $validatedData = $this->validateOnly($propertyName, [
            'name'              => ['required', 'max:100'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'gender'            => ['in:male,female'],
            'phone'             => ['numeric', 'unique:users,phone,'.$this->user->id],
            'selected_roles'    => ['required', 'array', 'exists:roles,id'],
        ]);

        if (isset($validatedData['password']) || isset($validatedData['password_confirmation'])) {
            $validatedData['password'] = Rules\Password::defaults();
            $validatedData['password_confirmation'] = ['same:password'];
        }
    }

    // realtime validation file 
    public function updatedAvatar()
    {
        $validatedData = $this->validate([
            'avatar' => 'nullable|image|max:1024|mimes:jpeg,png,jpg', // 1MB Max
        ]);

        $this->isUploaded=true;
        
        // menggunakan store untuk mengatur nama scara bebas di storage/avatars/blabla.png
        $this->filename = $validatedData['avatar']->store('avatars', 'public');
    }

    public function update()
    {
        try{
            // for validation
            $validatedData = $this->validate([
                'avatar'            => ['nullable','image','max:1024','mimes:jpeg,png,jpg'], // 1MB Max
                'name'              => ['required', 'max:100'],
                'email'             => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
                'gender'            => ['in:male,female'],
                'phone'             => ['numeric', 'unique:users,phone,'.$this->user->id],
                'selected_roles'    => ['required', 'array', 'exists:roles,id'],
            ]);

            // validation jika password diisi saja
            if (isset($validatedData['password']) || isset($validatedData['password_confirmation'])) {
                $validatedData['password'] = Rules\Password::defaults();
                $validatedData['password_confirmation'] = ['same:password'];
            }

            $user = User::findOrFail($this->user->id);

            // update password 
            if (!empty($validatedData['password'])) {
                // Jika password baru diisi, update password
                $user->password = $validatedData['password'];
            }elseif(empty($validatedData['password'])) {
                // Jika password baru tidak diisi, gunakan password lama
                $validatedData['password'] = $this->user->password;
            }
            
            // update roles 
            $user->roles()->sync($validatedData['selected_roles']);

            // update avatar 
            $validatedData['avatar'] = $this->filename;

            $user->fill($validatedData);
            $user->save();

            // update di table lecturer/student 
            $student = Student::where('user_id', $user->id)->exists();
            $lecturer = Lecturer::where('user_id', $user->id)->exists();
            if($user->hasRole('student')){
                if(!$student){
                    $student = new Student();
                    $student->user_id = $user->id;
                    $student->save();
                }
            }elseif($user->hasRole('lecturer')){
                if(!$lecturer){
                    $lecturer = new Lecturer();
                    $lecturer->user_id = $user->id;
                    $lecturer->save();
                }
            }elseif(!$user->hasRole('student')){
                if($student){
                    $student->delete();
                }
            }elseif(!$user->hasRole('lecturer')){
                if($lecturer){
                    $lecturer->delete();
                }
            }elseif($user->hasRole('lecturer') && !$user->hasRole('student')){
                if(!$lecturer){
                    $lecturer = new Lecturer();
                    $lecturer->user_id = $user->id;
                    $lecturer->save();
                }
                
                if($student){
                    $student->delete();
                }
            }elseif($user->hasRole('student') && !$user->hasRole('lecturer')){
                if(!$student){
                    $student = new Student();
                    $student->user_id = $user->id;
                    $student->save();
                }
            
                if($lecturer){
                    $lecturer->delete();
                }
            }elseif($user->hasRole('lecturer') && $user->hasRole('student')){
                if(!$lecturer){
                    $lecturer = new Lecturer();
                    $lecturer->user_id = $user->id;
                    $lecturer->save();
                }

                if(!$student){
                    $student = new Student();
                    $student->user_id = $user->id;
                    $student->save();
                }
            }elseif(!$user->hasRole('lecturer') && !$user->hasRole('student')){
                if($lecturer){
                    $lecturer->delete();
                }

                if($student){
                    $student->delete();
                }
            }

            $this->reset(['password', 'password_confirmation']);
            session()->flash('success', 'User successfully updated.');
            return redirect()->to('edit-user/'.$user->id);
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
