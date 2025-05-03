<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innova&Co</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


</head>
<body>
    <div class="container">
        <div class="nav">
            <div id="brand">
                <h1><a href="index.html">INNOVA&Co.</a></h1>
                </div>
        
    
        <div id="links">
            <ul>    
               <li><a href="{{ route('home') }}">Home</a></li>
                
                <li><a href="{{ route('reservation') }}">Reservation</a></li>

                <li><a href="{{ route('company') }}">Company Profile</a></li>
                
                <li><a href="{{ route('contact') }}">Contact</a></li> 
                
                <li><a href="{{ route('admin.dashboard') }}">Admin</a></li> 
            </ul>
        </div>
    
        </div>




        <div class="reservation-container">
<form action="{{ route('reservation.store') }}" method="POST">
    @csrf

    <!-- This is the form flexbox-->
    <div class="contitle"><h1>Make A Reservation</h1></div>

    <div class="reservation">
        <div class="time"></div>
        <input type="hidden" id="time-input" name="current_time">
        
        <div class="reservation-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" name="customer_name" id="customer_name" placeholder="Your name" size="35px" required>
        </div>
        <div class="reservation-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" placeholder="Your number" size="35px" required>
        </div>

        <div class="reservation-group">
            <label for="name">Reservation Date:</label>
            <div class="date-range-picker">
                <div class="date-container">
                    <i class="fa fa-calendar"></i>
                    <input type="text" id="start-date" name="start_date" class="datepicker" placeholder="Select date start" size="45px" required>
                </div>
                <span>to</span>
                <div class="date-container">
                    <i class="fa fa-calendar"></i>
                    <input type="text" id="end-date" name="end_date" class="datepicker" placeholder="Select date end" required>
                </div>
            </div>
            
            <div class="reservation-group">
                <label for="room-type" class="roomlabel">Room Type:</label>
                <div class="room-type">
                    <label>
                        <input type="radio" name="room_type" value="Suite"> Suite
                    </label>
                    <label>
                        <input type="radio" name="room_type" value="Delux"> Deluxe
                    </label>
                    <label>
                        <input type="radio" name="room_type" value="Regular"> Regular
                    </label>
                </div>
            </div>
            
            <div class="reservation-group">
                <label for="room-capacity" class="roomlabel">Room Capacity:</label>
                <div class="room-capacity">
                    <label>
                        <input type="radio" name="room_capacity" value="Family"> Family
                    </label>
                    <label>
                        <input type="radio" name="room_capacity" value="Double"> Double
                    </label>
                    <label>
                        <input type="radio" name="room_capacity" value="Single"> Single
                    </label>
                </div>
            </div>
            
            <div class="reservation-group">
                <label for="room-payment" class="roomlabel">Payment Type:</label>
                <div class="room-capacity">
                    <label>
                        <input type="radio" name="payment_type" value="Cash"> Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_type" value="Cheque"> Cheque
                    </label>
                    <label>
                        <input type="radio" name="payment_type" value="Credit Card"> Credit Card
                    </label>
                </div>
            </div>
        </div>

        <div class="submit-reservation">
            <div class="button-reserve">
                <button type="submit">Submit Reservation</button>
                <button type="reset" value="Clear">Clear</button>
            </div>
        </div>
    </div>
</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let roomType = document.querySelector('input[name="room_type"]:checked');
        let roomCapacity = document.querySelector('input[name="room_capacity"]:checked');
        let paymentType = document.querySelector('input[name="payment_type"]:checked');

        if (!roomCapacity) {
            alert("Please select a room capacity");
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (!roomType) {
            alert("Please select a room type");
            event.preventDefault();
            return;
        }

        if (!paymentType) {
            alert("Please select a payment type");
            event.preventDefault();
            return;
        }
    });
});
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('billing.show') }}";
            }
        });
    </script>
@endif

@if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif


</body>
</html>


<script>
    function updateTime() {
        const timeDiv = document.querySelector(".time");
        const timeInput = document.getElementById("time-input");
        const now = new Date();

        // Format the date & time
        const options = { 
            month: "long", 
            day: "numeric", 
            year: "numeric", 
            hour: "numeric", 
            minute: "2-digit", 
            hour12: true 
        };
        const formattedTime = now.toLocaleString("en-US", options).replace(",", "");

        timeDiv.textContent = formattedTime; // Update visible time
        timeInput.value = formattedTime; // Store time in hidden input
    }

    function setTimeValue() {
        updateTime(); // Ensure the latest time is set before submission
    }

    updateTime(); // Call function on page load
    setInterval(updateTime, 1000); // Update every second
</script>



<script>
    var startPicker = flatpickr("#start-date", {
        dateFormat: "Y-m-d", // Ensure compatibility with PHP (YYYY-MM-DD)
        onChange: function(selectedDates, dateStr) {
            document.getElementById("start-date").value = dateStr;
            endPicker.set("minDate", dateStr);
        }
    });

    var endPicker = flatpickr("#end-date", {
        dateFormat: "Y-m-d", // Ensure compatibility with PHP (YYYY-MM-DD)
        onChange: function(selectedDates, dateStr) {
            document.getElementById("end-date").value = dateStr;
            startPicker.set("maxDate", dateStr);
        }
    });
</script>
