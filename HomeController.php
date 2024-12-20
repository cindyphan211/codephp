<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
class HomeController extends Controller
{
    public function index()
    {
        $product=Product::paginate(6);
        return view('home.userpage',compact('product'));
    }
    public function redirect()
    {
       $usertype=Auth::user()->usertype;

       if($usertype=='1')
       {
          $total_product=product::all()->count();
          $total_order=order::all()->count();
          $total_user=user::all()->count();
          $order=order::all();
          $total_revenue=0;
          foreach($order as $order){
            $total_revenue=$total_revenue+$order->price;

          }
          $total_delivered=order::where('delivery_status','=','Đã giao')->get()->count();
          $total_processing=order::where('delivery_status','=','processing')->get()->count();
          return view('admin.home',compact('total_product','total_order','total_user',
          'total_revenue','total_delivered','total_processing'));
       }
       else 
       {
            $product=Product::paginate(6);
            return view('home.userpage',compact('product'));
           
       }
    }
    public function product_details($id){
        $product=product::find($id);
        return view('home.product_details',compact('product'));

    }
    public function add_cart(Request $request,$id){
        if(Auth::id())
        {
           $user=Auth::user();
           $product=product::find($id);
           $cart=new cart;
           $cart->name=$user->name;
           $cart->email=$user->email;
           $cart->phone=$user->phone;
           $cart->address=$user->address;
           $cart->user_id=$user->id;
           $cart->product_title=$product->title;
           if($product->discount_price!=null){
            $cart->price=$product->discount_price*$request->quantity;
           }
           else{
            $cart->price=$product->price*$request->quantity;
            }
           $cart->image=$product->image;
           $cart->Product_id=$product->id;
           $cart->quantity=$request->quantity;

           $cart->save();
           return redirect()->back();


        }
        else
        {
            return redirect('login');
        }
    }
    public function show_cart(){
        if(Auth::id())
        {
            $id=Auth::user()->id;
            $cart=cart::where('user_id','=',$id)->get();
            return view('home.showcart',compact('cart'));
        }
        else{
            return redirect('login');
        }
        
    }
    public function remove_cart($id){
        $cart=cart::find($id);
        $cart->delete();
        return redirect()->back();
    }
    public function cash_order(){
        $user=Auth::user();
        $userid=$user->id;
        $data=cart::where('user_id','=',$userid)->get();
        foreach($data as $data){
            $order=new order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_title=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->Product_id;
            $order->payment_status='Thanh toán khi nhận';
            $order->delivery_status='processing';
            $order->save();

            $cart_id=$data->id;
            $cart = cart::find($cart_id);
            $cart->delete();

        }
        return redirect()->back();

        
    }
    public function show_order()
    {
        if (Auth::id()) 
        {
            $user = Auth::user();
            $userid = $user->id;

            $order = order::where('user_id', '=', $userid)->get();

            return view('home.order', compact('order'));
        } else {
            return redirect('login');
        }
    }
    public function cancel_order($id){
        $order=order::find($id);
        $order->delivery_status="Hủy thành công";
        $order->save();
        return redirect()->back();
    }
    public function show_product (){
              
        
        $product=Product::paginate(6);
        return view('home.products',compact('product'));

    }
    public function show_blog (){
       
        
        return view('home.blog');

    }
    public function about (){
       
        
        return view('home.about');

    }
    public function contact (){
       
        
        return view('home.contact');

    }
    public function testimonial (){
       
        
        return view('home.testimonial');

    }

}
