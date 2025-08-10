<?php

namespace App\Services;

use App\Models\Vote;
use App\Models\Candidate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoteProcessingService
{
    public function processVote($userId, $candidateId, $position)
    {
        return DB::transaction(function () use ($userId, $candidateId, $position) {
            // Check if user already voted for this position
            $cacheKey = "user_vote_{$userId}_{$position}";
            $hasVoted = Cache::get($cacheKey);
            
            if ($hasVoted) {
                throw new \Exception('Anda sudah memilih untuk posisi ini');
            }

            // Create vote record
            $vote = Vote::create([
                'user_id' => $userId,
                'candidate_id' => $candidateId,
                'position' => $position,
            ]);

            // Update candidate vote count
            Candidate::where('id', $candidateId)->increment('vote_count');

            // Cache the vote status
            Cache::put($cacheKey, true, 3600); // 1 hour cache

            // Clear relevant caches
            $this->clearVoteCaches($position);

            return $vote;
        });
    }

    public function clearVoteCaches($position)
    {
        Cache::forget("candidates_{$position}");
        Cache::forget("vote_results_{$position}");
        Cache::forget("total_votes_{$position}");
    }

    public function getCachedCandidates($position)
    {
        $cacheKey = "candidates_{$position}";
        
        return Cache::remember($cacheKey, 300, function () use ($position) {
            return Candidate::where('position', $position)
                ->orderBy('candidate_number')
                ->get();
        });
    }

    public function getCachedVoteStatus($userId, $position)
    {
        $cacheKey = "user_vote_{$userId}_{$position}";
        
        return Cache::remember($cacheKey, 300, function () use ($userId, $position) {
            return Vote::where('user_id', $userId)
                ->where('position', $position)
                ->exists();
        });
    }
}
