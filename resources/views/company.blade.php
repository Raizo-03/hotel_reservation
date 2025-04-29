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
                </ul>
            </div>
        </div>

        <div class="companyimg">
            <img src="{{ asset('images/company.png') }}" alt="Company Image">
        </div>

        <div class="companytitle">
            <h1>Innovatech Solutions</h1>
            <div class="description">
                <h3>
                    At Innovatech Solutions, we specialize in cutting-edge technology and innovative solutions to streamline business operations 
                    and enhance customer experiences. Our mission is to provide high-quality, efficient, and user-friendly digital solutions 
                    tailored to meet modern demands. From software development to IT consulting, we are committed to driving progress through technology.
                </h3>
            </div>
        </div>

        <div class="team">
            <h1>Our Team</h1>
            <div class="gallery">
                <div class="gallery-item">
                    <img src="{{ asset('images/ejay.png') }}" alt="Eduardo">
                    <div class="item-details">
                        <p class="description">Eduardo II Buscato</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/krissa.jpeg') }}" alt="Krissa">
                    <div class="item-details">
                        <p class="description">Krissa Mae Beringuel</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <h3>Innovatech Solutions © 2025</h3>
        </div>
    </div>
</body>
</html>
