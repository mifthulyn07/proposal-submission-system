<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdUser;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.user.read', [
            'users' => User::search($this->search)->paginate(12),
        ]);
    }

    public function editIdUser($id)
    {
        return redirect()->route('user.edit', ['user' => $id]);
    }

    public function deleteIdUser($id)
    {
        $this->deleteIdUser = $id;
    }

    public function deleteUser()
    {
        try{
            User::find($this->deleteIdUser)->delete();
            session()->flash('success', 'Proposal successfully deleted.');

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Proposal: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }
}
