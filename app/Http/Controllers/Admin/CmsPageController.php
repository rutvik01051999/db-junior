<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cmsPages = CmsPage::orderBy('title')->get();
        return view('admin.cms-pages.index', compact('cmsPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cms-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (CmsPage::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        CmsPage::create($validated);

        return redirect()->route('admin.cms-pages.index')
            ->with('success', 'CMS page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        return view('admin.cms-pages.show', compact('cmsPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CmsPage $cmsPage)
    {
        return view('admin.cms-pages.edit', compact('cmsPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $cmsPage->update($validated);

        return redirect()->route('admin.cms-pages.index')
            ->with('success', 'CMS page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CmsPage $cmsPage)
    {
        $cmsPage->delete();

        return response()->json([
            'success' => true,
            'message' => 'CMS page deleted successfully.'
        ]);
    }

    /**
     * Update CMS page status
     */
    public function updateStatus(Request $request)
    {
        $cmsPage = CmsPage::findOrFail($request->id);
        
        $cmsPage->update([
            'is_active' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
}
