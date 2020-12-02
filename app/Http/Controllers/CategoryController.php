<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required'
        ]);
        Category::create([
            'name' => $request->name
        ]);
        return redirect()->route('category.index')->with('message', 'Category is created!');
    }

    public function edit($id){
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name'=>'required'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('category.index')->with('message', 'Category is updated!');
    }

    public function destroy($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('message', 'Category is deleted!');
    }
}
