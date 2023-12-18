<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Lecturer;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Barcode extends Component
{
    use WithFileUploads;

    public $barcode;

    public $barcode_null = false;
    public $isUploaded = false;
    public $make_barcode_null = false;
    public $oldBarcode;

    public function mount()
    {
        $this->oldBarcode = Auth::user()->lecturer->barcode;
    }

    public function render()
    {
        return view('livewire.profile.barcode');
    }

    public function make_barcode_null()
    {
        $this->make_barcode_null = true;
    }

    // realtime validation file 
    public function updatedBarcode()
    {
        $this->validate([
            'barcode' => 'nullable|image|max:1024|mimes:jpeg,png,jpg', // 1MB Max
        ]);

        $this->isUploaded = true;
    }

    public function update()
    {
        try{
            // for validation
            $validatedData = $this->validate([
                'barcode'  => ['nullable','image','max:100','mimes:jpeg,png,jpg'], // 1MB Max
            ]);

            // update barcode 
            if($this->make_barcode_null == true){
                if($this->oldBarcode){
                    Storage::disk('public')->delete('barcodes/'.$this->oldBarcode);
                }
                $validatedData['barcode'] = null;
            }elseif($this->barcode != $this->oldBarcode){
                Storage::disk('public')->delete('barcodes/'.$this->oldBarcode);
            }

            if(isset($validatedData['barcode'])){
                $extension = $validatedData['barcode']->getClientOriginalExtension();//mime:jpg,png,dll
                $imageName = 'barcode'.time().'-'.str_replace(' ', '', Auth::user()->name).'.'.$extension;
                $validatedData['barcode']->storeAs('public/barcodes', $imageName);
                $validatedData['barcode'] = $imageName;
            }

            $user = Lecturer::findOrFail(auth()->user()->lecturer->id);
            $user->fill($validatedData);
            $user->save();

            $this->reset();
            session()->flash('success_barcode', 'Barcode successfully updated.');
            // harus dilakukan refresh untuk dir file 
            return redirect()->to('/profile');
        }catch (\Exception $e){
            session()->flash('error_barcode', $e->getMessage());
            return;
        }
    }
}

