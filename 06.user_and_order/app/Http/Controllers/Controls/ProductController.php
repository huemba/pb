<?php

namespace App\Http\Controllers\Controls;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Http\Requests\Controls\ProductRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('controls.products.index',[
            "products" =>$products
        ]);
    }

    public function create()
    {
        
        $brands = Brand::all();
        $subcategories =  Subcategory::all();

        return view('controls.products.create',[
            "brands" => $brands,
            "subcategories" => $subcategories,
        ]);
    }

    public function store(ProductRequest $request)
    {
        try{
            $validatedData = $request->validated();
            
            if (!isset($validatedData['image'])){
                return redirect()->route('controls.products.index')->withErrors("No product image, create failed");
            }
            unset($validatedData["image"]);

            $name = time().'_'.$request->file('image')->getClientOriginalName();
            $path = 'storage/'. $request->file('image')->storeAs(
                'products',
                $name,
                'public'
            );
            
            $validatedData["image"] = $path;
            $product = Product::create($validateData);
        } catch (QueryException $e){
            return redirect()->route('controls.products.index')->withErrors("Create a product failed!");
        }
        return redirect()->route('controls.products.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);

        $brands = Brand::all();
        $subcategories = Subcategory::all();

        return view('controls.products.edit',[
            'product' => $product,
            'brands' => $brands,
            'subcategories' => $subcategories,
        ]);
    }

    public function update($id, ProductRequest $request)
    {
        $product = Product::find($id);
        $validatedData = $request->validated();

        if (isset($validatedData['image'])){
            unset($validatedData["image"]);
            Storage::disk('public')->delete(
                str_replace(
                    'storage/',
                    '',
                    $product->image
                )
            );
            $name =time(). '_' .$request->file('image')->getClientOriginalName();
            $path = 'storage/'. $request->file('image')->storeAs(
                'products',
                $name,
                'public'
            );
            $validatedData["image"] = $path;
        }
        if ($product->update($validatedData)){
            return redirect()->route('controls.products.index');
        } else {
            return redirect()->route('controls.products.index')->withErrors("Update a product failed!");
        }        
    }

    public function destroy(Request $request)
    {
        $product = Product::find($id);
        
        Storage::disk('public')->delete(
            str_replace(
                'storage/',
                '',
                $product->image
            )
        );
        $product->delete();
        return redirect()->route('controls.products.index');
    }
}
