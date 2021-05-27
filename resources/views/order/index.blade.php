@extends('layouts.template')
@section('content')
<div class="col-12 p-0">
    <h4>Orders</h4>
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
                    <th>Due Date</th>
                    <th>State</th>
                    <th>Createdby</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
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
                                                            {{ $product->pivot->qty}} x {{ $product->name }} ({{ number_format($product->pivot->price) }} Kyats) @if($product->pivot->rmk)({{ $product->pivot->rmk }}) @endif<br>
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
                                                    <td>{{ Carbon\Carbon::now()->diffInDays($order->due_date) }} days</td>
                                                </tr>
                                                <tr>
                                                    <td>Due Date</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
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
                        <div class="modal fade" id="reorderModal-{{ $order->id }}" tabindex="-1" aria-labelledby="reorderModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="reorderModal">Reordering order({{ $order->id }})</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('orders.update',$order->id) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
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
                                            <input type="number" name="w_week" class="form-control" id="w_week" placeholder="Enter your waiting week">
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </form>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection