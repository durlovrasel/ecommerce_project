<!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('home/images/favicon.png') }}" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
    <!-- font awesome style -->
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />

    <style type="text/css">
        .center {
            margin: auto;
            width: 65%;
            text-align: center;
            padding: 30px;
        }

        table,
        th,
        td {
            border: 1px solid rgb(223, 222, 222);
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
        <!-- slider section -->

        <!-- end slider section -->
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="center">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product Title</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <?php $totalPrice = 0; ?>

                @foreach ($carts as $cart)
                    <tbody>
                        <tr>
                            <td>{{ $cart->product_title }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>৳ {{ $cart->price }}</td>
                            <td><img src="/product/{{ $cart->image }}" alt=""
                                    style="width: 165px; height: 200px;"></td>
                            <td><a href="{{ url('remove_cart', $cart->id) }}" class="btn btn-danger" 
                                onclick="confirmation(event)">
                                    Remove Product</a>
                            </td>
                        </tr>
                    </tbody>
                    <?php $totalPrice = $totalPrice + $cart->price; ?>
                @endforeach
            </table>
            <div>
                <strong>
                    <h1 style="font-size: 20px; padding: 40px;">Total Payable Amount: ৳ {{ $totalPrice }}/= Only.</h1>
                </strong>
            </div>
            <div>
                <h1 style="font-size: 25px; padding-bottom: 15px;">Proceed to Order</h1>
                <a href="{{ url('cash_order') }}" class="btn btn-danger">Cash on Delivery</a>
                <a href="{{ url('stripe', $totalPrice) }}" class="btn btn-danger">Pay Using Card</a>
            </div>
        </div>
    </div>


    <!-- why section -->

    <!-- end why section -->

    <!-- arrival section -->

    <!-- end arrival section -->

    <!-- product section -->

    <!-- end product section -->

    <!-- subscribe section -->

    <!-- end subscribe section -->
    <!-- client section -->

    <!-- end client section -->
    <!-- footer start -->

    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>

    <script>
        function confirmation(ev) {
          ev.preventDefault();
          var urlToRedirect = ev.currentTarget.getAttribute('href');  
          console.log(urlToRedirect); 
          swal({
              title: "Are you sure to remove this product",
              text: "You will not be able to revert this!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willCancel) => {
              if (willCancel) {
  
  
                   
                  window.location.href = urlToRedirect;
                 
              }  
  
  
          });
  
          
      }
  </script>
    <!-- jQery -->
    <script src="home/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="home/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="home/js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="home/js/custom.js"></script>
</body>

</html>
