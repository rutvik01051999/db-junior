<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = BannerSection::orderBy('language')->orderBy('sort_order')->get();
        return view('admin.banner-sections.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,hi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('banners', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Clean HTML content from CKEditor
        if (isset($validated['description'])) {
            $validated['description'] = $this->cleanHtmlContent($validated['description']);
        }

        BannerSection::create($validated);

        return redirect()->route('admin.banner-sections.index')
            ->with('success', 'Banner created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerSection $bannerSection)
    {
        return view('admin.banner-sections.edit', compact('bannerSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerSection $bannerSection)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,hi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'remove_current_image' => 'nullable|boolean'
        ]);

        // Handle image removal
        if ($request->has('remove_current_image') && $request->remove_current_image) {
            if ($bannerSection->image) {
                Storage::disk('public')->delete($bannerSection->image);
                $validated['image'] = null;
            }
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bannerSection->image) {
                Storage::disk('public')->delete($bannerSection->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('banners', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Clean HTML content from CKEditor
        if (isset($validated['description'])) {
            $validated['description'] = $this->cleanHtmlContent($validated['description']);
        }

        $bannerSection->update($validated);

        return redirect()->route('admin.banner-sections.index')
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerSection $bannerSection)
    {
        if ($bannerSection->image) {
            Storage::disk('public')->delete($bannerSection->image);
        }
        
        $bannerSection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);
    }

    /**
     * Update banner status
     */
    public function updateStatus(Request $request)
    {
        $banner = BannerSection::findOrFail($request->id);
        
        $banner->update([
            'is_active' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    /**
     * Update sort order
     */
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $item) {
            BannerSection::where('id', $item['id'])->update(['sort_order' => $item['position']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.'
        ]);
    }

    /**
     * Clean HTML content from CKEditor
     */
    private function cleanHtmlContent($content)
    {
        if (empty($content)) {
            return $content;
        }

        // Remove &nbsp; entities
        $content = str_replace('&nbsp;', '', $content);
        
        // Remove empty paragraphs
        $content = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $content);
        
        // Remove paragraphs that only contain <br> tags
        $content = preg_replace('/<p[^>]*>\s*<br[^>]*>\s*<\/p>/i', '', $content);
        
        // Remove paragraphs that only contain whitespace and <br> tags
        $content = preg_replace('/<p[^>]*>\s*(<br[^>]*>\s*)+<\/p>/i', '', $content);
        
        // Clean up multiple consecutive <br> tags
        $content = preg_replace('/(<br[^>]*>\s*){3,}/i', '<br><br>', $content);
        
        // Remove leading/trailing whitespace
        $content = trim($content);
        
        return $content;
    }
}
