@extends('layouts.template')
@section('content')
    <div class="col-12 p-0">
        <nav class="navbar">
            <h4>Users</h4>
            <form class="d-flex mb-1" action="{{ route('users.search') }}" method="post">
            @csrf
                <input class="form-control me-2" name="user" placeholder="Search" aria-label="Search" autocomplete="off" list="users">
                <datalist id="users">
                    @foreach(App\User::all() as $user)
                        <option value="{{$user->name}}">{{ $user->name }}</option>
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
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Createdby</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->admin->name }}</td>
                        <td>
                            @if($user->isUserOnline())
                                <li class="text-success">Online</li>
                            @else
                                <li class="text-secondary">Offline</li>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center align-items-center gap-2 flex-column flex-lg-row">
                            <button class="btn btn-primary" id="edit" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}">
                                <i class="far fa-edit"></i>
                            </button>
                            <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('users.update',$user->id) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                    <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter a username" value="{{ $user->name }}" minlength="4" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="c_pw">Enter current password<span class="small text-muted">(Leave blank if u dont wanna change)</span></label>
                                            <input type="password" name="c_pw" class="form-control" id="c_pw" placeholder="Enter user's current password" minlength="8">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="n_pw">Enter new password</label>
                                            <input type="password" name="password" class="form-control" id="n_pw" placeholder="Enter user's new password" minlength="8">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="phone">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter a phone number" value="{{ $user->phone }}" minlength="5" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter an address" minlength="5" required>{{ $user->address }}</textarea>
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
                            <form action="{{ route('users.destroy',$user->id) }}" method="post">
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
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection