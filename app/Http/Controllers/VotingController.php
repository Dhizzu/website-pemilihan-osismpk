<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('vote.selection');
    }

    public function selectionPage()
    {
        $user = Auth::user();
        return view('vote.selection', compact('user'));
    }

    public function showOsisCandidates()
    {
        $user = Auth::user();
        if ($user->has_voted_osis) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah memilih calon Ketua OSIS');
        }

        $candidates = Candidate::where('position', 'osis')->get();
        return view('vote.osis', compact('candidates', 'user'));
    }

    public function showMpkCandidates()
    {
        $user = Auth::user();
        if ($user->has_voted_mpk) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah memilih calon Ketua MPK');
        }

        $candidates = Candidate::where('position', 'mpk')->get();
        return view('vote.mpk', compact('candidates', 'user'));
    }

    public function processVote(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'position' => 'required|in:osis,mpk'
        ]);

        $user = Auth::user();
        $candidate = Candidate::find($request->candidate_id);

        if ($request->position == 'osis' && $user->has_voted_osis) {
            return redirect()->back()->with('error', 'Anda sudah memilih calon Ketua OSIS');
        }

        if  ($request->position == 'mpk' && $user->has_voted_mpk) {
            return redirect()->back()->with('error', 'Anda sudah memilih calon Ketua MPK');
        }

        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $candidate->id,
            'position' => $request->position
        ]);

        if ($request->position == 'osis') {
            $user->has_voted_osis = true;
        } else {
            $user->has_voted_mpk = true;
        }
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Terima kasih, suara anda berhasil direkam!');
    }
}
