<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:102400',
            'is_active' => 'sometimes|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/front/assets/video', $filename);
            
            $video = new Video();
            $video->title = $validated['title'];
            $video->path = 'front/assets/video/' . $filename;
            $video->is_active = $request->has('is_active');
            $video->save();

            return redirect()->route('admin.videos.index')
                ->with('success', 'Video uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload video.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:102400', // Max 100MB
            'is_active' => 'boolean'
        ]);

        $video->title = $validated['title'];
        $video->is_active = $request->has('is_active');

        // Handle file upload if a new video is provided
        if ($request->hasFile('video')) {
            // Delete old video
            Storage::delete('public/' . $video->path);
            
            $file = $request->file('video');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/front/assets/video', $filename);
            $video->path = 'front/assets/video/' . $filename;
        }

        $video->save();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        // Delete the video file
        Storage::delete('public/' . $video->path);
        
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video deleted successfully.');
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
            'id' => 'required|exists:videos,id',
            'status' => 'required|boolean',
        ]);

        $video = Video::findOrFail($request->id);
        $video->is_active = $request->status;
        $video->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $video->is_active ? 'Active' : 'Inactive'
        ]);
    }
}
