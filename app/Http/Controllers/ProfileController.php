<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\View\View;
use Illuminate\Http\Request;
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
            'user'      => $request->user(),
            'lecturers' => Lecturer::all(),
        ]);

    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
 
        // update tabel lecturer/student
        $lecturer = Lecturer::where('user_id', Auth::user()->id)->first();
        $student = Student::where('user_id', Auth::user()->id)->first();
        if($lecturer){
            $lecturer->fill($request->validate([
                'nip'               => ['required','numeric', Rule::unique(Lecturer::class)->ignore(Auth::user()->lecturer->id)],
                'expertise'         => ['required'],
                'barcode'           => ['required'],
            ]));
            $lecturer->save();
        }elseif($student){
            $student->fill($request->validate([
                'nim'               => ['required','numeric', Rule::unique(Student::class)->ignore(Auth::user()->student->id)],
                'class'             => ['required', 'string'],
                'lecturer_id'       => ['required', 'exists:lecturers,id']
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
