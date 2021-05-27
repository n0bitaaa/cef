@extends('layouts.template')
@section('content')
    <div class="col-12 p-0">
        <h4 class="mb-4">Add a product</h4>
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" id="product_name" aria-describedby="nameHelp" placeholder="Enter a product name" value="{{ old('name') }}">
                @error('name')
                    <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="image" class="form-label">Choose your product image</label>
                <input type="file" name="image" class="form-control" id="image" aria-describedby="imageHelp">
                @error('image')
                    <small id="imageHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="price" class="form-label">Price</label>
                <div class="input-group flex-nowrap">
                    <input type="text" name="price" class="form-control" id="price" aria-describedby="priceHelp" placeholder="Enter a product price" value="{{ old('price') }}">
                    <span class="input-group-text">Kyats</span>
                </div>
                @error('price')
                    <small id="priceHelp" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection