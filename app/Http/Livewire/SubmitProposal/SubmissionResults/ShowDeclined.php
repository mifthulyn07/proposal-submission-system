<?php

namespace App\Http\Livewire\SubmitProposal\SubmissionResults;

use Livewire\Component;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Storage;

class ShowDeclined extends Component
{
    // from parameter 
    public $proposalProcess;

    public $submitProposals;
    
    public function render()
    {
        return view('livewire.submit-proposal.submission-results.show-declined', [
            'submit_proposals' => $this->proposalProcess->submit_proposals,
        ]);
    }

    public function mount()
    {
        $this->submitProposals = SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get();
    }

    public function exportProposal($id){
        $submitProposal = SubmitProposal::findOrFail($id);
        if($submitProposal){
            return Storage::disk("public")->download('proposals/'.$submitProposal->proposal);
        } 
    }

    public function exportRequirements($id){
        $proposalProcess = ProposalProcess::findOrFail($id);
        if($proposalProcess){
            // Create a temporary directory to store the files to be zipped.
            $tempDirectory = storage_path('app/public/temp_zip');
            if (!file_exists($tempDirectory)) {
                mkdir($tempDirectory);
            }

            // Create a unique zip file name.
            $zipFileName = 'requirements'.time().$proposalProcess->student->user->name.'.zip';

            // Create a zip archive containing the copied PDF files.
            $zip = new \ZipArchive;
            if ($zip->open(storage_path('app/public/requirements/') . $zipFileName, \ZipArchive::CREATE) === true) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($tempDirectory));
                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($tempDirectory) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();                
            }
            return Storage::disk("public")->download('requirements/requirements'.time().'-'.$proposalProcess->student->user->name.'.zip');
        } 
    }
}
