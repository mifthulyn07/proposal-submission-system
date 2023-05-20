<?php

use App\Http\Livewire\Proposal\Edit;
use Illuminate\Support\Facades\Route;
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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/404', 'pages.404')->name('pages.404');
    Route::view('/500', 'pages.500')->name('pages.500');
    Route::view('/maintenance', 'pages.maintenance')->name('pages.maintenance');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('/add-proposal', 'proposal.create')->name('proposal.create');
    Route::view('/list-proposal', 'proposal.read')->name('proposal.read');
    Route::get('/edit-proposal/{id}', function($id){
        return view('proposal.edit', ['id'=>$id]);
    })->name('proposal.edit');

    Route::view('/similarity', 'similarity.check')->name('similarity.check');
});

require __DIR__.'/auth.php';
