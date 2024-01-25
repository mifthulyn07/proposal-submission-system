<?php

namespace App\Http\Livewire\SubmitProposal\Submission;

use App\Models\Topic;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\SubmitProposal;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    // from parameter
    public $proposalProcess;

    // submitProposal model 
    public $topic_id;
    public $title;
    public $similarity;
    public $proposal;
    public $adding_topic;

    // proposalProcess model 
    public $student_id;

    public $another_topic = false;

    public function mount(Request $request)
    {
        if ($request->session()->exists('title') && $request->session()->exists('similarity')) {
            $this->title = $request->session()->get('title');
            $this->similarity = $request->session()->get('similarity');
        }
    }
    public function render()    
    {
        return view('livewire.submit-proposal.submission.create', [
            'topics' => Topic::all(),
        ]);
    }

    protected function propertyValidation()
    {
        if(!$this->another_topic){
            return [
                'topic_id'      => 'required|exists:topics,id',
                'title'         => 'required|max:255|unique:proposals,title|unique:submit_proposals,title',
                'similarity'    => 'numeric|nullable|integer',
                'proposal'      => 'required|file|mimes:pdf|max:2048',
                'adding_topic'  => 'nullable|string|unique:topics,name'
            ];
        }else{
            return [
                'topic_id'      => 'nullable|exists:topics,id',
                'title'         => 'nullable|max:255|unique:proposals,title|unique:submit_proposals,title',
                'similarity'    => 'numeric|nullable|integer',
                'proposal'      => 'required|file|mimes:pdf|max:2048',
                'adding_topic'  => 'required|string|unique:topics,name'
            ];
        }
        
    }

    // realtime validation the property
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function updatedAnotherTopic()
    {
        $this->reset('adding_topic', 'topic_id');
    }

    public function store()
    {
        try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            // simpan file proposal ke folder proposals 
            $extension = $validatedData['proposal']->getClientOriginalExtension();//mime:pdf
            $proposalName = 'proposal'.time().'-'.str_replace(' ', '', Auth::user()->name).'.'.$extension;
            $validatedData['proposal']->storeAs('public/proposals', $proposalName);

            $validatedData['proposal_process_id'] = $this->proposalProcess->id;
            $validatedData['proposal'] = $proposalName;
            
            // masukkan ke table submit proposal 
            $submit_proposal = new SubmitProposal();
            $submit_proposal->fill($validatedData);
            $submit_proposal->save();

            // $this->resetExcept('proposalProcess');
            session()->flash('success-submit', 'Proposal successfully stored.');
            redirect()->to('/submit-proposal');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
