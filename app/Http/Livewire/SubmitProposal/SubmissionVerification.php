<?php

namespace App\Http\Livewire\SubmitProposal;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfRequirement;
use Illuminate\Support\Carbon;

class SubmissionVerification extends Component
{
    use WithFileUploads;

    // from parameter
    public $proposalProcess;

    public $type;
    public $date;
    public $requirements;

    public function render()
    {
        return view('livewire.submit-proposal.submission-verification');
    }

    public function mount()
    {
        $date = Carbon::now();
        $this->date = $date->format('Y-m-d');
    }

    protected function propertyValidation()
    {
        return [
            'type'          => 'required|in:thesis,appropriate_technology,journal',
            'date'          => 'required',
            'requirements'  => 'required|file|mimes:pdf|max:2048', // 1MB Max
        ];
    }

    // realtime validation the property
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function createProposalProcess()
    {
        $validatedData = $this->validate($this->propertyValidation());

        // simpan file proposal ke folder proposals 
        $extension = $validatedData['requirements']->getClientOriginalExtension();//mime:pdf
        $requirementsName = 'requirements'.time().'-'.str_replace(' ', '', $this->proposalProcess->student->user->name).'.'.$extension;
        $validatedData['requirements']->storeAs('public/requirements', $requirementsName);
        $validatedData['requirements'] = $requirementsName;

        $ProposalProcess = $this->proposalProcess;
        $ProposalProcess->fill($validatedData);
        $ProposalProcess->save();

        $this->emit('showResults');
    }

    public function back()
    {
        $this->emit('showSubmission');
    }
}
