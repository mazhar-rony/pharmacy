<?php

namespace App\Http\Controllers\User;

use App\Product;
use App\Category;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('user.product.index', compact('products'));                 
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('organization')->get();

        return view('user.product.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'category' => 'required',
            'supplier' => 'required',
            'quantity' => 'required|numeric|min:0',
            'low_quantity_alert' => 'required|numeric|min:0',
            'price' => 'required|numeric',
            'image' => 'mimes:png,jpg,jpeg,bmp'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if(isset($image))
        {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('product'))
            {
                Storage::disk('public')->makeDirectory('product');
            }

            $productImage = Image::make($image)->resize(500,333)->stream();

            Storage::disk('public')->put('product/'.$imageName, $productImage);

        } else {
            $imageName = "default.png";
        }

        $product = new Product();

        $product->name = $request->name;
        $product->slug = $slug;
        $product->category_id = Category::find($request->category)->id;
        $product->supplier_id = Supplier::find($request->supplier)->id;
        $product->quantity = $request->quantity;
        $product->low_quantity_alert = $request->low_quantity_alert;
        $product->price = $request->price;
        $product->image = $imageName;
        
        $product->save();
       
        Toastr::success('Product Successfully Created !' ,'Success');

        return redirect()->route('user.product.index');

    }
}
