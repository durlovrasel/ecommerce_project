<?php

namespace App\Http\Controllers;

use PDF;
use Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MyFirstNotification;

class AdminController extends Controller
{
    public function view_category()
    {
        if (Auth::id()) {
            $data = Category::all();
            return view('admin.category', compact('data'));
        } else {
            return redirect('login');
        }
    }

    public function add_category(Request $request)
    {
        $data = new Category();
        $data->category_name = $request->category;
        $data->save();
        return redirect()->back()->with('message', 'The category has been added successfully.');
    }

    public function delete_category($id)
    {
        if (Auth::id()) {
            $data = Category::find($id);
            $data->delete();
            return redirect()->back()->with('message', 'The category has been deleted successfully.');
        } else {
            return redirect('login');
        }
    }

    public function view_product()
    {
        if (Auth::id()) {
            $categories = Category::all();
            return view('admin.products', compact('categories'));
        } else {
            return redirect('login');
        }
    }

    public function add_product(Request $request)
    {
        if (Auth::id()) {
            $product = new product;

            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount_price = $request->dis_price;
            $product->quantity = $request->quantity;
            $product->category = $request->category;

            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
            $product->image = $imagename;

            $product->save();

            return redirect()->back()->with('message', 'The product has been added successfully.');
        } else {
            return redirect('login');
        }
    }

    public function show_product()
    {
        if (Auth::id()) {
            $products = product::all();
            return view('admin.show_product', compact('products'));
        } else {
            return redirect('login');
        }
    }

    public function delete_product($id)
    {
        if (Auth::id()) {
            $product = product::find($id);
            $product->delete();
            return redirect()->back()->with('message', 'The product has been deleted successfully.');
        } else {
            return redirect('login');
        }
    }

    public function update_product($id)
    {
        if (Auth::id()) {
            $products = product::find($id);

            $categories = category::all();
            return view('admin.update_product', compact('products', 'categories'));
        } else {
            return redirect('login');
        }
    }

    public function update_product_confirm(Request $request, $id)
    {
        if (Auth::id()) {
            $products = product::find($id);
            $products->title = $request->title;
            $products->description = $request->description;
            $products->price = $request->price;
            $products->discount_price = $request->dis_price;
            $products->category = $request->category;
            $products->quantity = $request->quantity;

            $image = $request->image;
            if ($image) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('product', $imagename);
                $products->image = $imagename;
            }

            $products->save();

            return redirect()->back()->with('message', 'The product has been updated successfully.');
        } else {
            return redirect('login');
        }
    }

    public function order()
    {
        if (Auth::id()) {
            $orders = order::all();
            return view('admin.order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    public function delivered($id)
    {
        if (Auth::id()) {
            $orders = order::find($id);
            $orders->delivery_status = 'Delivered';
            $orders->payment_status = 'Paid';
            $orders->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function print_pdf($id)
    {
        if (Auth::id()) {
            $order = order::find($id);


            $pdf = PDF::loadView('admin.pdf', compact('order'));
            return $pdf->download('order_details.pdf');
        } else {
            return redirect('login');
        }
    }

    public function send_email($id)
    {
        if (Auth::id()) {
            $orders = Order::find($id);
            return view('admin.email_info', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    public function send_user_email(Request $request, $id)
    {
        if (Auth::id()) {
            $orders = Order::find($id);
            $details = [
                'greeting' => $request->greeting,
                'firstline' => $request->firstline,
                'body' => $request->body,
                'button' => $request->button,
                'url' => $request->url,
                'lastline' => $request->lastline,
            ];

            Notification::send($orders, new MyFirstNotification($details));

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function searchdata(Request $request)
    {
        if (Auth::id()) {
            $searchText = $request->search;
            $orders = Order::where('name', 'LIKE', "%$searchText%")->orWhere('email', 'LIKE', "%$searchText%")->orWhere('phone', 'LIKE', "%$searchText%")->orWhere('product_title', 'LIKE', "%$searchText%")->get();
            return view('admin.order', compact('orders'));
        } else {
            return redirect('login');
        }
    }
}
