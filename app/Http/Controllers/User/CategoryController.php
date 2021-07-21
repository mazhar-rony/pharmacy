<?php

namespace App\Http\Controllers\User;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return view('user.category.index', compact('categories'));
    }

    public function create()
    {
        return view('user.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:categories'
        ]);

        $category = new Category();

        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        
        $category->save();

        Toastr::success('Category Successfully Created !' ,'Success');

        return redirect()->route('user.category.index');
    }
}
