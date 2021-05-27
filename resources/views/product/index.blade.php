@extends('layouts.template')
@section('content')
<div class="col-12 p-0">
    <nav class="navbar">
        <h4>Products</h4>
        <form class="d-flex mb-1" action="{{ route('products.search') }}" method="post">
        @csrf
            <input class="form-control me-2" name="product" placeholder="Search" aria-label="Search" autocomplete="off" list="products">
            <datalist id="products">
                @foreach(App\Product::all() as $product)
                    <option value="{{$product->name}}">{{ $product->name }}</option>
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
    <div class="table-responsive">
        <table class="table table-striped shadow text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Createdby</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <a href="" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $product->id }}">
                            <img src="{{ $product->image }}" alt="product-image" width="38px" height="38px" class="rounded-circle">
                        </a>
                        <div class="modal fade" id="imageModal-{{ $product->id }}" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="imageModal">{{ $product->name }} ({{ number_format($product->price) }} Kyats)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                    <img src="{{ $product->image }}" alt="product-image" style="width:100%;height:100%;object-fit:contain;">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td>{{ number_format($product->price) }} Kyats</td>
                    <td>{{ $product->admin->name }}</td>
                    <td class="d-flex justify-content-center align-items-center gap-2 flex-column flex-lg-row">
                        <button class="btn btn-primary" id="edit" data-bs-toggle="modal" data-bs-target="#editModal-{{ $product->id }}">
                            <i class="far fa-edit"></i>
                        </button>
                        <div class="modal fade" id="editModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal">Edit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter you product name" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Choose your product image</label>
                                        <img src="{{ $product->image }}" alt="product-image" class="img-fluid mb-3 rounded">
                                        <input type="file" name="image" class="form-control" id="image" aria-describedby="imageHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</span></label>
                                        <div class="input-group flex-nowrap">
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter your product price" value="{{ $product->price }}" required></input>
                                            <span class="input-group-text">Kyats</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </form>
                          </div>
                        </div>
                        <form action="{{ route('products.destroy',$product->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure to delete this?')">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>No data</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
</div>
@endsection
@push('functions')

@endpush