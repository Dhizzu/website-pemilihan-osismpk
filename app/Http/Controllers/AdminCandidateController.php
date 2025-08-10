<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCandidateController extends Controller
{
    /**
     * Display a listing of the candidates.
     */
    public function index()
    {
        $candidates = Candidate::latest()->paginate(10);
        return view('admin.candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new candidate.
     */
    public function create()
    {
        return view('admin.candidates.create');
    }

    /**
     * Store a newly created candidate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_number' => 'required|integer|unique:candidates,candidate_number,NULL,id,position,' . $request->position,
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create([
            'candidate_number' => $validated['candidate_number'],
            'name' => $validated['name'],
            'position' => $validated['position'],
            'visi' => $validated['visi'],
            'misi' => $validated['misi'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate added successfully!');
    }

    /**
     * Show the form for editing the specified candidate.
     */
    public function edit(Candidate $candidate)
    {
        return view('admin.candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified candidate in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'candidate_number' => 'required|integer|unique:candidates,candidate_number,' . $candidate->id,
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $candidate->photo_path;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($candidate->photo_path) {
                Storage::disk('public')->delete($candidate->photo_path);
            }
            $photoPath = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update([
            'candidate_number' => $validated['candidate_number'],
            'name' => $validated['name'],
            'position' => $validated['position'],
            'visi' => $validated['visi'],
            'misi' => $validated['misi'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate updated successfully!');
    }

    /**
     * Remove the specified candidate from storage.
     */
    public function destroy(Candidate $candidate)
    {
        // Delete photo if exists
        if ($candidate->photo_path) {
            Storage::disk('public')->delete($candidate->photo_path);
        }

        $candidate->delete();

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate deleted successfully!');
    }
}
