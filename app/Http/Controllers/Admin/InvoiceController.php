<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();

        return view('admin.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $invoice_no = Invoice::whereDate('created_at', new \DateTime('today',))->max('invoice_no');
        
        if($invoice_no != NULL)
        {
            $invoice_no += 1;
        }
        else
        {
            // Here Date is in UTC timezone so added +6 hours to make local timezone
            $invoice_no = (int)(date('Y').date('m').date('d', strtotime('+6 hours'))."0001");
        }
        

        return view('admin.invoice.create4', compact('categories', 'invoice_no'));
    }

    public function getProducts(Request $request)
    {
        $category = $request->category;
        
        if($request->has('category'))
        {
            $products =  Category::find($category)->products()->get();
            
            return response()->json($products);
            //return Category::find($request->category)->products()->get();
        }
    }

    public function getQuantity(Request $request)
    {
        if($request->has('product'))
        {
            $quantity = Product::where('id', $request->product)->first();

            return response()->json($quantity);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
