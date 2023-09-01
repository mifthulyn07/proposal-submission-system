<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\User;
use Livewire\Component;
use App\Models\Lecturer;

class Edit extends Component
{
    public $lecturer;
    public $empty = false;

    public $name;
    public $email;
    public $nip;

    public function mount($lecturer)
    {
        if(!empty($lecturer)){
            $this->name     = $lecturer->user->name;
            $this->email    = $lecturer->user->email;
            $this->nip      = $lecturer->nip;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.lecturer.edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'nip'   => ['required', 'numeric', 'unique:lecturers,nip,'.$this->lecturer->id],
        ]);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate([
                'nip'  => ['required', 'numeric', 'unique:lecturers,nip,'.$this->lecturer->id],
            ]);

            $lecturer = Lecturer::findOrFail($this->lecturer->id);
            $lecturer->fill($validatedData);
            $lecturer->save();

            session()->flash('success', 'Lecturer successfully updated.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
