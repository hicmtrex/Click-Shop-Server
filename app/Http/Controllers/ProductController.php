<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
        $products = Product::all();
        return $products;
    }
    public function paginate_products()
    {
        $products = Product::paginate(9);
        return $products;
    }


    public function few_products()
    {
        return Product::all()->take(4);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if ($request->hasFile('image')) {
            $imageFullName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageFullName);
            $product = new Product();
            $product->name = $request->name;
            $product->image = $imageFullName;
            $product->images = $request->images;
            $product->price = $request->price;
            $product->color = $request->color;
            $product->sizes = $request->sizes;
            $product->price = $request->price;
            $product->gender = $request->gender;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->image = Storage::url("images/" . $product->image);

            $product->save();
            return response($product, 201);
        } else {

            $product = new Product();
            $product->name = $request->name;
            $product->image = $request->image;
            $product->images = $request->images;
            $product->price = $request->price;
            $product->color = $request->color;
            $product->sizes = $request->sizes;
            $product->price = $request->price;
            $product->gender = $request->gender;
            $product->category = $request->category;
            $product->description = $request->description;

            $product->save();
            return response($product, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return $product;
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
        $product = Product::find($id);
        if ($product) {
            $imageFullName = $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('images', $imageFullName);


            $product->name = $request->name;
            $product->image = $imageFullName;
            $product->images = $request->images;
            $product->price = $request->price;
            $product->color = $request->color;
            $product->sizes = $request->sizes;
            $product->price = $request->price;
            $product->gender = $request->gender;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->image = Storage::url("images/" . $product->image);
            $product->save();
            return response($product, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return "product has been deleted";
    }

    public function search($name)
    {
        return Product::where('name', 'like', '%' . $name . '%')->paginate(9);
    }

    public function category($category)
    {
        return Product::where('category', $category)->paginate(9);
    }
}
