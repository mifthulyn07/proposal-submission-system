<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->user()->phone){
            // Jika belum, alihkan mereka ke halaman lengkapi profil
            return redirect('/profile#complete-profile');
        }

        if(auth()->user()->student instanceof Student){
            // Cek apakah pengguna sudah melengkapi data tertentu
            if (!auth()->user()->student->class || !auth()->user()->student->nim || !auth()->user()->student->lecturer_id) {
                // Set pesan peringatan dalam sesi
                session()->flash('warning', ' Please complete your profile to access all features.');

                // Jika belum, alihkan mereka ke halaman lengkapi profil
                return redirect('/profile#complete-profile');
            }
        }
        
        if(auth()->user()->lecturer instanceof Lecturer){
            // Cek apakah pengguna sudah melengkapi data tertentu
            if (!auth()->user()->lecturer->nip || !auth()->user()->lecturer->expertise) {
                // Set pesan peringatan dalam sesi
                session()->flash('warning', ' Please complete your profile to access all features.');

                // Jika belum, alihkan mereka ke halaman lengkapi profil
                return redirect('/profile#complete-profile');
            }
        }

        if(auth()->user()->hasRole('kaprodi')){
            if(!auth()->user()->lecturer->barcode){
                // Set pesan peringatan dalam sesi
                session()->flash('warning_barcode', ' Please complete your barcode to access all features.');

                // Jika belum, alihkan mereka ke halaman lengkapi profil
                return redirect('/profile#complete-profile');
            }
        }
       
        return $next($request);
    }
}
