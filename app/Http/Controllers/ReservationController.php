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
        
        // If days is 0 (same day check-in and check-out), set it to 1
        $days = $days > 0 ? $days : 1;

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

        // Calculate the subtotal (before discount)
        $rate_per_day = $rates[$capacity][$type];
        $subtotal = $rate_per_day * $days;
        
        // Calculate discount based on number of days
        $discountPercent = 0;
        if ($days >= 3 && $days <= 5) {
            $discountPercent = 10; // 10% discount for 3-5 days
        } elseif ($days >= 6) {
            $discountPercent = 15; // 15% discount for 6+ days
        }
        
        $discountAmount = ($subtotal * $discountPercent) / 100;
        $total = $subtotal - $discountAmount;

        // Create a new reservation record
        $reservation = Reservation::create([
            'customer_name' => $validated['customer_name'],
            'contact_number' => $validated['contact_number'],
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'room_type' => $validated['room_type'],
            'room_capacity' => $validated['room_capacity'],
            'payment_type' => $validated['payment_type'],
            'total_bill' => $total,
        ]);

        // Store billing data in session
        $current_time = Carbon::now()->format('F d, Y h:i A');
        
        $billingData = [
            'reservation_id' => $reservation->id,
            'current_time' => $current_time,
            'days' => $days,
            'subtotal' => $subtotal,
            'discountPercent' => $discountPercent,
            'discountAmount' => $discountAmount,
            'total' => $total
        ];
        
        session(['billing_data' => $billingData]);
        
        // Redirect back with success message and session data
        return redirect()->back()->with('success', 'Reservation successful! Click OK to view billing details.');
    }

    public function index()
    {
        // Show the reservation form view
        return view('reservation');
    }
    
    public function showBilling()
    {
        // Get billing data from session
        $billingData = session('billing_data');
        
        if (!$billingData) {
            return redirect()->route('reservation')->with('error', 'No reservation data found.');
        }
        
        // Get the reservation from the database
        $reservation = Reservation::findOrFail($billingData['reservation_id']);
        
        // Remove billing data from session
        session()->forget('billing_data');
        
        return view('billing', [
            'reservation' => $reservation,
            'current_time' => $billingData['current_time'],
            'days' => $billingData['days'],
            'subtotal' => $billingData['subtotal'],
            'discountPercent' => $billingData['discountPercent'],
            'discountAmount' => $billingData['discountAmount'],
            'total' => $billingData['total']
        ]);
    }
}