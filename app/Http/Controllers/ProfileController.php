<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {   
        return view('profile.edit', [
            'user' => $request->user(),
            'student' => Student::where('user_id', Auth::user()->id)->get(),
            'lecturer' => Lecturer::where('user_id', Auth::user()->id)->get(),
            'lecturers' => Lecturer::all(),
        ]);

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $user = $request->user()->save();
        dd($request->image);

        $temporaryFile = TemporaryFile::where('folder', $request->image)->first();
        if($temporaryFile){
            $user->addMedia(storage_path('app/public/avatars/' .  $request->image . '/' . $temporaryFile->filename))
            ->toMediaCollection('avatars');
            rmdir(storage_path('app/public/avatars/' . $request->image));
            $temporaryFile->delete();
        }
 
        // update tabel lecturer/student
        $lecturer = Lecturer::where('user_id', Auth::user()->id)->first();
        $student = Student::where('user_id', Auth::user()->id)->first();
        if($lecturer){
            $lecturer->fill($request->validate([
                'nip'               => ['numeric', Rule::unique(Lecturer::class)->ignore(Auth::user()->lecturer->id)],
            ]));
            $lecturer->save();
        }elseif($student){
            $student->fill($request->validate([
                'nim'               => ['numeric', Rule::unique(Student::class)->ignore(Auth::user()->student->id)],
                'class'             => ['string'],
                'lecturer_id'       => ['exists:lecturers,id']
            ]));
            $student->save();
        }
        
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
