@extends('layouts.app')

@section('title', 'Innova&Co')

@section('content')
<div class="container">
    <div class="nav">
        <div id="brand">
            <h1><a href="{{ route('home') }}">INNOVA&Co.</a></h1>
        </div>
    
        <div id="links">
            <ul>    
               <li><a href="{{ route('home') }}">Home</a></li>
                {{-- 
                <li><a href="{{ route('reservation') }}">Reservation</a></li>
                <li><a href="{{ route('company') }}">Company Profile</a></li>--}}
                
                <li><a href="{{ route('contact') }}">Contact</a></li> 
            </ul>
        </div>
    </div>

    <div class="image">
        <img src="{{ asset('images/homeimg.png') }}" alt="Home Image">
        <h1>
            Enjoy Your Dream<br>
            Vacation
        </h1>
        
        <h3>Book hotels, Flights, and other reservation.</h3>
        {{-- <form action="{{ route('company') }}" method="get">
            <input type="submit" value="ABOUT US">
        </form> --}}
    </div>

    <div class="popular">
        <h1>Popular Hotels</h1>
        <div class="gallery" id="hotelGallery">
            @if(isset($hotels) && count($hotels) > 0)
                @foreach($hotels as $hotel)
                    <div class='gallery-item'>
                        <img src='{{ asset("Admin/uploads/{$hotel->image}") }}' alt='Hotel Image'>
                        <div class='item-details'>
                            <p class='description'>{{ $hotel->description }}</p>
                            <p class='price'>₱{{ number_format($hotel->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No hotels available at the moment.</p>
            @endif
        </div>
    </div>
    
    <div class="footer">
        <h3>Innovatech Solutions © {{ date('Y') }}</h3>
    </div>
</div>
@endsection

@section('scripts')
@if(!isset($hotels))
<script>
    fetch('{{ route("fetch.hotels") }}') // Fetch data from PHP route
        .then(response => response.json())
        .then(data => {
            let gallery = document.getElementById("hotelGallery");
            gallery.innerHTML = ""; // Clear existing content

            if (data.error) {
                gallery.innerHTML = `<p>Error: ${data.error}</p>`;
                return;
            }

            data.forEach(hotel => {
                let item = `
                    <div class='gallery-item'>
                    <img src='Admin/uploads/${hotel.image}' alt='Hotel Image'>
                        <div class='item-details'>
                            <p class='description'>${hotel.description}</p>
                            <p class='price'>₱${parseFloat(hotel.price).toFixed(2)}</p>
                        </div>
                    </div>`;
                gallery.innerHTML += item;
            });
        })
        .catch(error => console.error("Error fetching hotels:", error));
</script>
@endif
@endsection