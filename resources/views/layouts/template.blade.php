<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crochet Ever After</title>
    <link href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-2">
                <h4 class="py-3 text-center text-secondary">
                    <i class="fab fa-apple me-sm-2"></i>
                    <span class="d-none d-xxl-inline d-xl-inline d-lg-inline">Crochet Ever After</span>
                </h4>
                <div class="list-group text-center text-lg-start text-xl-start text-xxl-start shadow">
                    <span class="list-group-item disabled d-none d-lg-block d-xl-block d-xxl-block">
                        <small class="text-center">CONTROLS</small>
                    </span>
                    <a href="{{ url('admin/dashboard') }}" class="list-group-item list-group-item-action" aria-current="true">
                            <i class="far fa-list-alt me-1"></i>
                            <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Dashboard</span>
                    </a>
                    <a href="{{ route('admins.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-secret me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Admin</span>
                        <span class="d-none d-lg-inline badge bg-secondary text-white
                        rounded-pill float-end">{{ App\Admin::all()->count() }}</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">User</span>
                        <span class="d-none d-lg-inline badge bg-success text-white
                        rounded-pill float-end">{{ App\User::all()->count() }}</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-puzzle-piece me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Product</span>
                        <span class="d-none d-lg-inline badge bg-dark text-white
                        rounded-pill float-end">{{ App\Product::all()->count() }}</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-stream me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Order</span>
                        <span class="d-none d-lg-inline badge bg-warning text-white
                        rounded-pill float-end">{{ App\Order::all()->count() }}</span>
                    </a>
                </div>

                <div class="list-group mt-4 text-center text-lg-start text-xl-start text-xxl-start shadow">
                    <span class="list-group-item disabled d-none d-lg-block d-xl-block d-xxl-block">
                        <small class="text-center">ACTIONS</small>
                    </span>
                    <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-plus me-1"></i>
                            <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new user</span>
                    </a>
                    <a href="{{ route('products.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new product</span>
                    </a>
                    <a href="{{ route('orders.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cart-plus me-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new order</span>
                    </a>
                </div>
                <p class="small text-center text-muted mt-3">&copy; Copyright 2021.All rights reserved.</p>
            </nav>
            <main class="col-10 p-0">
                <nav class="navbar navbar-expand-lg navbar-expand-xl navbar-expand-xxl navbar-light">
                    <div class="flex-fill"></div>
                    <div class="navbar nav">
                        <li class="nav-item me-sm-1">
                            <a class="btn" href="{{ route('noti_index') }}">
                                <i class="fas fa-bell"></i>
                                @if(auth()->user()->unreadNotifications->count())
                                <span class="badge bg-primary rounded-pill" id="noti_count">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>                             
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-dark" data-bs-toggle="dropdown" id="name" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>
                                <span>{{ Auth::guard('admin')->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-center" onclick="document.getElementById('logout').submit();"><i class="fas fa-sign-out-alt me-3"></i>Logout</a>
                                </li>
                                <form action="{{ route('Logout') }}" method="post" id="logout">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row" id="asdf">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js')}}" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    <script src="https://kit.fontawesome.com/1e9d4689e4.js" crossorigin="anonymous"></script>
    @stack('jsfiles')
    <script>
        $(document).ready(function(){
            $(function(){
                $('.list-group .list-group-item').filter(function(){
                    return this.href == location.href}).addClass('active').siblings().removeClass('active');
            })
            setTimeout(() => {
                $('p.alert').remove();
            },3000);
            @stack('functions')
        })
    </script>
</body>
</html>