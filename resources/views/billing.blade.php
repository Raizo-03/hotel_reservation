<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Information</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
               <style>

           body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .receipt-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: #333 solid 1px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .customer-info, .billing-info {
            margin-top: 20px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .billing-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .billing-table th, .billing-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        .billing-table th {
            background-color: #007bff;
            color: white;
            text-align: left;
        }
        .total {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="nav">
            <div id="brand">
                <h1><a href="{{ route('home') }}">INNOVA&Co.</a></h1>
            </div>
        
            <div id="links">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('reservation') }}">Reservation</a></li>
                    <li><a href="{{ route('company') }}">Company Profile</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
        
        <div class="reservation-container">
            <div class="contitle"><h1>Billing Information</h1></div>

            <div class="receipt-container">
                <div class="header">
                    <p>Enjoy our <strong>10% discount</strong> for 3-5 days of reservation or <br>
                    Enjoy our <strong>15% discount</strong> for 6 days or above of reservation</p>
                </div>

                <div class="customer-info">
                    <div class="row"><strong>Customer Name:</strong> <span>{{ $reservation->customer_name }}</span></div>
                    <div class="row"><strong>Contact Number:</strong> <span>{{ $reservation->contact_number }}</span></div>
                    <div class="row"><strong>Date Reserved:</strong> <span>{{ $current_time }}</span></div>
                </div>

                <div class="customer-info">
                    <div class="row"><strong>Date of Reservation:</strong></div>
                    <div class="row"><strong>From:</strong> <span>{{ $reservation->start_date->format('F d, Y') }}</span></div>
                    <div class="row"><strong>To:</strong> <span>{{ $reservation->end_date->format('F d, Y') }}</span></div>
                </div>

                <div class="customer-info">
                    <div class="row"><strong>Room Type:</strong> <span>{{ $reservation->room_type }}</span></div>
                    <div class="row"><strong>Room Capacity:</strong> <span>{{ $reservation->room_capacity }}</span></div>
                    <div class="row"><strong>Payment Type:</strong> <span>{{ $reservation->payment_type }}</span></div>
                </div>

                <div class="billing-info">
                    <table class="billing-table">
                        <tr>
                            <th>BILLING STATEMENTS</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>No. of Days:</td>
                            <td>{{ $days }}</td>
                        </tr>
                        <tr>
                            <td>Sub-Total:</td>
                            <td>₱{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td>₱{{ number_format($discountAmount, 2) }}</td>
                        </tr>
                        <tr class="total">
                            <td>Total Bill:</td>
                            <td>₱{{ number_format($total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="submit-reservation">
                <div class="button-reserve">
                    <button onclick="window.location.href='{{ route('reservation') }}';">Make New Reservation</button>
                    <button onclick="window.location.href='{{ route('home') }}';">Return to Home</button>
                </div>
            </div>
        </div>

        <div class="footer"><h3>Innovatech Solutions © 2025</h3></div>
    </div>
</body>
</html>