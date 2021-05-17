@extends("layouts.template")
@section('content')
    <div class="col-12 p-0">
        <div class="table-responsive">
            <table class="table table-striped text-center shadow">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->code }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="" class="btn btn-primary mr-1">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection