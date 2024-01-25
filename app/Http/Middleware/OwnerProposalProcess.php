<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ProposalProcess;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerProposalProcess
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user()->id;  
        if(Auth::user()->student->proposal_process){
            if(isset($request)){
                $param = $request->proposalProcess->id;
                $proposalProcess = ProposalProcess::findOrFail($param)->student->user->id;
                if($currentUser != $proposalProcess){
                    return abort(401);
                }                
            }
        }else{
            return abort(401);
        }
        
        return $next($request);
    }
}
