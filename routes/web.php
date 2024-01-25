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

    Route::middleware('role:coordinator|kaprodi|student|lecturer')->group(function () {
        // menu read 
        Route::middleware('complete.profile')->group(function(){
            Route::view('/lecturers', 'lecturer.read')->name('lecturer.read');
            Route::view('/students', 'student.read')->name('student.read');
            Route::view('/proposals', 'proposal.read')->name('proposal.read');
            Route::view('/similarity', 'similarity.check')->name('similarity.check');

            // show student from lecturer 
            Route::get('lecturers/show-project-student/{lecturer:slug}', function(Lecturer $lecturer){
                return view('lecturer.show-student', ['lecturer' => $lecturer]);
            })->name('lecturer.show');

            // show pdf
            Route::get('/pdf-view/{file_name}', function($file_name){
                return view('print.view-pdf', ['file_name' => $file_name]);
            })->name('print.view-pdf');

            // assignment note
            Route::get('/assignment-note/{proposal}', [AssignmentNoteController::class, 'download'])->name('download.assignment-note');
        });

        // profile 
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('role:coordinator|kaprodi', 'complete.profile')->group(function () {
        // users 
        Route::view('/users', 'user.read')->name('user.read');
        Route::view('/users/add', 'user.create')->name('user.create');
        Route::get('/users/{user:slug}', function(User $user){
            return view('user.edit', ['user' => $user]);
        })->name('user.edit');

        // topics
        Route::view('/topics', 'topic.read')->name('topic.read');
        Route::view('/topics/add', 'topic.create')->name('topic.create');
        Route::get('/topics/{topic:slug}', function(Topic $topic){
            return view('topic.edit', ['topic'=> $topic]);
        })->name('topic.edit');

        // lecturers 
        Route::view('/lecturers/add', 'lecturer.create')->name('lecturer.create');
        Route::get('/lecturers/{lecturer:slug}', function(Lecturer $lecturer){
            return view('lecturer.edit', ['lecturer' => $lecturer]);
        })->name('lecturer.edit');

        // students 
        Route::view('/students/add', 'student.create')->name('student.create');
        Route::get('/students/{student:slug}', function(Student $student){
            return view('student.edit', ['student' => $student]);
        })->name('student.edit');

        // proposals
        Route::view('proposals/add', 'proposal.create')->name('proposal.create');
        Route::get('/proposals/{proposal:slug}', function(Proposal $proposal){
            return view('proposal.edit', ['proposal'=> $proposal]);
        })->name('proposal.edit');

        // check proposal 
        Route::view('/submissions', 'check-proposal.read')->name('check-proposal.read');
        Route::get('/submissions/{proposalProcess:slug}', function(ProposalProcess $proposalProcess){
            return view('check-proposal.check', ['proposalProcess' => $proposalProcess]);
        })->name('check-proposal.check');
        Route::get('/submissions/history/{proposalProcess:slug}', function(ProposalProcess $proposalProcess){
            return view('check-proposal.submission-history', ['proposalProcess' => $proposalProcess]);
        })->name('check-proposal.submission-history');
    });

    Route::middleware('role:kaprodi', 'complete.profile')->group(function(){
        // assignment advisor 
        Route::view('/list-student-submission', 'assignment-advisor.read')->name('assignment-advisor.read');
        Route::get('/check-student-submission/{proposal:slug}', function(Proposal $proposal){
            return view('assignment-advisor.check', ['proposal' => $proposal]);
        })->name('assignment-advisor.check');
    });

    Route::middleware('role:student', 'complete.profile')->group(function(){
        // submit proposal 
        Route::view('/submit-proposal', 'submit-proposal.read')->name('submit-proposal.read');
        
        // submission (step-1) -> through similarity fiture
        Route::get('/submit-proposal/similarity/{proposalProcess:slug}', function(ProposalProcess $proposalProcess){
            return view('similarity.check', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.similarity.create')->middleware('ownership.proposal.process');
        Route::get('/submit-proposal/add/{proposalProcess:slug}', function(ProposalProcess $proposalProcess){
            return view('submit-proposal.submission.create', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.create')->middleware('ownership.proposal.process');
        Route::get('/submit-proposal/{submitProposal:slug}', function(SubmitProposal $submitProposal){
            return view('submit-proposal.submission.edit', ['submitProposal' => $submitProposal]);
        })->name('submit-proposal.edit')->middleware('ownership.submit.proposal');

        // submission-results (step-3)
        Route::get('/show-declined/{proposalProcess:slug}', function(ProposalProcess $proposalProcess){
            return view('submit-proposal.submission-results.show-declined', ['proposalProcess' => $proposalProcess]);
        })->name('submit-proposal.show-declined')->middleware('ownership.proposal.process');
    });
});

require __DIR__.'/auth.php';