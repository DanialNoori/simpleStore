<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\UpdateProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();

        return view('products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Auth::user()->products()->create($request->except(['_token', 'categories']));
        $product->categories()->sync($request->categories);

        $request->session()->flash('alert-success', Lang::get('flashMessage.created'));

        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with(['categories'])->first();

        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with(['categories'])->first();
        $this->authorize('update', $product);

        $categories = Category::get();

        return view('products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);
        $this->authorize('update', $product);

        $this->updateProduct($request, $product);

        $request->session()->flash('alert-success', Lang::get('flashMessage.updated'));

        return redirect('/product/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::find($id);
        $this->authorize('delete', $product);

        $this->destroyProduct($product);

        return redirect('/product');
    }

    /**
     * @param UpdateProductRequest $request
     * @param $product
     */
    private function updateProduct(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->only(['name', 'description']));
        $product->categories()->sync($request->categories);
    }

    /**
     * @param $product
     */
    private function destroyProduct(Product $product)
    {
        $product->categories()->detach();
        $product->delete();
    }
}
