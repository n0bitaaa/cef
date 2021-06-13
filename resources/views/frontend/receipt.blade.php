<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/receipt.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-0">

            </div>
            <div class="col-md-6 col-12">
                <span class="text-center d-block brand mt-3"><span style="color:#F08080;">C</span>ro<span style="color:#6495ED;">c</span>het <span style="color:#7CFC00;">E</span>ve<span style="color:#FF4500;">r</span> A<span style="color:#F4A460;">f</span>ter</span>
                <span class="text-center d-block hm"><em>Handmade Products</em></span>
                <div class="table-responsive mt-5">
                    <div class="mb-3">
                        <span class="text-white text-center thanks d-block">
                            "Dear {{ Auth::user()->name }} , Thank You for shopping with us."<br>
                        </span>
                    </div>
                    <table class="table table-bordered table-dark text-left">
                        @foreach($orders as $order)
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
                                <td>Due Date</td>
                                <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
                            </tr>
                            <tr>
                                <td>Order Code</td>
                                <td>{{ $order->queue }}</td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>

            </div>
            <div class="col-md-3 col-0"></div>
        </div>
        <footer class="footer text-white-50 text-center">
          2021&copy;copyright.All rights reserved.
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/1e9d4689e4.js" crossorigin="anonymous"></script>
</body>
</html>