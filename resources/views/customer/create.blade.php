@extends('layout.sidenav-layout')

@section('content')
    <section class="bg-white p-4">
        <div class="text-end">
            <!-- Base Buttons -->
            <a href="{{ route('customer.index') }}" class="btn btn-primary waves-effect waves-light">Back</a>
        </div>

        <form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Basic Input -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Basic Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Basic File input -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                @error('address')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Basic File input -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <hr>
            <div class="">
                <button type="submit" class="btn btn-primary waves-effect weves-light">Create</button>
            </div>
        </form>
    </section>
@endsection
