<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <div>
                <form action="{{ url('search_product') }}" method="GET">
                    @csrf
                    <input type="text" name="search" placeholder="Search for Something" style="width: 500px;">
                    <input type="submit" value="search">
                </form>
            </div>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{ url('product_details', $product->id) }}" class="option1">
                                    Product Details
                                </a>
                                <form action="{{ url('add_cart', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" name="quantity" value="1" min="1"
                                                style="width: 100px;">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" value="Add to Cart">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="product/{{ $product->image }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                {{ $product->title }}
                            </h5>
                            @if ($product->discount_price != null)
                                <h6 style="color: rgb(9, 194, 9)">
                                    Discount Price
                                    <br>
                                    ৳ {{ $product->discount_price }}
                                </h6>

                                <h6 style="text-decoration: line-through; color: blue">
                                    Price
                                    <br>
                                    ৳ {{ $product->price }}
                                </h6>
                            @else
                                <h6 style="color: blue">
                                    Price
                                    <br>
                                    ৳ {{ $product->price }}
                                </h6>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <span style="padding-top: 20px;">
                {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
            </span>
        </div>
    </div>
</section>
