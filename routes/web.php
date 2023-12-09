<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Proposal;
use App\Models\SubmitProposal;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Print\AssignmentNoteController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:coordinator|lecturer|student|kaprodi', 'add.role.lecturer')->group(function () {
        // menu read 
        Route::middleware('complete.profile')->group(function(){
            Route::view('/list-lecturer', 'lecturer.read')->name('lecturer.read');
            Route::view('/list-student', 'student.read')->name('student.read');
            Route::view('/list-proposal', 'proposal.read')->name('proposal.read');
            Route::view('/similarity', 'similarity.check')->name('similarity.check');
        });

        // show student from lecturer 
        Route::get('/show-project-student/{lecturer}', function(Lecturer $lecturer){
            return view('lecturer.show-student', ['lecturer' => $lecturer]);
        })->name('lecturer.show');

        // profile 
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // show pdf
        Route::get('/pdf-view/{file_name}', function($file_name){
            return view('print.view-pdf', ['file_name' => $file_name]);
        })->name('print.view-pdf');

        // assignment note
        Route::get('/assignment-note/{proposal}', [AssignmentNoteController::class, 'download'])->name('download.assignment-note');
    });

    Route::middleware('role:coordinator|kaprodi', 'complete.profile', 'add.role.lecturer')->group(function () {
        // users 
        Route::view('/list-user', 'user.read')->name('user.read');
        Route::view('/add-user', 'user.create')->name('user.create');
        Route::get('/edit-user/{user}', function(User $user){
            return view('user.edit', ['user' => $user]);
        })->name('user.edit');

        // topics
        Route::view('/list-topic', 'topic.read')->name('topic.read');
        Route::view('/add-topic', 'topic.create')->name('topic.create');
        Route::get('/edit-topic/{topic}', function(Topic $topic){
            return view('topic.edit', ['topic'=> $topic]);
        })->name('topic.edit');

        // lecturers 
        Route::view('/add-lecturer', 'lecturer.create')->name('lecturer.create');
        Route::get('/edit-lecturer/{lecturer}', function(Lecturer $lecturer){
            return view('lecturer.edit', ['lecturer' => $lecturer]);
        })->name('lecturer.edit');

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
        Route::view('/list-submission', 'check-proposal.read')->name('check-proposal.read');
        Route::get('/check-submission/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('check-proposal.check', ['proposalProcess' => $proposalProcess]);
        })->name('check-proposal.check');
        Route::get('/history-submission/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('check-proposal.submission-history', ['proposalProcess' => $proposalProcess]);
        })->name('check-proposal.submission-history');
    });

    Route::middleware('role:kaprodi', 'complete.profile', 'add.role.lecturer')->group(function(){
        // assignment advisor 
        Route::view('/list-student-submission', 'assignment-advisor.read')->name('assignment-advisor.read');
        Route::get('/check-student-submission/{proposal}', function(Proposal $proposal){
            return view('assignment-advisor.check', ['proposal' => $proposal]);
        })->name('assignment-advisor.check');
    });

    Route::middleware('role:student', 'complete.profile')->group(function(){
        // submit proposal 
        Route::view('/list-submit-proposal', 'submit-proposal.read')->name('submit-proposal.read');
        
        // submission (step-1) -> manual 
        Route::get('/add-submit-proposal/{proposalProcess}', function(ProposalProcess $proposalProcess) {
            return view('submit-proposal.submission.create', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.create');
        Route::get('/edit-submit-proposal/{submitProposal}', function(SubmitProposal $submitProposal){
            return view('submit-proposal.submission.edit', ['submitProposal' => $submitProposal]);
        })->name('submit-proposal.edit');

        // submission (step-1) -> through similarity fiture
        Route::get('/submit-proposal/similarity/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('similarity.check', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.similarity.create');
        Route::get('/add-submit-proposal/{proposalProcess}/{title}/{similarity}', function(ProposalProcess $proposalProcess, $title, $similarity){
            return view('submit-proposal.submission.create', compact('proposalProcess', 'title', 'similarity'));
        })->name('submit-proposal-2.create');

        // submission-results (step-3)
        Route::get('/show-declined/{proposalProcess}', function(ProposalProcess $proposalProcess){
            return view('submit-proposal.submission-results.show-declined', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.show-declined');
    });
    
});

require __DIR__.'/auth.php';
