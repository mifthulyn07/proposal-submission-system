<?php

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;

class Edit extends Component
{
    public $topic;
    public $empty = false;

    public $name;
    public $date;

    public function mount()
    {
        $topic = Topic::find($this->topic->id);
        if(!empty($topic)){
            $this->name     = $topic->name;
            $this->date     = $topic->date;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.topic.edit');
    }

    protected $rules = [
        'name'  => ['required','max:100'],
        'date'  => ['required'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
       try{
            $validatedData = $this->validate();
            $topic = Topic::findOrFail($this->topic->id)->fill($validatedData);
            $topic->save();

            session()->flash('success', 'Topic successfully updated.');
            return;
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return;
        }
    }
}
