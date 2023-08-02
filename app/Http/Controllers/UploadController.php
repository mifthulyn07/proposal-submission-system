<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        if($request->hasFile('image')){
            // jika punya input imange terisi masukin file ke storage 
            $file       = $request->file('image');
            $filename   = $file->getClientOriginalName();
            $folder     = uniqid().'-'.now()->timestamp;
            $file->storeAs('avatars/'.$folder, $filename);

            // masukkan ke database 
            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }

        return '';
    }
}
