<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order PDF</title>
</head>
<body>
    <h1>Order Details</h1>
    <h3>Customer Id: {{ $order->user_id }}</h3>
    <h3>Name: {{ $order->name }}</h3>
    <h3>Email: {{ $order->email }}</h3>
    <h3>Phone: {{ $order->phone }}</h3>
    <h3>Address: {{ $order->address }}</h3>
    <h3>Product Id: {{ $order->product_id }}</h3>
    <h3>Product Name: {{ $order->product_title }}</h3>
    <h3>Quantity: {{ $order->quantity }}</h3>
    <h3>Price: {{ $order->price }}</h3>
    <h3>Payment Status: {{ $order->payment_status }}</h3>
    <h3>Product Image: </h3>
    <br><br>
    <img height="250" width="450" src="product/{{ $order->image }}" alt="">
</body>
</html>