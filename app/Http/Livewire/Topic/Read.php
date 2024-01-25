<?php

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;
    
    public $search = '';
    public $deleteIdTopic;
    public $deleteIdTopicName;

    // for realtime pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.topic.read', [
            'topics' => Topic::search($this->search)->paginate(12),
        ]);
    }

    public function editIdTopic($id)
    {
        $topic = Topic::findOrFail($id);
        return redirect()->route('topic.edit', ['topic' => $topic->slug]);
    }

    public function deleteIdTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $this->deleteIdTopicName = $topic->name;
        $this->deleteIdTopic = $topic->id;
    }

    public function deleteTopic()
    {
        try{
            Topic::find($this->deleteIdTopic)->delete();
            session()->flash('success', 'Topic successfully deleted.');

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        } catch (\Exception $e){
            session()->flash('error', 'An error occurred while deleting the Topic: '.$e->getMessage());

            // for hide alert for 3 sec
            $this->emit('alert_remove');
            return;
        }
    }
}
