<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::orderBy('language')->latest()->get();
        return view('admin.participants.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.participants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,hi',
            'title' => 'required|string|max:255',
            'number_of_participants' => 'required|integer|min:1',
            'status' => 'boolean',
        ]);

        Participant::create($validated);

        return redirect()->route('admin.participants.index')
            ->with('success', 'Participant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        return view('admin.participants.show', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        return view('admin.participants.edit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,hi',
            'title' => 'required|string|max:255',
            'number_of_participants' => 'required|integer|min:1',
            'status' => 'boolean',
        ]);

        $participant->update($validated);

        return redirect()->route('admin.participants.index')
            ->with('success', 'Participant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->route('admin.participants.index')
            ->with('success', 'Participant deleted successfully');
    }

    /**
     * Update the status of the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:participants,id',
            'status' => 'required|boolean',
        ]);

        $participant = Participant::findOrFail($request->id);
        $participant->status = $request->status;
        $participant->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $participant->status ? 'Active' : 'Inactive'
        ]);
    }
}