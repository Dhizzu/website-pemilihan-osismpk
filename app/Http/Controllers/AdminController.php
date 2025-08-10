<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function results(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $osisCandidates = Candidate::where('position', 'like', '%OSIS%')
                ->withCount('votes')
                ->get()
                ->map(function ($candidate) {
                    return [
                        'id' => $candidate->id,
                        'name' => $candidate->name,
                        'position' => $candidate->position,
                        'photo' => $candidate->photo,
                        'votes_count' => $candidate->votes_count,
                        'percentage' => $candidate->votes_count > 0 ? 
                            round(($candidate->votes_count / max(Candidate::where('position', 'like', '%OSIS%')->withCount('votes')->get()->sum('votes_count'), 1)) * 100, 2) : 0
                    ];
                });

            $mpkCandidates = Candidate::where('position', 'like', '%MPK%')
                ->withCount('votes')
                ->get()
                ->map(function ($candidate) {
                    return [
                        'id' => $candidate->id,
                        'name' => $candidate->name,
                        'position' => $candidate->position,
                        'photo' => $candidate->photo,
                        'votes_count' => $candidate->votes_count,
                        'percentage' => $candidate->votes_count > 0 ? 
                            round(($candidate->votes_count / max(Candidate::where('position', 'like', '%MPK%')->withCount('votes')->get()->sum('votes_count'), 1)) * 100, 2) : 0
                    ];
                });

            return response()->json([
                'osis' => $osisCandidates,
                'mpk' => $mpkCandidates,
                'totalVotes' => Vote::count(),
                'osisTotalVotes' => Candidate::where('position', 'like', '%OSIS%')->withCount('votes')->get()->sum('votes_count'),
                'mpkTotalVotes' => Candidate::where('position', 'like', '%MPK%')->withCount('votes')->get()->sum('votes_count'),
                'lastUpdated' => now()->format('H:i:s')
            ]);
        }

        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = Vote::count();

        return view('admin.results', compact('candidates', 'totalVotes'));
    }
}
