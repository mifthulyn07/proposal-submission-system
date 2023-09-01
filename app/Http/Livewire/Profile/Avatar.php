<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Avatar extends Component
{
    use WithFileUploads;

    public $user;
    public $avatar;

    public $isUploaded = false;
    public $avatar_null = false;
    public $make_avatar_null = false;
    public $oldAvatar;
    
    public function mount()
    {
        $this->user = Auth::user();
        $this->oldAvatar = $this->user->avatar;

        // Query database untuk memeriksa apakah avatar sudah ada atau tidak
        if($this->user->avatar == null){
            $this->avatar_null = true;
        }
    }

    public function render()
    {
        return view('livewire.profile.avatar');
    }

    public function make_avatar_null()
    {
        $this->make_avatar_null = true;
    }

    // realtime validation file 
    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'nullable|image|max:1024|mimes:jpeg,png,jpg', // 1MB Max
        ]);

        $this->isUploaded = true;
    }

    public function update(){
        try{
            // for validation
            $validatedData = $this->validate([
                'avatar'  => ['nullable','image','max:1024','mimes:jpeg,png,jpg'], // 1MB Max
            ]);

            // update avatar 
            if($this->make_avatar_null == true){
                if($this->oldAvatar){
                    Storage::disk('public')->delete('avatars/'.$this->oldAvatar);
                }
                $validatedData['avatar'] = null;
            }elseif($this->avatar != $this->oldAvatar){
                Storage::disk('public')->delete('avatars/'.$this->oldAvatar);
            }

            if(isset($validatedData['avatar'])){
                $extension = $validatedData['avatar']->getClientOriginalExtension();//mime:jpg,png,dll
                $imageName = time().'-'.uniqid().'.'.$extension;
                $validatedData['avatar']->storeAs('public/avatars', $imageName);
                $validatedData['avatar'] = $imageName;
            }

            $user = User::findOrFail(auth()->user()->id);
            $user->fill($validatedData);
            $user->save();

            $this->reset();
            session()->flash('success', 'Avatar successfully updated.');
            return redirect()->to('/profile');
        }catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
