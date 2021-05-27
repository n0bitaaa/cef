@extends("layouts.template")
@section('content')
    <div class="col-12 p-0">
        <h4>Admins</h4>
    @if(Session::has('create'))
        <p class="alert alert-success">{{ Session::get('create') }}</p>
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
                        <th>Code</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->code }}</td>
                        <td>
                            @if($admin->isOnline())
                                <li class="text-success">Online</li>
                            @else
                                <li class="text-secondary">Offline</li>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center align-items-center gap-2 flex-column flex-lg-row">
                        @if($admin->id == Auth::guard('admin')->user()->id)
                            <button class="btn btn-primary" id="edit" data-bs-toggle="modal" data-bs-target="#editModal-{{ $admin->id }}">
                                <i class="far fa-edit"></i>
                            </button>
                            <div class="modal fade" id="editModal-{{ $admin->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                              <div class="modal-dialog">
                                <form action="{{ route('admins.update',$admin->id) }}" method="post">
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
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter you name" value="{{ $admin->name }}" minlength="4" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Code</label>
                                            <div class="input-group flex-nowrap">
                                                <input type="text" class="form-control" id="code" name="code" value="{{ $admin->code }}" readonly></input>
                                                <span class="input-group-text" id="newCode" style="user-select:none;">Generate New</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="c_pw" class="form-label">Current Password<span class="text-muted">(Leave blank if u dont wanna chg)</span></label>
                                            <input type="password" class="form-control" id="c_pw" name="password" placeholder="Enter your current password" minlength="8"></input>
                                        </div>
                                        <div class="mb-3">
                                            <label for="n_pw" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="n_pw" name="n_password" placeholder="Enter your new password" aria-describedby="pwHelp"
                                            minlength="8"></input>
                                            @error('n_password')
                                                <small id="pwHelp" class="form-text text-danger">{{ $message }}</small>
                                            @enderror
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
                            <form action="{{ route('admins.destroy',$admin->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Are you sure to delete this?')">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        @else
                         <p>&nbsp;</p>
                         <p>&nbsp;</p>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $admins->links() }}
        </div>
    </div>
@endsection
@push('functions')
    $('#newCode').click(function(){
        $.ajax({
            url:"{{ route('newCode') }}",
            type:"post",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                $('#code').val(response);
            },
            error:function(error){
                alert('Failed')
            }
        })
    })
@endpush