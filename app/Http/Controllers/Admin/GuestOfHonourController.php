<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestOfHonour;
use Illuminate\Http\Request;

class GuestOfHonourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guestOfHonours = GuestOfHonour::latest()->get();
        return view('admin.guest-of-honours.index', compact('guestOfHonours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guest-of-honours.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'season_name' => 'required|string|max:255',
            'guest_name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        GuestOfHonour::create($validated);

        return redirect()->route('admin.guest-of-honours.index')
            ->with('success', 'Guest of Honour created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GuestOfHonour $guestOfHonour)
    {
        return view('admin.guest-of-honours.show', compact('guestOfHonour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuestOfHonour $guestOfHonour)
    {
        return view('admin.guest-of-honours.edit', compact('guestOfHonour'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuestOfHonour $guestOfHonour)
    {
        $validated = $request->validate([
            'season_name' => 'required|string|max:255',
            'guest_name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $guestOfHonour->update($validated);

        return redirect()->route('admin.guest-of-honours.index')
            ->with('success', 'Guest of Honour updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuestOfHonour $guestOfHonour)
    {
        $guestOfHonour->delete();

        return redirect()->route('admin.guest-of-honours.index')
            ->with('success', 'Guest of Honour deleted successfully');
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
            'id' => 'required|exists:guest_of_honours,id',
            'status' => 'required|boolean',
        ]);

        $guestOfHonour = GuestOfHonour::findOrFail($request->id);
        $guestOfHonour->status = $request->status;
        $guestOfHonour->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $guestOfHonour->status ? 'Active' : 'Inactive'
        ]);
    }
}