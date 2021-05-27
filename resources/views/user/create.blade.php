@extends('layouts.template')
@section('content')
    <div class="col-12 p-0">
        <h4 class="mb-4">Add a user</h4>
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Enter a username" value="{{ old('name') }}">
                @error('name')
                    <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="pwd" aria-describedby="pwdHelp" placeholder="Enter a password">
                @error('password')
                    <small id="pwdHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="pwd-confirm" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="pwd-confirm" aria-describedby="pwd-confirmHelp" placeholder="Enter your password again">
                @error('password_confirmation')
                    <small id="pwd-confirmHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Enter a phone number" value="{{ old('phone') }}">
                @error('phone')
                    <small id="phoneHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter an address" aria-describedby="addressHelp">{{ old('address') }}</textarea>
                @error('address')
                    <small id="addressHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection