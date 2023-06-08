<?php

use App\Models\User;
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

    Route::view('/add-user', 'user.create')->name('user.create');
    Route::view('/list-user', 'user.read')->name('user.read');
    Route::get('/edit-user/{user}', function(User $user){
        return view('user.edit', ['user' => $user]);
    })->name('user.edit');

    Route::view('/similarity', 'similarity.check')->name('similarity.check');
});

require __DIR__.'/auth.php';
