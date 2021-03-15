<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Category;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();

        $total_amount = DB::table('products')->select(DB::raw('sum(quantity * round(price, 2)) AS total_amount'))->first();
   
        return view('admin.product.index', compact('products', 'total_amount'));                 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.product.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'category' => 'required',
            'supplier' => 'required',
            'quantity' => 'required|numeric|min:0',
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
        $product->price = $request->price;
        $product->image = $imageName;
        
        $product->save();
       
        Toastr::success('Product Successfully Created !' ,'Success');

        return redirect()->route('admin.product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,id',
            'category' => 'required',
            'supplier' => 'required',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric',
            'image' => 'mimes:png,jpg,jpeg,bmp'
        ]);

        $product = Product::find($id);

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

            //delete old product image
            if(Storage::disk('public')->exists('product/'.$product->image) && strcmp($product->image, "default.png") != 0)
            {
                Storage::disk('public')->delete('product/'.$product->image);
            }

            $productImage = Image::make($image)->resize(500,333)->stream();

            Storage::disk('public')->put('product/'.$imageName, $productImage);

        } else {
            $imageName = $product->image;
        }

        $product->name = $request->name;
        $product->slug = $slug;
        $product->category_id = Category::find($request->category)->id;
        $product->supplier_id = Supplier::find($request->supplier)->id;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->image = $imageName;
        
        $product->save();
       
        Toastr::success('Product Successfully Updated !' ,'Success');

        return redirect()->route('admin.product.index');
    }

    public function updatePrice(Request $request, $id)
    {
        $this->validate($request, [
            'quantity' => 'nullable|numeric',
            'price' => 'nullable|numeric'
        ]);

        $product = Product::find($id);
        
        $oldItemsTotalPrice = $product->quantity * $product->price;
        
        $additionalQuantity = $request->quantity;
        $newPrice = $request->price;

        $newItemsTotalPrice = $additionalQuantity * $newPrice;

        if(isset($newPrice)) {
            $product->price = ($oldItemsTotalPrice + $newItemsTotalPrice) / ($product->quantity + $additionalQuantity );
        }
        
        if(isset($additionalQuantity)) {
            $product->quantity = $product->quantity + $additionalQuantity;
        }
        
        $product->save();

        Toastr::success('Product Successfully Updated !' ,'Success');

        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        Toastr::success('Product Successfully Deleted !' ,'Success');

        return redirect()->back();
    }
}
