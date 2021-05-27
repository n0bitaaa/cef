@extends('layouts.template')
@section('content')
    <div class="col-12 p-0">
    @if(Session::has('readOne'))
        <p class="alert alert-success">{{ Session::get('readOne') }}</p>
    @endif
    @if(Session::has('readAll'))
            <p class="alert alert-success">{{ Session::get('readAll') }}</p>
    @endif
        <div class="card shadow">
            <div class="card-header">
                <h5 class="d-inline-block mt-2">Notifications</h5>
                <a href="{{ route('readAll') }}" class="float-end btn btn-primary">Mark all as read</a>
            </div>
            <div class="card-body">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <div class="alert alert-success d-flex justify-content-between align-items-center flex-column flex-sm-row" role="alert">
                        <div>
                            [{{ Carbon\Carbon::parse($notification->created_at)->toDayDateTimeString() }}] <strong class="inline">{{ $notification->data['name'] }}</strong> has just logged in.
                        </div>
                        <a href="{{ route('readOne',$notification->id) }}" class="float-end btn btn-success mt-3 m-sm-0">Mark as read</a>
                    </div>
                @empty
                    <p class="text-center">No recent notification.</p>
                @endforelse
                <hr style="#c4c4c4">
                @forelse(auth()->user()->readNotifications as $notification)
                    <div class="alert alert-secondary" role="alert">
                    [{{ Carbon\Carbon::parse($notification->created_at)->toDayDateTimeString() }}] <strong>{{ $notification->data['name'] }}</strong> had logged in.
                    </div>
                @empty
                    <p class="text-center">No past notification.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection