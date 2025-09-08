<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'boolean',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('sliders', 'public');
            }

            $slider = Slider::create($validated);

            Log::info('Slider created successfully', [
                'slider_id' => $slider->id,
                'image_path' => $slider->image,
                'status' => $slider->status,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.sliders.index')
                ->with('success', 'Slider created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Slider creation failed - validation error', [
                'errors' => $e->errors(),
                'user_id' => auth()->id()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Slider creation failed - unexpected error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create slider. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully');
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
            'id' => 'required|exists:sliders,id',
            'status' => 'required|boolean',
        ]);

        $slider = Slider::findOrFail($request->id);
        $slider->status = $request->status;
        $slider->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $slider->status ? 'Active' : 'Inactive'
        ]);
    }
}