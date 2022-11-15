<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .center {
            margin: auto;
            width: 100%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
        }

        .font_size {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
            font-weight: bold;
        }

        .img_size {
            width: 200px;
            height: 70px;
        }

        .th_color {
            background: skyblue;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="row p-0 m-0 proBanner" id="proBanner">
            <div class="col-md-12 p-0 m-0">
                <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                    <div class="ps-lg-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates,
                                and more with this template!</p>
                            <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo"
                                target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="https://www.bootstrapdash.com/product/corona-free/"><i
                                class="mdi mdi-home me-3 text-white"></i></a>
                        <button id="bannerClose" class="btn border-0 p-0">
                            <i class="mdi mdi-close text-white me-0"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        @include('admin.header')
        <div class="main-panel">
            <div class="content-wrapper">
                <!-- partial -->
                <h2 class="font_size">All Orders</h2>
                <div style="padding-left: 400px; padding-bottom: 30px; padding-top: 30px;">
                    <form action="{{ url('search') }}" method="GET">
                        @csrf
                        <input type="text" name="search" placeholder="Search for something" style="color: black;">
                        <input type="submit" value="Search" class="btn btn-outline-primary"
                            style="font-weight: bold; color: white;">
                    </form>
                </div>
                <div class="row justify-content-center">
                    <table class="center">
                        <tr class="th_color">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Product Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Image</th>
                            <th>Action</th>
                            <th>Print PDF</th>
                            <th>Send Email</th>
                        </tr>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->phone }}</td>
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
                                        <a href="{{ url('delivered', $order->id) }}" class="btn btn-success"
                                            onclick="return confirm('Are You Sure the Order has been Delivered?')">Delivered</a>
                                    @else
                                        <h2 style="color: rgb(141, 243, 141)"><b>Delivered</b></h2>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('print_pdf', $order->id) }}" class="btn btn-primary">Print</a>
                                </td>
                                <td>
                                    <a href="{{ url('send_email', $order->id) }}" class="btn btn-info">Send</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16">
                                    <p style="font-size: 17px; color: red;"><b>No Data Found!</b></p>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        <!-- End custom js for this page -->
</body>

</html>
