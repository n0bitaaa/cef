<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Crochet Ever After</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/frontend.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
      <a class="navbar-brand ms-2" href="{{ route('frontend.index') }}">Crochet Ever After</a>
      <button class="navbar-toggler py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">          <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse text-end" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-2"></i>
              <span>{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <form action="{{ route('Logout') }}" method="post">
                @csrf
                <li><button class="dropdown-item" type="submit">Logout</button></li>
              </form>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-2 col-md-3 col-0"></div>
      <div class="col-sm-8 col-md-6 col-12">
        @foreach($orders as $order)
          @if($order->state==0)
            <div class="alert alert-warning text-center" role="alert">
              " Current working order - ({{ App\Order::where('state',0)->orderBy('queue')->first()->queue }}) "
            </div>
          @else
            <div class="alert alert-success text-center" role="alert">
              " Your order has already been delivered! "
            </div>
          @endif
        @endforeach
          <div class="table-responsive">
            <table class="table table-bordered table-dark text-start" id="order_table">
              @forelse($orders as $order)
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
                    <td>Remaining Days</td>
                      @if($order->state==0)
                        <td>{{ Carbon\Carbon::now()->diffInDays($order->due_date)+1 }} days</td>
                      @else
                        <td> -</td>
                      @endif
                  </tr>
                  <tr>
                    <td>Due Date</td>
                    <td>{{ \Carbon\Carbon::parse($order->due_date)->toFormattedDateString() }}</td>
                  </tr>
                </tbody>
              @empty
              <tbody>
                <tr>
                  <td>Name</td>
                  <td>{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                  <td>Product</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Total item</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Order Date</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Waiting weeks</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Remaining Days</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Due Date</td>
                  <td>-</td>
                </tr>
              </tbody>
              @endforelse
            </table>
          </div>
          <div>
            @foreach($orders as $order)
              @if($order->state==0)
                <div class="alert alert-primary d-inline-block float-start mt-1" role="alert" id="order">
                  Your order number - {{$order->queue}}
                </div>
                <button class="btn float-end text-white d-inline-block mt-1" id="download" onclick="event.preventDefault();" type="button">Download as JPG</button>
              @else
                <div></div>
                <button class="btn btn-primary d-inline-block mt-1 disabled float-end" id="download" type="button">Download as JPG</button>
              @endif
            @endforeach
          </div>
      </div>
      <div class="col-sm-2 col-md-3 col-12">

      </div>
    </div><!--row-->
  </div><!--container-->
  <div class="mt-5 text-white d-flex justify-content-center align-items-center" id="ty">
    <p class="text-center">
      "Thank you for shopping with us.We always try best and the best for our customers" &#9829;
    </p>
  </div>
    <footer class="footer text-white-50 text-center">
      2021&copy;copyright.All rights reserved.
    </footer>
    <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>
    <script>
    if(window.performance.navigation.type==0){
      Swal.fire({!! Session::pull('alert.config') !!});
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/canvas2image.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/1e9d4689e4.js" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $('#download').click(function(){
          var elm = $('#order_table').get(0);
          var lebar = "600";
          var tinggi = "300";
          var type="jpg";
          var filename = "cef";
          html2canvas(elm).then(function(canvas){
            var canWidth = canvas.width;
            var canHeight = canvas.height;
            var img = Canvas2Image.convertToImage(canvas,canWidth,canHeight);
            Canvas2Image.saveAsImage(canvas,lebar,tinggi,type,filename);
          })
        })
      })
    </script>
</body>
</html>