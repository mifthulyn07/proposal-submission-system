<?php

namespace App\Http\Livewire\SubmitProposal;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfRequirement;
use Illuminate\Support\Carbon;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Auth;

class FinishSubmit extends Component
{
    use WithFileUploads;
    
    // from parameter
    public $proposalProcess;

    public $type;
    public $date;
    public $requirements_pdf = [];

    public function mount()
    {
        $date = Carbon::now();
        $this->date = $date->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.submit-proposal.finish-submit');
    }

    protected function propertyValidation()
    {
        return [
            'requirements_pdf.*'    => 'required|file|mimes:pdf|max:2048', // 1MB Max
            'requirements_pdf'      => 'required|array|size:2',
            'type'                  => 'required|in:thesis,appropriate_technology,journal',
            'date'                  => 'required',
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

        foreach ($this->requirements_pdf as $key => $requirement_pdf) {
            $extension = $requirement_pdf->getClientOriginalExtension();//mime:pdf
            $requirementName = $key.'.requirement'.'-'.str_replace(' ', '', $this->proposalProcess->student->user->name).'.'.$extension;
            $proposalFolder = 'public/requirements/requirements'.time().'-'.$this->proposalProcess->student->user->name;
            $requirement_pdf->storeAs($proposalFolder, $requirementName);

            $PdfRequirement = new PdfRequirement;
            $PdfRequirement['proposal_process_id'] = $this->proposalProcess->id;
            $PdfRequirement['pdf_name'] = $requirementName;
            $PdfRequirement->save();
        }

        if(PdfRequirement::where('proposal_process_id', $this->proposalProcess->id)->exists()) {
            // store proposal ke proposals 
            $ProposalProcess = $this->proposalProcess;
            $ProposalProcess->fill($validatedData);
            $ProposalProcess->save();
        }

        $this->emit('showResultSubmit');
    }

    public function back()
    {
        $this->emit('showSubmit');
    }
}