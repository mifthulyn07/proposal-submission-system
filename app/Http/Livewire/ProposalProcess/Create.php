<?php

namespace App\Http\Livewire\ProposalProcess;

use Livewire\Component;

class Create extends Component
{
    public $filename;
    
    public function updatedRequirement()
    {
        $validatedData = $this->validate([
            'requirement' => 'required|file|mimes:pdf|max:2048',
        ]);

        // menggunakan store untuk mengatur nama scara bebas di storage/public/avatars/blabla.png
        $this->filename= $validatedData['requirement']->store('public/requirements');
    }

    public function render()
    {
        return view('livewire.proposal-process.create');
    }
}
