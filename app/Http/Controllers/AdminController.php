<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Contact;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    
    // Dashboard
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
    
        // Load data and return view
        return view('Admin.index', [
            'page' => 'dashboard',
            // other data
        ]);
    }
    
    // Reservations
    public function reservations()
    {
        $reservations = Reservation::all();
        return view('admin.index', ['page' => 'reservations', 'reservations' => $reservations]);
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return redirect()->route('admin.reservations.index');
    }

    // Contacts
    public function contacts()
    {
        $contacts = Contact::all();
        return view('admin.index', ['page' => 'contacts', 'contacts' => $contacts]);
    }

    // Hotels
    public function hotels()
    {
        $hotels = Hotel::all();
        return view('admin.index', ['page' => 'hotels', 'hotels' => $hotels]);
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        Hotel::create([
            'name' => $request->hotel_name,
            'image' => $imagePath,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.hotels.index');
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::find($id);
        $hotel->delete();
        return redirect()->route('admin.hotels.index');
    }

    // In AdminController.php
public function fetchReservationsData()
{
    // Get room type distribution
    $roomTypes = DB::table('reservations')
        ->select('room_type', DB::raw('count(*) as count'))
        ->groupBy('room_type')
        ->get();

    // Get payment type totals
    $paymentTypes = DB::table('reservations')
        ->select('payment_type', DB::raw('SUM(total_bill) as total'))
        ->groupBy('payment_type')
        ->get();

    return response()->json([
        'roomTypes' => $roomTypes,
        'paymentTypes' => $paymentTypes
    ]);
}
}
