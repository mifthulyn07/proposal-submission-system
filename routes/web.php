<?php

use App\Models\User;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;

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

    Route::middleware('role:coordinator|lecturer|student')->group(function () {
        Route::middleware('complete.profile')->group(function(){
            Route::view('/list-lecturer', 'lecturer.read')->name('lecturer.read');
            Route::view('/list-student', 'student.read')->name('student.read');
            Route::view('/list-proposal', 'proposal.read')->name('proposal.read');
            Route::view('/similarity', 'similarity.check')->name('similarity.check');
        });

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    Route::middleware('role:coordinator', 'complete.profile')->group(function () {
        // users 
        Route::view('/add-user', 'user.create')->name('user.create');
        Route::view('/list-user', 'user.read')->name('user.read');
        Route::get('/edit-user/{user}', function(User $user){
            return view('user.edit', ['user' => $user]);
        })->name('user.edit');

        // topics
        Route::view('/add-topic', 'topic.create')->name('topic.create');
        Route::view('/list-topic', 'topic.read')->name('topic.read');
        Route::get('/edit-topic/{topic}', function(Topic $topic){
            return view('topic.edit', ['topic'=> $topic]);
        })->name('topic.edit');

        // lecturers 
        Route::view('/add-lecturer', 'lecturer.create')->name('lecturer.create');
        Route::get('/edit-lecturer/{lecturer}', function(Lecturer $lecturer){
            return view('lecturer.edit', ['lecturer' => $lecturer]);
        })->name('lecturer.edit');
        Route::get('/show-project-student/{lecturer}', function(Lecturer $lecturer){
            return view('lecturer.show-student', ['lecturer' => $lecturer]);
        })->name('lecturer.show');

        // students 
        Route::view('/add-student', 'student.create')->name('student.create');
        Route::get('/edit-student/{student}', function(Student $student){
            return view('student.edit', ['student' => $student]);
        })->name('student.edit');

        // proposals
        Route::view('/add-proposal', 'proposal.create')->name('proposal.create');
        Route::get('/edit-proposal/{proposal}', function(Proposal $proposal){
            return view('proposal.edit', ['proposal'=> $proposal]);
        })->name('proposal.edit');

        // check proposal 
        Route::view('/list-proposal-submission', 'check-proposal.read')->name('check-proposal.read');
        Route::get('/check-proposal-submission/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('check-proposal.check', ['proposalProcess' => $proposalProcess]);
        })->name('check-proposal.check');
    });

    Route::middleware('role:student', 'complete.profile')->group(function(){
        // submit proposal 
        Route::view('/list-submit-proposal', 'submit-proposal.read')->name('submit-proposal.read');
        Route::get('/add-submit-proposal/{proposalProcess}', function(ProposalProcess $proposalProcess) {
            return view('submit-proposal.create', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.create');
        Route::get('/submit-proposal/similarity/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('similarity.check', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.similarity.create');
        Route::get('/add-submit-proposal/{proposalProcess}/{title}/{similarity}', function(ProposalProcess $proposalProcess, $title, $similarity){
            return view('submit-proposal.create', compact('proposalProcess', 'title', 'similarity'));
        })->name('submit-proposal-2.create');
        
        // Route::view('/add-submit-proposal/{title}/{similarity}', 'submit-proposal.create')->name('submit-proposal2.create');
        Route::get('/edit-submit-proposal/{submitProposal}', function(SubmitProposal $submitProposal){
            return view('submit-proposal.edit', ['submitProposal' => $submitProposal]);
        })->name('submit-proposal.edit');
        
    });
    
});

require __DIR__.'/auth.php';
