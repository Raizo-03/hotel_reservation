<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'room_type' => 'required|string|in:Suite,Delux,Regular', // Add validation for room types
            'room_capacity' => 'required|string|in:Family,Double,Single', // Add validation for room capacities
            'payment_type' => 'required|string|in:Cash,Cheque,Credit Card', // Add validation for payment types
        ]);

        // Parse the dates using Carbon
        $start_date = Carbon::parse($validated['start_date']);
        $end_date = Carbon::parse($validated['end_date']);
        $days = $start_date->diffInDays($end_date);

        // Define the rates for each room type and capacity
        $rates = [
            "Single" => ["Regular" => 100, "Delux" => 300, "Suite" => 500],
            "Double" => ["Regular" => 200, "Delux" => 500, "Suite" => 800],
            "Family" => ["Regular" => 500, "Delux" => 800, "Suite" => 1200],
        ];

        // Get the capacity and room type from the validated data
        $capacity = $validated['room_capacity'];
        $type = $validated['room_type'];

        // Check if the rate exists for the selected room type and capacity
        if (!isset($rates[$capacity][$type])) {
            return back()->withErrors(['Invalid room type or capacity']);
        }

        // Calculate the total price
        $rate_per_day = $rates[$capacity][$type];
        $total_price = $rate_per_day * $days;

        // Create a new reservation record
        Reservation::create([
            'customer_name' => $validated['customer_name'],
            'contact_number' => $validated['contact_number'],
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'room_type' => $validated['room_type'],
            'room_capacity' => $validated['room_capacity'],
            'payment_type' => $validated['payment_type'],
            'total_bill' => $total_price,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Reservation successful!');
    }

    public function index()
    {
        // Show the reservation form view
        return view('reservation');
    }
}
