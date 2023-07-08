<?php

use App\Models\User;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Http\Livewire\Proposal\Edit;
use App\Http\Livewire\Proposal\Read;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('/add-proposal', 'proposal.create')->name('proposal.create');
    Route::view('/list-proposal', 'proposal.read')->name('proposal.read');
    Route::get('/edit-proposal/{proposal}', function(Proposal $proposal){
        return view('proposal.edit', ['proposal'=> $proposal]);
    })->name('proposal.edit');

    Route::view('/add-topic', 'topic.create')->name('topic.create');
    Route::view('/list-topic', 'topic.read')->name('topic.read');
    Route::get('/edit-topic/{topic}', function(Topic $topic){
        return view('topic.edit', ['topic'=> $topic]);
    })->name('topic.edit');

    Route::view('/add-user', 'user.create')->name('user.create');
    Route::view('/list-user', 'user.read')->name('user.read');
    Route::get('/edit-user/{user}', function(User $user){
        return view('user.edit', ['user' => $user]);
    })->name('user.edit');

    Route::view('/add-lecturer', 'lecturer.create')->name('lecturer.create');
    Route::view('/list-lecturer', 'lecturer.read')->name('lecturer.read');
    Route::get('/edit-lecturer/{lecturer}', function(Lecturer $lecturer){
        return view('lecturer.edit', ['lecturer' => $lecturer]);
    })->name('lecturer.edit');

    Route::view('/add-student', 'student.create')->name('student.create');
    Route::view('/list-student', 'student.read')->name('student.read');
    Route::get('/edit-student/{student}', function(Student $student){
        return view('student.edit', ['student' => $student]);
    })->name('student.edit');

    Route::view('/similarity', 'similarity.check')->name('similarity.check');
});

require __DIR__.'/auth.php';
