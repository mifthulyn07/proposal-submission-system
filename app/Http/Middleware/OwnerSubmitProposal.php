<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SubmitProposal;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerSubmitProposal
{

    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user()->id;  
        if(Auth::user()->student->proposal_process){
            if(isset($request)){
                $param = $request->submitProposal->id;
                $submitProposal = SubmitProposal::findOrFail($param)->proposal_process->student->user->id;
                if($currentUser != $submitProposal){
                    return abort(401);
                }                
            }
        }else{
            return abort(401);
        }
        
        return $next($request);
    }
}
