<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processes = Process::with('steps')->latest()->get();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'steps' => 'required|array|min:1',
            'steps.*.sub_title' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('processes', 'public');
        }

        $process = Process::create([
            'title' => $validated['title'],
            'image' => $validated['image'] ?? null,
            'status' => $validated['status'] ?? true,
        ]);

        // Create process steps
        foreach ($validated['steps'] as $step) {
            ProcessStep::create([
                'process_id' => $process->id,
                'sub_title' => $step['sub_title'],
                'description' => $step['description'],
                'status' => true,
            ]);
        }

        return redirect()->route('admin.processes.index')
            ->with('success', 'Process created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Process $process)
    {
        $process->load('steps');
        return view('admin.processes.show', compact('process'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Process $process)
    {
        $process->load('steps');
        return view('admin.processes.edit', compact('process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Process $process)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'steps' => 'required|array|min:1',
            'steps.*.id' => 'nullable|exists:process_steps,id',
            'steps.*.sub_title' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($process->image) {
                Storage::disk('public')->delete($process->image);
            }
            $validated['image'] = $request->file('image')->store('processes', 'public');
        }

        $process->update([
            'title' => $validated['title'],
            'image' => $validated['image'] ?? $process->image,
            'status' => $validated['status'] ?? $process->status,
        ]);

        // Get existing step IDs
        $existingStepIds = $process->steps->pluck('id')->toArray();
        $submittedStepIds = collect($validated['steps'])->pluck('id')->filter()->toArray();
        
        // Delete steps that are no longer in the request
        $stepsToDelete = array_diff($existingStepIds, $submittedStepIds);
        ProcessStep::whereIn('id', $stepsToDelete)->delete();

        // Update or create steps
        foreach ($validated['steps'] as $step) {
            if (isset($step['id']) && $step['id']) {
                // Update existing step
                ProcessStep::where('id', $step['id'])
                    ->where('process_id', $process->id)
                    ->update([
                        'sub_title' => $step['sub_title'],
                        'description' => $step['description'],
                    ]);
            } else {
                // Create new step
                ProcessStep::create([
                    'process_id' => $process->id,
                    'sub_title' => $step['sub_title'],
                    'description' => $step['description'],
                    'status' => true,
                ]);
            }
        }

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
        
        // Delete associated steps (cascade delete will handle this automatically)
        $process->steps()->delete();
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
