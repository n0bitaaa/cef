@extends('layouts.template')
@section('content')
    <div class="col-12 p-0">
    @if(Session::has('readOne'))
        <p class="alert alert-success">{{ Session::get('readOne') }}</p>
    @endif
    @if(Session::has('readAll'))
            <p class="alert alert-success">{{ Session::get('readAll') }}</p>
    @endif
    @if(Session::has('deleteAll'))
            <p class="alert alert-danger">{{ Session::get('deleteAll') }}</p>
    @endif
        <div class="card shadow">
            <div class="card-header">
                <h5 class="d-inline-block mt-2">Notifications</h5>
                @if(auth()->user()->unreadNotifications->count())
                    <a href="{{ route('readAll') }}" class="float-end btn btn-primary d-inline-block"><i class="far fa-eye d-sm-none d-block"></i><span class="d-none d-sm-block">Mark all as read</span></a>
                @endif
                @if(auth()->user()->notifications->count())
                    <a href="{{ route('deleteAll') }}" class="float-end btn btn-danger d-inline-block me-3"><i class="fas fa-trash d-sm-none d-block"></i><span class="d-none d-sm-block">Delete all</span></a>
                @endif
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