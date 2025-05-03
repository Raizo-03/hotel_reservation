@extends('Admin/app')

@section('content')
    <div id="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.reservations.index') }}">Reservations</a>
        <a href="{{ route('admin.contacts.index') }}">Messages</a>
        <a href="{{ route('admin.hotels.index') }}">Hotels</a>
        <a href="#" onclick="confirmLogout()">Logout</a>

<form id="logout-form" action="{{ route('admin.logout') }}" method="GET" style="display: none;">
    @csrf
</form>

    </div>

    <div id="main-content">
        @if($page == 'dashboard')
            <h2>Dashboard</h2>
            <p>Welcome to the admin panel.</p>

            <div class="row">
                <!-- Room Type Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Room Type Distribution</div>
                        <div class="card-body">
                            <canvas id="roomTypeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Payment Type Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Total Bill by Payment Type</div>
                        <div class="card-body">
                            <canvas id="paymentTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($page == 'reservations')
            <h2>Reservations</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Customer Name</th><th>Contact Number</th>
                        <th>Start Date</th><th>End Date</th><th>Room Type</th>
                        <th>Capacity</th><th>Payment Type</th><th>Total Bill</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                        <tr>
                            <td>{{ $res->id }}</td>
                            <td>{{ $res->customer_name }}</td>
                            <td>{{ $res->contact_number }}</td>
                            <td>{{ $res->start_date }}</td>
                            <td>{{ $res->end_date }}</td>
                            <td>{{ $res->room_type }}</td>
                            <td>{{ $res->room_capacity }}</td>
                            <td>{{ $res->payment_type }}</td>
                            <td>₱{{ $res->total_bill }}</td>
                            <td>
                                <a href="{{ route('admin.reservations.delete', $res->id) }}" class="btn btn-danger delete-btn">Delete</a>
                                <button class="btn btn-info view-btn" data-id="{{ $res->id }}" 
                                    data-name="{{ $res->customer_name }}" 
                                    data-number="{{ $res->contact_number }}" 
                                    data-start="{{ $res->start_date }}" 
                                    data-end="{{ $res->end_date }}" 
                                    data-roomtype="{{ $res->room_type }}" 
                                    data-roomcap="{{ $res->room_capacity }}" 
                                    data-payment="{{ $res->payment_type }}" 
                                    data-total="{{ $res->total_bill }}">View</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($page == 'contacts')
            <h2>Messages</h2>
            <table class="table table-bordered">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Message</th></tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phone_number }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($page == 'hotels')
           <div class="container">
            <h2>Hotels</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Add Hotel Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Add New Hotel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="hotel_name" class="form-label">Hotel Name</label>
                            <input type="text" name="hotel_name" id="hotel_name" placeholder="Hotel Name" required class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" id="image" required class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" placeholder="Description" required class="form-control"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" placeholder="Price" required class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Add Hotel</button>
                    </form>
                </div>
            </div>
            
            <!-- Hotels List -->
            <div class="card">
                <div class="card-header">
                    <h4>Hotel Listings</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hotels as $hotel)
                                <tr>
                                    <td>{{ $hotel->id }}</td>
                                    <td><img src="{{ asset('Admin/uploads/' . $hotel->image) }}" width="100" alt="{{ $hotel->name }}"></td>
                                    <td>{{ $hotel->name }}</td>
                                    <td>₱{{ number_format($hotel->price, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="{{ route('admin.hotels.delete', $hotel->id) }}" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this hotel?')">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hotels found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
<div id="reservationModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservation Details</h5>
                <button type="button" class="close" id="closeModalX" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="reservation-details">
                    <p>
                        <span><strong>Name:</strong></span>
                        <span id="modal-name">sdasa</span>
                    </p>
                    <p>
                        <span><strong>Contact Number:</strong></span>
                        <span id="modal-number">12321</span>
                    </p>
                    <p>
                        <span><strong>Start Date:</strong></span>
                        <span id="modal-start">Apr 3, 2025</span>
                    </p>
                    <p>
                        <span><strong>End Date:</strong></span>
                        <span id="modal-end">Apr 4, 2025</span>
                    </p>
                    <p>
                        <span><strong>Room Type:</strong></span>
                        <span id="modal-roomtype">Suite</span>
                    </p>
                    <p>
                        <span><strong>Room Capacity:</strong></span>
                        <span id="modal-roomcap">Family</span>
                    </p>
                    <p>
                        <span><strong>Payment Type:</strong></span>
                        <span id="modal-payment">Cash</span>
                    </p>
                    <p>
                        <span><strong>Total Bill:</strong></span>
                        <span>₱<span id="modal-total">1200.00</span></span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>


    </div>


@endsection

<script>
function confirmLogout() {
    if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('reservationModal');
    const closeModalBtn = document.getElementById('closeModal');
    const closeModalX = document.getElementById('closeModalX');
    
    // Function to open modal with reservation data
    function openModal(data) {
        document.getElementById('modal-name').textContent = data.name;
        document.getElementById('modal-number').textContent = data.number;
        document.getElementById('modal-start').textContent = formatDate(data.start);
        document.getElementById('modal-end').textContent = formatDate(data.end);
        document.getElementById('modal-roomtype').textContent = data.roomtype;
        document.getElementById('modal-roomcap').textContent = data.roomcap;
        document.getElementById('modal-payment').textContent = data.payment;
        document.getElementById('modal-total').textContent = data.total;
        
        modal.style.display = 'flex';
    }
    
    // Format dates to be more readable
    function formatDate(dateString) {
        // Try to format the date if it's a valid date string
        try {
            const date = new Date(dateString);
            if (!isNaN(date.getTime())) {
                return date.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric'
                });
            }
        } catch (e) {
            // If there's an error, return the original string
        }
        return dateString;
    }
    
    // Handle View button clicks
    const viewButtons = document.querySelectorAll('.view-btn');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const data = {
                name: this.getAttribute('data-name'),
                number: this.getAttribute('data-number'),
                start: this.getAttribute('data-start'),
                end: this.getAttribute('data-end'),
                roomtype: this.getAttribute('data-roomtype'),
                roomcap: this.getAttribute('data-roomcap'),
                payment: this.getAttribute('data-payment'),
                total: this.getAttribute('data-total')
            };
            openModal(data);
        });
    });
    
    // Close modal when clicking close button
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Close modal when clicking X button
    if (closeModalX) {
        closeModalX.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('{{ route("admin.fetch-reservations-data") }}') 
            .then(response => response.json())
            .then(data => {
                // Room Type Chart
                const roomLabels = data.roomTypes.map(item => item.room_type);
                const roomCounts = data.roomTypes.map(item => item.count);

                new Chart(document.getElementById('roomTypeChart'), {
                    type: 'pie',
                    data: {
                        labels: roomLabels,
                        datasets: [{
                            label: 'Number of Reservations',
                            data: roomCounts,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    }
                });

                // Payment Type Chart
                const paymentLabels = data.paymentTypes.map(item => item.payment_type);
                const paymentTotals = data.paymentTypes.map(item => item.total);

                new Chart(document.getElementById('paymentTypeChart'), {
                    type: 'bar',
                    data: {
                        labels: paymentLabels,
                        datasets: [{
                            label: 'Total Bill Amount (₱)',
                            data: paymentTotals,
                            backgroundColor: ['#4CAF50', '#FF9800', '#2196F3'],
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    });
</script>