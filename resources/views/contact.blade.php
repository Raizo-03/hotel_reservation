<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innova&Co</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                    
                <li><a href="{{ route('admin.dashboard') }}">Admin</a></li> 
                </ul>
            </div>
        </div>

        <div class="form-container">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="contitle"><h1>Contact Us</h1> </div>

                <div class="details">
                    <div class="address">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="addrenamess" placeholder="Your name" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone_number" id="phone" placeholder="Your phone number" maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Your email" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="comments">Message</label> 
                            <textarea rows="4" cols="40" name="message" id="comments"></textarea>
                        </div>

                        <div class="submit">
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="footer">
            <h3>Innovatech Solutions © 2025</h3>    
        </div>
    </div>

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif



</body>
</html>
