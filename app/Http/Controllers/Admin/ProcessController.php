<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processes = Process::latest()->get();
        return view('admin.processes.index', compact('processes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.processes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('processes', 'public');
        }

        Process::create($validated);

        return redirect()->route('admin.processes.index')
            ->with('success', 'Process created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Process $process)
    {
        return view('admin.processes.show', compact('process'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Process $process)
    {
        return view('admin.processes.edit', compact('process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Process $process)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($process->image) {
                Storage::disk('public')->delete($process->image);
            }
            $validated['image'] = $request->file('image')->store('processes', 'public');
        }

        $process->update($validated);

        return redirect()->route('admin.processes.index')
            ->with('success', 'Process updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Process $process)
    {
        if ($process->image) {
            Storage::disk('public')->delete($process->image);
        }
        
        $process->delete();

        return redirect()->route('admin.processes.index')
            ->with('success', 'Process deleted successfully');
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
            'id' => 'required|exists:processes,id',
            'status' => 'required|boolean',
        ]);

        $process = Process::findOrFail($request->id);
        $process->status = $request->status;
        $process->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $process->status ? 'Active' : 'Inactive'
        ]);
    }
}
