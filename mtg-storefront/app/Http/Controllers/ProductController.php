<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SealedProduct;
use App\Models\AccessoryProduct;
use App\Models\Category;
use App\Models\SingleProduct;

class ProductController extends Controller
{
    // show all products
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    // show the create form
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // handle the form submission
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,category_id',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            // singles validation
            'rarity'       => 'nullable|string|max:50',
            'color'        => 'nullable|string|max:50',
            'number'       => 'nullable|string|max:50',
            // sealed validation
            'set_name'     => 'nullable|string|max:255',
            // accessories validation
            'product_type' => 'nullable|string|max:50',
        ]);

        // DB::transaction so that if for some reason the save fails for the subcategories that the product isn't saved without the corresponding info also saved in the corresponding table
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'product_name' => $request->product_name,
                'category_id'  => $request->category_id,
                'price'        => $request->price,
                'stock'        => $request->stock,
            ]);

            if ($request->category_id == 1) {
                SingleProduct::create([
                    'product_id' => $product->product_id,
                    'rarity'     => $request->rarity,
                    'color'      => $request->color,
                    'number'     => $request->number,
                ]);
            } elseif ($request->category_id == 2) {
                SealedProduct::create([
                    'product_id' => $product->product_id,
                    'set_name'   => $request->set_name,
                ]);
            } elseif ($request->category_id == 3) {
                AccessoryProduct::create([
                    'product_id'   => $product->product_id,
                    'product_type' => $request->product_type,
                ]);
            }
        });

        return redirect('/products')->with('success', 'Product added successfully');
    }

    // show a single product with its extension data
    public function show($id)
    {
        $product = Product::with(['category', 'single', 'sealed', 'accessory'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // show the edit form
    public function edit($id)
    {
        $product = Product::with(['single', 'sealed', 'accessory'])->findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // handle the edit form submission
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'rarity'       => 'nullable|string|max:50',
            'color'        => 'nullable|string|max:50',
            'number'       => 'nullable|string|max:50',
            'set_name'     => 'nullable|string|max:255',
            'product_type' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);

            $product->update([
                'product_name' => $request->product_name,
                'price'        => $request->price,
                'stock'        => $request->stock,
            ]);

            if ($product->category_id == 1) {
                SingleProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    [
                        'rarity' => $request->rarity,
                        'color'  => $request->color,
                        'number' => $request->number,
                    ]
                );
            } elseif ($product->category_id == 2) {
                SealedProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    ['set_name' => $request->set_name]
                );
            } elseif ($product->category_id == 3) {
                AccessoryProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    ['product_type' => $request->product_type]
                );
            }
        });

        return redirect('/products')->with('success', 'Product updated successfully');
    }

    // delete a product
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);

            // delete extension table row first due to foreign key constraints
            $product->single?->delete();
            $product->sealed?->delete();
            $product->accessory?->delete();

            $product->delete();
        });

        return redirect('/products')->with('success', 'Product deleted successfully');
    }
}
