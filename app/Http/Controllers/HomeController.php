<?php

namespace App\Http\Controllers;

use App\Models\Order;

use App\Models\Cart;
use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;
use Stripe;

use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(9);
        $comments = Comment::latest()->get();
        $replies = Reply::all();
        return view('home.userpage', compact('products', 'comments', 'replies'));
    }


    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype == '1') {
            $total_products = Product::all()->count();
            $total_orders = Order::all()->count();
            $total_users = User::all()->count();
            $orders = Order::all();
            $total_revenue = 0;
            foreach ($orders as $order) {
                $total_revenue = $total_revenue + $order->price;
            }

            $total_order_delivered = Order::where('delivery_status', '=', 'Delivered')
                ->get()->count();

            $total_order_processing = Order::where('delivery_status', '=', 'Processing')
                ->get()->count();

            return view('admin.home', compact(
                'total_products',
                'total_orders',
                'total_users',
                'total_revenue',
                'total_order_delivered',
                'total_order_processing'
            ));
        } else {
            $products = Product::paginate(9);
            $comments = Comment::latest()->get();
            $replies = Reply::all();
            return view('home.userpage', compact('products', 'comments', 'replies'));
        }
    }

    public function product_details($id)
    {
        $product = product::find($id);
        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $users = Auth::user();
            $userid = $users->id;
            $products = product::find($id);
            $product_exist_id = Cart::where('product_id', '=', $id)
                ->where('user_id', '=', $userid)->get('id')->first();
            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                if ($products->discount_price != null) {
                    $cart->price = $products->discount_price * $cart->quantity;
                } else {
                    $cart->price = $products->price * $cart->quantity;
                }
                $cart->save();
                Alert::success('Product added successfully!', 'Product has been added to your cart.');
                return redirect()->back();
            } else {

                $carts = new cart;
                $carts->name = $users->name;
                $carts->phone = $users->phone;
                $carts->email = $users->email;
                $carts->address = $users->address;
                $carts->user_id = $users->id;

                $carts->product_title = $products->title;
                if ($products->discount_price != null) {
                    $carts->price = $products->discount_price * $request->quantity;
                } else {
                    $carts->price = $products->price * $request->quantity;
                }

                $carts->image = $products->image;
                $carts->product_id = $products->id;

                $carts->quantity = $request->quantity;

                $carts->save();
                Alert::success('Product added successfully!', 'Product has been added to your cart.');
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $carts = cart::where('user_id', '=', $id)->get();
            return view('home.showcart', compact('carts'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $carts = cart::find($id);
        $carts->delete();
        Alert::warning('Product removed successfully!', 'Product has been removed from your cart.');
        return redirect()->back();
    }

    public function cash_order()
    {
        $users = Auth::user();
        $userid = $users->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Cash on Delivery';
            $order->delivery_status = 'Processing';

            $order->save();

            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }

        return redirect()->back()->with('message', 'We have received your order. We will get back to you soon.');
    }

    public function stripe($totalPrice)
    {
        return view('home.stripe', compact('totalPrice'));
    }

    public function stripePost(Request $request, $totalPrice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $totalPrice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks for your payment!"
        ]);

        $users = Auth::user();
        $userid = $users->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Paid';
            $order->delivery_status = 'Processing';

            $order->save();

            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order()
    {
        if (Auth::id()) {
            $users = Auth::user();
            $userid = $users->id;
            $orders = Order::where('user_id', '=', $userid)->get();
            return view('home.order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status = 'Cancelled';
        $order->save();

        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if (Auth::id()) {
            $comment = new Comment;
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if (Auth::id()) {
            $reply = new Reply;
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function product_search(Request $request)
    {
        $comments = Comment::latest()->get();
        $replies = Reply::all();
        $search_text = $request->search;
        $products = Product::where('title', 'LIKE', "%$search_text%")
            ->orWhere('category', 'LIKE', "%$search_text%")->paginate(9);

        return view('home.userpage', compact('products', 'comments', 'replies'));
    }

    public function products()
    {
        $products = Product::paginate(9);
        $comments = Comment::latest()->get();
        $replies = Reply::all();
        return view('home.all_products', compact('products', 'comments', 'replies'));
    }

    public function search_product(Request $request)
    {
        $comments = Comment::latest()->get();
        $replies = Reply::all();
        $search_text = $request->search;
        $products = Product::where('title', 'LIKE', "%$search_text%")
            ->orWhere('category', 'LIKE', "%$search_text%")->paginate(9);

        return view('home.all_products', compact('products', 'comments', 'replies'));
    }
}
