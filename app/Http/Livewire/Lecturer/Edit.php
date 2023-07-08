<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\User;
use Livewire\Component;
use App\Models\Lecturer;

class Edit extends Component
{
    public $lecturer;
    public $empty = false;

    public $nip;

    public function mount()
    {
        $lecturer = Lecturer::find($this->lecturer->id);
        if(!empty($lecturer)){
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
            $lecturer = Lecturer::find($this->lecturer->id);
            $lecturer->fill($validatedData);
            $lecturer->save();

            session()->flash('success', 'Lecturer successfully updated.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
