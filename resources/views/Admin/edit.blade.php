@extends('Admin/app')

@section('content')
<div class="container mt-5">
    <h2>Edit Hotel</h2>
    
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
    
    <div class="card">
        <div class="card-header">
            <h4>Edit Hotel Details</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="hotel_name" class="form-label">Hotel Name</label>
                    <input type="text" name="hotel_name" id="hotel_name" value="{{ $hotel->name }}" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <div class="mt-2">
                        <p>Current Image:</p>
                        <img src="{{ asset('Admin/uploads/' . $hotel->image) }}" width="100" alt="{{ $hotel->name }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{ $hotel->description }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" value="{{ $hotel->price }}" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Hotel</button>
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection