<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        // Check voting status - only for regular users
        if ($user instanceof \App\Models\User) {
            $hasVotedOSIS = $user->hasVotedOSIS();
            $hasVotedMPK = $user->hasVotedMPK();
        } else {
            // Admin users don't vote
            $hasVotedOSIS = false;
            $hasVotedMPK = false;
        }

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
        
        // Prevent admin users from voting
        if ($user instanceof \App\Models\Admin) {
            return redirect()->back()->with('error', 'Admin tidak dapat memberikan suara!');
        }

        $candidate = Candidate::findOrFail($request->candidate_id);

        // Validate position matches candidate
        if (!Str::contains($candidate->position, $request->position)) {
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

        // Check if user has completed both votes and is not admin
        if ($user->hasVotedOSIS() && $user->hasVotedMPK()) {
            // Log out the user after completing both votes
            Auth::logout();
            
            // Invalidate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('success', 'Terima kasih! Anda telah berhasil memberikan suara untuk OSIS dan MPK. Anda telah keluar dari sistem.');
        }

        return redirect()->route('voting.index')->with('success', 'Terima kasih, suara Anda berhasil disimpan!');
    }

    /**
     * Tampilkan hasil voting.
     */
    public function results(): View
    {
        $user = Auth::user();
        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = Vote::count();

        // Check if the user is an admin or regular user
        if ($user instanceof \App\Models\Admin) {
            // Admin users don't vote, so set voting status to false
            $hasVotedOSIS = false;
            $hasVotedMPK = false;
        } else {
            // Regular users can vote
            $hasVotedOSIS = $user->hasVotedOSIS();
            $hasVotedMPK = $user->hasVotedMPK();
        }

        return view('admin.results', compact('candidates', 'totalVotes', 'hasVotedOSIS', 'hasVotedMPK'));
    }
}
