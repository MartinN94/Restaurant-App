<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function index(){

        $foods = Food::latest()->paginate(10);
        return view('food.index', compact('foods'));

    }

    public function create(){
        return view('food.create');
    }

    public function store(Request $request){

        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|integer',
            'category'=>'required',
            'image'=>'required|mimes:png,jpeg,jpg'
        ]);
        $image = $request->file('image');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);

        Food::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'category_id'=>$request->category,
            'image'=> $name
        ]);

        return redirect()->route('food.index')->with('message', 'Food is created!');
    }

    public function edit($id){

        $food = Food::find($id);
        return view('food.edit', compact('food'));
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|integer',
            'category'=>'required',
            'image'=>'mimes:png,jpeg,jpg'
        ]);

        $food = Food::find($id);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
        }else{
            $name = $food->image;
        }

        $food->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'category_id'=>$request->category,
            'image'=>$name
        ]);

        return redirect()->route('food.index')->with('message', 'Food info is updated!');
    }

    public function destroy($id){
        $food = Food::find($id);
        $food->delete();

        return redirect()->route('food.index')->with('message', 'Food is deleted!');
    }

    public function listFood(){
        $categories = Category::with('food')->get();
        return view('index', compact('categories'));
    }

    public function view($id){
        $food = Food::find($id);
        return view('food.view', compact('food'));
    }
}
