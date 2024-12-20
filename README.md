achi ơi em lỡ để nhầm chỗ link ở url <li class="nav-item">
                           <a class="nav-link" href="{{url('product')}}">SẢN PHẨM</a>
                        </li> trong file header.blade.php của resources/views/home thì anh chị hay giúp em thành như vầy nhé kể cả route của web và function của Homecontroller cũng sửa từ show_product thành product Thui ạ vì nó bị trùng với admin   
                        route::get('/product',[HomeController::class,'product']);//route
                        
                        //homecontroller   
                        public function product (){
              
        
        $product=Product::paginate(6);
        return view('home.products',compact('product'));

    }
