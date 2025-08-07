<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VotingController extends Controller
{
    /**
     * Tampilkan halaman voting dengan daftar kandidat OSIS dan MPK.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Get candidates grouped by position
        $osisCandidates = Candidate::where('position', 'like', '%OSIS%')->get();
        $mpkCandidates = Candidate::where('position', 'like', '%MPK%')->get();

        // Check voting status
        $hasVotedOSIS = $user->hasVotedOSIS();
        $hasVotedMPK = $user->hasVotedMPK();

        return view('voting.index', compact(
            'osisCandidates',
            'mpkCandidates',
            'hasVotedOSIS',
            'hasVotedMPK'
        ));
    }

    /**
     * Simpan hasil voting.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'position' => 'required|in:OSIS,MPK',
        ]);

        $user = Auth::user();
        $candidate = Candidate::findOrFail($request->candidate_id);

        // Validate position matches candidate
        if (!str_contains($candidate->position, $request->position)) {
            return redirect()->back()->with('error', 'Posisi kandidat tidak valid!');
        }

        // Check if user already voted for this position
        if ($request->position === 'OSIS' && $user->hasVotedOSIS()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan suara untuk OSIS!');
        }

        if ($request->position === 'MPK' && $user->hasVotedMPK()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan suara untuk MPK!');
        }

        // Simpan vote baru
        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $request->candidate_id,
        ]);

        return redirect()->route('voting.results')->with('success', 'Terima kasih, suara Anda berhasil disimpan!');
    }

    /**
     * Tampilkan hasil voting.
     */
    public function results(): View
    {
        $user = Auth::user();
        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = Vote::count();

        $hasVotedOSIS = $user->hasVotedOSIS();
        $hasVotedMPK = $user->hasVotedMPK();

        return view('voting.results', compact('candidates', 'totalVotes', 'hasVotedOSIS', 'hasVotedMPK'));
    }
}
