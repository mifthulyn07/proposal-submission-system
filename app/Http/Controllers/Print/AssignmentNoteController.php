<?php

namespace App\Http\Controllers\Print;

use App\Models\User;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class AssignmentNoteController extends Controller
{
    public function download(Proposal $proposal)
    {
        // make time limit for executing
        set_time_limit(240);

        $kaprodi    = User::role('kaprodi')->first();
        $proposal   = Proposal::findOrFail($proposal->id);
        
        // dd('storage/barcodes/'.$kaprodi->lecturer->barcode);
        $pdf = PDF::loadView('print.assignment-note', [
                'kaprodi_name'          => $kaprodi->name,
                'kaprodi_nip'           => $kaprodi->lecturer->nip,
                'kaprodi_barcode'       => $kaprodi->lecturer->barcode,
                'proposal'              => $proposal,
                'proposal_lecturers'    => $proposal->lecturers,
            ])
            ->setPaper('A4', 'potrait');
        return $pdf->stream('assignment-note.pdf');
    }
}
