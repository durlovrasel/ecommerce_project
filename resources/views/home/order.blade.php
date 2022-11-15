<!DOCTYPE html>
<html>

<head>
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
        .img_size {
            width: 100px;
            height: 100px;
        }

        th,
        td {
            margin-left: auto;
            margin-left: auto;
            text-align: center;

        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')

        <div class="row justify-content-center" style="margin-left: auto; margin-right: auto;">
            <table class="table table-dark table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col">Product Title</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Status</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->product_title }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->delivery_status }}</td>
                            <td>
                                <img src="/product/{{ $order->image }}" alt="" class="img_size">
                            </td>
                            <td>
                                @if ($order->delivery_status == 'Processing')
                                    <a onclick="return confirm('Are you sure to cancel the order?')"
                                        href="{{ url('cancel_order', $order->id) }}" class="btn btn-warning"
                                        style="color: white;">Cancel Order</a>
                                @elseif ($order->delivery_status == 'Delivered')
                                    <button type="button" class="btn btn-info" disabled>Delivered</button>
                                @else
                                    <button type="button" class="btn btn-danger" disabled>Cancelled</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
