<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rules;


class Edit extends Component
{
    public $user;
    public $empty = false;

    public $name;
    public $email;
    public $role;
    public $gender;
    public $phone;
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
            $this->name                 = $user->name;
            $this->email                = $user->email;
            $this->role                 = $user->role;
            $this->gender               = $user->gender;
            $this->phone                = $user->phone;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function updated($propertyName)
    {
        $validatedData = $this->validateOnly($propertyName, [
            'name'   => ['required', 'max:100'],
            'email'  => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'role'   => ['required', 'in:coordinator,lecturer,student'],
            'gender' => ['in:male,female'],
            'phone'  => ['numeric', 'unique:users,phone,'.$this->user->id],
        ]);

        if (isset($validatedData['password']) || isset($validatedData['password_confirmation'])) {
            $validatedData['password'] = Rules\Password::defaults();
            $validatedData['password_confirmation'] = ['same:password'];
        }
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
            'name'   => ['required', 'max:100'],
            'email'  => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'role'   => ['required', 'in:coordinator,lecturer,student'],
            'gender' => ['in:male,female'],
            'phone'  => ['numeric', 'unique:users,phone,'.$this->user->id],
            ]);

            // jika password diisi saja
            if (isset($validatedData['password']) || isset($validatedData['password_confirmation'])) {
                $validatedData['password'] = Rules\Password::defaults();
                $validatedData['password_confirmation'] = ['same:password'];
            }

            $user = User::findOrFail($this->user->id);
            if (!empty($validatedData['password'])) {
                // Jika password baru diisi, update password
                $user->password = $validatedData['password'];
            }else {
                // Jika password baru tidak diisi, gunakan password lama
                $validatedData['password'] = $this->user->password;
            }
            $user->fill($validatedData);
            // jika ada perubahan di database 
            if($user->isDirty('role')){
                if($user->role == 'lecturer'){
                    $lecturer = new Lecturer();
                    $lecturer->user_id = $user->id;
                    $lecturer->save();
                    
                    $student = Student::where('user_id', $user->id);
                    if($student->exists()){
                        $student->delete();
                    }
                }elseif($user->role == 'student'){
                    $student = new Student();
                    $student->user_id = $user->id;
                    $student->save();
                    
                    $lecturer = Lecturer::where('user_id', $user->id);
                    if($lecturer->exists()){
                        $lecturer->delete();
                    }
                }else{
                    $student = Student::where('user_id', $user->id);
                    $lecturer = Lecturer::where('user_id', $user->id);
                    
                    if($student->exists()){
                        $student->delete();
                    }elseif($lecturer->exists()){
                        $lecturer->delete();
                    }
                }
            }
            $user->save();

            $this->reset(['password', 'password_confirmation']);
            session()->flash('success', 'User successfully updated.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
