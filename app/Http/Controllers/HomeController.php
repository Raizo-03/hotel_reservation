<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel; // Assuming you have a Hotel model

class HomeController extends Controller
{
    public function index()
    {
        // You can pass this or rely on AJAX later
        $hotels = Hotel::all(); // or paginate/sort etc.
        return view('index', compact('hotels'));
    }

    public function fetchHotels()
    {
        try {
            $hotels = Hotel::all(['image', 'description', 'price']);
            return response()->json($hotels);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch hotels.'], 500);
        }
    }
}
