<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdUser;
    public $deleteIdUserEmail;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::whereHas('roles', function (Builder $query) {
                $query->where('name', 'like', $this->search.'%');
            })
            ->orWhere('name', 'like', $this->search.'%')
            ->orWhere('gender', 'like', $this->search.'%')
            ->orWhere('phone', 'like', $this->search.'%')
            ->orWhere('email', 'like', $this->search.'%')
            ->paginate(12);

        return view('livewire.user.read', [
            'users'         => $users,
        ]);
    }

    public function editIdUser($id)
    {
        return redirect()->route('user.edit', ['user' => $id]);
    }

    public function deleteIdUser($id)
    {        
        $user = User::findOrFail($id);
        $this->deleteIdUserEmail = $user->email;
        $this->deleteIdUser = $user->id;
    }

    public function deleteUser()
    {
        try{
            User::findOrFail($this->deleteIdUser)->delete();

            session()->flash('success', 'User successfully deleted.');
            
            // for hide alert for 3 sec
            $this->emit('alert_remove');
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the User: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
        }
    }
}
