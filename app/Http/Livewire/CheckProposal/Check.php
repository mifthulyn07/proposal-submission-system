<?php

namespace App\Http\Livewire\CheckProposal;

use Livewire\Component;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Storage;

class Check extends Component
{
    // from parameter 
    public $proposalProcess;
    public $submitProposals;
    
    // modal  proposal process
    public $explanation;

    // for modal submitProposals 
    public $proposal_selected; 

    // many to many 
    public $lecturer_selected1;
    public $lecturer_selected2;

    public $accept  = false;
    public $decline = false;
    public $show    = false;
    public $count_submission;

    public function mount()
    {
        $this->submitProposals = SubmitProposal::where('proposal_process_id', $this->proposalProcess->id)->get();
        $this->count_submission = ProposalProcess::where('student_id', $this->proposalProcess->student->id)->count();
    }

    public function render()
    {
        return view('livewire.check-proposal.check', [
            'lecturers'         => Lecturer::all(),
            'submit_proposals'  => $this->submitProposals,
        ]);
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
            return Storage::disk("public")->download('requirements/requirements'.time().$proposalProcess->student->user->name.'.zip');
        } 
    }

    public function propertyValidation(){
        if($this->proposalProcess->type == 'journal'){
            return [
                'proposal_selected'     => 'required|exists:submit_proposals,id',
                'lecturer_selected1'    => 'required|exists:lecturers,id|different:lecturer_selected2',
                'lecturer_selected2'    => 'exists:lecturers,id|nullable|different:lecturer_selected1',
                'explanation'           => 'required',
            ];
        }elseif($this->decline === true){
            return [
                'proposal_selected'     => 'exists:submit_proposals,id|nullable',
                'lecturer_selected1'    => 'exists:lecturers,id|nullable|different:lecturer_selected2',
                'lecturer_selected2'    => 'exists:lecturers,id|nullable|different:lecturer_selected1',
                'explanation'           => 'required',
            ];
        }else{
            return [
                'proposal_selected'     => 'required|exists:submit_proposals,id',
                'lecturer_selected1'    => 'required|exists:lecturers,id|different:lecturer_selected2',
                'lecturer_selected2'    => 'required|exists:lecturers,id|different:lecturer_selected1',
                'explanation'           => 'required',
            ];
        }
    }

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function showAccept()
    {
        $this->show = true;

        $this->accept = true;
        $this->decline = false;

        $this->reset('proposal_selected', 'lecturer_selected1', 'lecturer_selected2', 'explanation');
    }

    public function showDecline()
    {
        $this->show = true;

        $this->accept = false;
        $this->decline = true;

        $this->reset('proposal_selected', 'lecturer_selected1', 'lecturer_selected2', 'explanation');
    }

    public function submit()
    {
        try{
            // validation when button clicking 
            $this->validate($this->propertyValidation());
            
            // edit submit proposal 
            foreach($this->submitProposals as $submitProposal){
                if($submitProposal->id == $this->proposal_selected){
                    $submitProposal->accord = true;
                }else{
                    $submitProposal->accord = false;
                }
                $submitProposal->save();
            }

            // edit proposal process 
            $proposalProcess = ProposalProcess::findOrFail($this->proposalProcess->id);
            $proposalProcess->explanation = $this->explanation;
            $proposalProcess->save();

            // if there is proposal is accepted then submit to proposals table  
            foreach($this->submitProposals as $submitProposal){
                if($submitProposal->accord == true){
                    // edit proposals 
                    $check_proposal = Proposal::where('student_id', $submitProposal->proposal_process->student_id);
                    if(!$check_proposal->exists()){
                        $proposal               = new Proposal;
                        $proposal->topic_id     = $submitProposal->topic_id;
                        $proposal->student_id   = $submitProposal->proposal_process->student_id;
                        $proposal->name         = $submitProposal->proposal_process->student->user->name;
                        $proposal->nim          = $submitProposal->proposal_process->student->nim;
                        $proposal->type         = $submitProposal->proposal_process->type;
                        $proposal->title        = $submitProposal->title;
                        $proposal->year         = now()->year;
                        $proposal->status       = 'on_process';
                        $proposal->adding_topic = $submitProposal->adding_topic;
                        $proposal->save();

                        // many to many
                        $proposal->lecturers()->attach($this->lecturer_selected1);
                        $proposal->lecturers()->attach($this->lecturer_selected2);

                        // delete proposal process and related table 
                        ProposalProcess::findOrFail($this->proposalProcess->id)->delete();
                    }
                }
            }
            session()->flash('success', 'accord successfully send.');
            redirect()->to('/list-proposal-submission');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
