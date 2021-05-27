@extends('layouts.template')
@section('content')
<div class="col-12 p-0">
    <h4 class="mb-4">Create an order</h4>
    <form action="{{ route('orders.store') }}" method="post">
        @csrf
        <div class="row" id="product_row">
            <div class="row mb-3" id="product0">
                <div class="col-xxl-4 col-4">
                    <select class="form-select" aria-label="products-select" name="products[]">
                    <option value="">Choose your product</option>
                    @foreach( App\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ number_format($product->price) }} Kyats)</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-xxl-4 col-3">
                    <input type="number" name="quantities[]" class="form-control" value="1" min="1" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" placeholder="Quantity"/>
                </div>
                <div class="col-xxl-4 col-5">
                    <input type="text" name="remarks[]" class="form-control" placeholder="Remark" autocomplete="off" />
                </div>
            </div>
            <div class="row mb-3" id="product1"></div>
            @error('products')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <button id="add_row" class="btn btn-primary me-2">+ Add Row</button>
                <button id='delete_row' class="btn btn-danger">- Delete Row</button>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <label for="w_week" class="form-label">Waiting week</label>
                <input type="number" name="w_week" class="form-control" min="1" id="w_week" placeholder="Enter your waiting week" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                @error('w_week')
                    <small class="text-danger">{{ "This field is reqired" }}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
            <select class="form-select" aria-label="user-select" name="user_id">
                <option value="">Choose user</option>
                @foreach( App\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
@push('functions')
    let row_number = 1;
    $('#add_row').click(function(e){
        e.preventDefault();
        let new_row_number = row_number - 1;
        $('#product'+ row_number).html($('#product'+ new_row_number).html());
        $('#product_row').append('<div class="row mb-3" id="product'+ (row_number+1) +'"></div>');
        row_number++;
    });

    $('#delete_row').click(function(e){
        e.preventDefault();
        if(row_number>1){
            $('#product'+(row_number-1)).html('');
            row_number--;
        }
    });
@endpush