<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HotelController extends Controller
{
    /**
     * Display the hotel listing page
     */
    public function index()
    {
        $hotels = Hotel::all();
        return view('admin.index', [
            'page' => 'hotels',
            'hotels' => $hotels
        ]);
    }

    /**
     * Store a newly created hotel
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        // Handle image upload
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('Admin/uploads/'), $imageName);

        // Create hotel
        Hotel::create([
            'name' => $validated['hotel_name'],
            'image' => $imageName,
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel added successfully!');
    }

    /**
     * Show the form for editing the hotel
     */
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.edit', compact('hotel'));
    }
    /**
     * Update the specified hotel
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $hotel = Hotel::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path('Admin/uploads/' . $hotel->image))) {
                File::delete(public_path('Admin/uploads/' . $hotel->image));
            }
            
            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Admin/uploads/'), $imageName);
        } else {
            $imageName = $hotel->image;
        }

        // Update hotel
        $hotel->update([
            'name' => $validated['hotel_name'],
            'image' => $imageName,
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully!');
    }

    /**
     * Delete the specified hotel
     */
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        
        // Delete image file
        if (File::exists(public_path('Admin/uploads/' . $hotel->image))) {
            File::delete(public_path('Admin/uploads/' . $hotel->image));
        }
        
        // Delete hotel record
        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully!');
    }
}