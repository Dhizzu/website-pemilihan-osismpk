<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\VoteProcessingService;

class OptimizedVotingController extends Controller
{
    protected $voteService;

    public function __construct(VoteProcessingService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function index()
    {
        // Use eager loading to reduce queries
        $user = auth()->user();
        
        // Cache candidate data
        $osisCandidates = $this->voteService->getCachedCandidates('OSIS');
        $mpkCandidates = $this->voteService->getCachedCandidates('MPK');
        
        // Cache vote status
        $hasVotedOSIS = $this->voteService->getCachedVoteStatus($user->id, 'OSIS');
        $hasVotedMPK = $this->voteService->getCachedVoteStatus($user->id, 'MPK');
        
        return view('voting.optimized', compact(
            'osisCandidates',
            'mpkCandidates',
            'hasVotedOSIS',
            'hasVotedMPK'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'position' => 'required|in:OSIS,MPK',
        ]);

        try {
            $vote = $this->voteService->processVote(
                auth()->id(),
                $request->candidate_id,
                $request->position
            );

            return response()->json([
                'success' => true,
                'message' => 'Vote berhasil disimpan!',
                'redirect' => route('voting.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getResults()
    {
        $cacheKey = 'vote_results_all';
        
        return Cache::remember($cacheKey, 60, function () {
            return [
                'osis' => DB::table('candidates')
                    ->where('position', 'OSIS')
                    ->select('name', 'candidate_number', 'vote_count')
                    ->orderBy('candidate_number')
                    ->get(),
                'mpk' => DB::table('candidates')
                    ->where('position', 'MPK')
                    ->select('name', 'candidate_number', 'vote_count')
                    ->orderBy('candidate_number')
                    ->get(),
                'total_voters' => DB::table('users')->count(),
                'total_votes' => DB::table('votes')->count(),
            ];
        });
    }
}
