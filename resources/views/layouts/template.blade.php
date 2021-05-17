<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crochet Ever After</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <nav class="col-2">
                <h4 class="py-3 text-center text-secondary">
                    <i class="fab fa-apple mr-2"></i>
                    <span class="d-none d-xxl-inline d-xl-inline d-lg-inline">Crochet Ever After</span>
                </h4>
                <div class="list-group text-center text-lg-left text-xl-left text-xxl-left border shadow">
                    <span class="list-group-item disabled d-none d-lg-block d-xl-block d-xxl-block">
                        <small class="text-center">CONTROLS</small>
                    </span>
                    <a href="{{ url('admin/dashboard') }}" class="list-group-item list-group-item-action" aria-current="true">
                            <i class="far fa-list-alt mr-1"></i>
                            <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Dashboard</span>
                    </a>
                    <a href="{{ url('admin/admins') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user-secret mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Admin</span>
                        <span class="d-none d-lg-inline badge bg-secondary text-white
                        rounded-pill float-right">20</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-user mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">User</span>
                        <span class="d-none d-lg-inline badge bg-success text-white
                        rounded-pill float-right">20</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-puzzle-piece mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Product</span>
                        <span class="d-none d-lg-inline badge bg-dark text-white
                        rounded-pill float-right">20</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-stream mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Order</span>
                        <span class="d-none d-lg-inline badge bg-primary text-white
                        rounded-pill float-right">20</span>
                    </a>
                </div>

                <div class="list-group mt-4 text-center text-lg-left text-xl-left text-xxl-left shadow">
                    <span class="list-group-item disabled d-none d-lg-block d-xl-block d-xxl-block">
                        <small class="text-center">ACTIONS</small>
                    </span>
                    <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-plus mr-1"></i>
                            <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new user</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new product</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-cart-plus mr-1"></i>
                        <span class="d-none d-lg-inline d-xl-inline d-xxl-inline">Add new order</span>
                    </a>
                </div>
            </nav>
            <main class="col-10 p-0">
                <nav class="navbar navbar-expand-lg navbar-expand-xl navbar-expand-xxl navbar-light bg-light">
                    <div class="flex-fill"></div>
                    <div class="navbar nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-dark" data-toggle="dropdown" id="name">
                                <i class="fas fa-user-circle mr-2"></i>
                                <span>Thet Tun Aung</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" onclick="document.getElementById('logout').submit();">Logout</a>
                                </li>
                                <form action="{{ route('adminLogout') }}" method="post" id="logout">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/1e9d4689e4.js" crossorigin="anonymous"></script>
</body>
</html>