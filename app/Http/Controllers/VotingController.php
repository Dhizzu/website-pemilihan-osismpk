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
     * Tampilkan halaman voting dengan daftar kandidat.
     */
    public function index(): View|RedirectResponse
    {
        // Cek apakah user sudah voting
        if (Auth::user()->hasVoted()) {
            return redirect()->route('voting.results');
        }

        $candidates = Candidate::all();
        return view('voting.index', compact('candidates'));
    }

    /**
     * Simpan hasil voting.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = Auth::user();

        // Cek kembali apakah user sudah voting untuk mencegah duplikasi
        if ($user->hasVoted()) {
            return redirect()->route('voting.results');
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
        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = Vote::count();

        return view('voting.results', compact('candidates', 'totalVotes'));
    }
}
