@extends('layouts.template')
@section('content')
<div class="col-12 p-0">
    <nav class="navbar">
        <h4>Orders</h4>
        <form class="d-flex mb-1" action="{{ route('orders.search') }}" method="post">
        @csrf
            <input class="form-control me-2" name="order" placeholder="Search" aria-label="Search" autocomplete="off" list="orders">
            <datalist id="orders">
                @foreach(App\Order::all() as $order)
                    <option value="{{$order->user->name}}">{{ $order->user->name }}</option>
                @endforeach
            </datalist>
            <button class="btn btn-outline-dark" type="submit">Search</button>
        </form>
    </nav>
@if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
@endif
@if(Session::has('update'))
    <p class="alert alert-info">{{ Session::get('update') }}</p>
@endif
@if(Session::has('delete'))
        <p class="alert alert-danger">{{ Session::get('delete') }}</p>
@endif
@if(Session::has('complete'))
        <p class="alert alert-dark">{{ Session::get('complete') }}</p>
@endif
    <div class="table-responsive">
        <table class="table table-striped shadow text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Order Date</th>
                    <th>Due Date</th>
                    <th>Queue</th>
                    <th>State</th>
                    <th>Createdby</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ Carbon\Carbon::parse($order->updated_at)->toFormattedDateString() }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
                    <td>
                        @if( App\Order::where('state',0)->orderBy('queue')->first()->queue == $order->queue)
                            <span style="background-color:#3CB371;color:white;border-radius:20px;padding:2px 5px;">{{ $order->queue }}</span>
                        @else
                            {{ $order->queue }}
                        @endif
                    </td>
                    <td>
                        @if($order->state==0)
                            <a href="{{ route('orderComplete',$order->id) }}" class="btn btn-warning" onclick="return confirm('Are you sure u finish this order?')">Pending</a>
                        @else
                            <a class="btn btn-success disabled">Delivered</a>
                        @endif
                    </td>
                    <td>{{ $order->admin->name }}</td>
                    <td class="d-flex justify-content-center align-items-center gap-2 flex-column flex-lg-row">
                        <button class="btn btn-primary" id="edit" data-bs-toggle="modal" data-bs-target="#editModal-{{ $order->id }}">
                            <i class="far fa-eye"></i>
                        </button>
                        <div class="modal fade" id="editModal-{{ $order->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModal">Order({{ $order->id }})</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-start">
                                        <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{ $order->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Product</td>
                                                    <td>
                                                        @foreach($order->products as $product)
                                                            @if($product->pivot->qty>1){{ $product->pivot->qty }} x @endif{{ $product->name }} ({{ number_format($product->pivot->price) }} Kyats) @if($product->pivot->rmk)({{ $product->pivot->rmk }}) @endif<br>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total item</td>
                                                    <td>{{ $order->totl_qty }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Date</td>
                                                    <td>{{ Carbon\Carbon::parse($order->updated_at)->toFormattedDateString() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Waiting weeks</td>
                                                    <td>{{ $order->w_week }} weeks</td>
                                                </tr>
                                                <tr>
                                                    <td>Remaining Days</td>
                                                    @if($order->state==0)
                                                        <td>{{ Carbon\Carbon::now()->diffInDays($order->due_date)+1 }} days</td>
                                                    @else
                                                        <td> -</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Due Date</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order queue</td>
                                                    <td>{{ $order->queue }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </div>
                          </div>
                        </div>
                        <form action="{{ route('orders.destroy',$order->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure to delete this?')">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                        @if($order->state==1)
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#reorderModal-{{ $order->id }}">
                            <i class="fas fa-undo-alt"></i>
                        </button>
                        @endif
                        <div class="modal fade text-start" id="reorderModal-{{ $order->id }}" tabindex="-1" aria-labelledby="reorderModal-{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reorderModal-{{ $order->id }}">Reordering order({{ $order->id }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('orders.update',$order->id) }}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row product_row">
                                                <div class="row mb-3 product0">
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
                                                <div class="row mb-3 product1">
                                                </div>
                                                    @error('products')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <button class="btn btn-primary me-2 add_row" onclick="event.preventDefault();">+ Add Row</button>
                                                    <button class="btn btn-danger delete_row" onclick="event.preventDefault();">- Delete Row</button>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <label for="w_week" class="form-label">Waiting week</label>
                                                    <input type="number" name="w_week" class="form-control" id="w_week" min="1" placeholder="Enter your waiting week" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Order Again</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>No order.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection
@push('functions')
let row_number = 1;
$('.modal-body .add_row').click(function(event){
    let new_row_number = row_number - 1;
    $('.product'+ row_number).html($('.product'+ new_row_number).html());
    $('.product_row').append('<div class="row mb-3 product'+ (row_number+1) +'"></div>');
    row_number++;
});

$('.modal-body .delete_row').click(function(event){
    event.preventDefault();
    if(row_number>1){
        $('.product'+(row_number-1)).html('');
        row_number--;
    }
});
@endpush