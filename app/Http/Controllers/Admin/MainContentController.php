<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainContents = MainContent::orderBy('id', 'desc')->get();
        return view('admin.main-contents.index', compact('mainContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.main-contents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'participation_categories_1' => 'nullable|string',
            'participation_categories_2' => 'nullable|string',
            'participation_categories_3' => 'nullable|string',
            'participation_categories_4' => 'nullable|string',
            'timeline_1' => 'nullable|string',
            'timeline_2' => 'nullable|string',
            'timeline_3' => 'nullable|string',
            'timeline_4' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('main-contents', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        MainContent::create($validated);

        return redirect()->route('admin.main-contents.index')
            ->with('success', 'Main content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mainContent = MainContent::findOrFail($id);
        return view('admin.main-contents.show', compact('mainContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mainContent = MainContent::findOrFail($id);
        return view('admin.main-contents.edit', compact('mainContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mainContent = MainContent::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'participation_categories_1' => 'nullable|string',
            'participation_categories_2' => 'nullable|string',
            'participation_categories_3' => 'nullable|string',
            'participation_categories_4' => 'nullable|string',
            'timeline_1' => 'nullable|string',
            'timeline_2' => 'nullable|string',
            'timeline_3' => 'nullable|string',
            'timeline_4' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($mainContent->image) {
                Storage::disk('public')->delete($mainContent->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('main-contents', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        $mainContent->update($validated);

        return redirect()->route('admin.main-contents.index')
            ->with('success', 'Main content updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mainContent = MainContent::findOrFail($id);
        
        // Delete image if exists
        if ($mainContent->image) {
            Storage::disk('public')->delete($mainContent->image);
        }
        
        $mainContent->delete();

        return response()->json([
            'success' => true,
            'message' => 'Main content deleted successfully.'
        ]);
    }

    /**
     * Update main content status
     */
    public function updateStatus(Request $request)
    {
        $mainContent = MainContent::findOrFail($request->id);
        
        $mainContent->update([
            'is_active' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
}