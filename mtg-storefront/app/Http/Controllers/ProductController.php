<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SealedProduct;
use App\Models\AccessoryProduct;
use App\Models\Category;
use App\Models\SingleProduct;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // show all products
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter logic
        if ($request->has('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->has('color')) {
            $query->whereHas('single', function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    foreach ($request->color as $color) {
                        $subQuery->orWhere('color', 'LIKE', '%' . $color . '%');
                    }
                });
            });
        }

        // Round min/max values for consistent slider behavior
        $minPrice = floor(Product::min('price') ?? 0);
        $maxPrice = ceil(Product::max('price') ?? 1000);
        $minStock = (int) (Product::min('stock') ?? 0);
        $maxStock = (int) (Product::max('stock') ?? 1000);


        // Filter sliders (with type casting for security)
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $filterMin = $request->filled('min_price') ? (float) $request->min_price : $minPrice;
            $filterMax = $request->filled('max_price') ? (float) $request->max_price : $maxPrice;
            $query->whereBetween('price', [$filterMin, $filterMax]);
        }

        if ($request->filled('min_stock') || $request->filled('max_stock')) {
            $filterMinStock = $request->filled('min_stock') ? (int) $request->min_stock : $minStock;
            $filterMaxStock = $request->filled('max_stock') ? (int) $request->max_stock : $maxStock;
            $query->whereBetween('stock', [$filterMinStock, $filterMaxStock]);
        }

        // Sorting logic
        $allowedSorts = [
            'alphabetically' => ['column' => 'product_name', 'direction' => 'asc'],
            'by-category' => ['column' => 'category_id', 'direction' => 'asc'],
            'price-low-high' => ['column' => 'price', 'direction' => 'asc', 'cast' => true],
            'price-high-low' => ['column' => 'price', 'direction' => 'desc', 'cast' => true],
        ];

        $sortKey = $request->get('sort', 'alphabetically');

        if (array_key_exists($sortKey, $allowedSorts)) {
            $sort = $allowedSorts[$sortKey];

            if (!empty($sort['cast'])) {
                $query->orderByRaw('CAST(' . $sort['column'] . ' AS DECIMAL(10,2)) ' . $sort['direction']);
            } else {
                $query->orderBy($sort['column'], $sort['direction']);
            }
        }

        // if ($request->filled('sort') && array_key_exists($request->sort, $allowedSorts)) {
        //     $sort = $allowedSorts[$request->sort];
        //     if (!empty($sort['cast'])) {
        //         $query->orderByRaw('CAST(' . $sort['column'] . ' AS DECIMAL(10,2)) ' . $sort['direction']);
        //     } else {
        //         $query->orderBy($sort['column'], $sort['direction']);
        //     }
        // }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $colors = ['White', 'Blue', 'Black', 'Red', 'Green', 'Colorless'];

        // $products = Product::with('category')->get();
        return view('products.index', compact(
            'products',
            'categories',
            'colors',
            'minPrice',
            'maxPrice',
            'minStock',
            'maxStock'
        ));
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
            'image'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // singles validation
            'rarity'       => 'nullable|string|max:50',
            'color'        => 'nullable|array',
            'color.*'      => 'string|max:50',
            'number'       => 'nullable|string|max:50',
            'set_name_single'     => 'nullable|string|max:255',
            // sealed validation
            'set_name'     => 'nullable|string|max:255',
            'product_type_sealed' => 'nullable|string|max:50',
            // accessories/sealed validation
            'brand' => 'nullable|string|max:50',
            'product_type' => 'nullable|string|max:50',
        ]);

        // handle image upload before the transaction
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        // DB::transaction so that if for some reason the save fails for the subcategories that the product isn't saved without the corresponding info also saved in the corresponding table
        DB::transaction(function () use ($request, $imagePath) {
            $product = Product::create([
                'product_name' => $request->product_name,
                'category_id'  => $request->category_id,
                'price'        => $request->price,
                'stock'        => $request->stock,
                'image'        => $imagePath,
            ]);

            if ($request->category_id == 1) {
                SingleProduct::create([
                    'product_id' => $product->product_id,
                    'rarity'     => $request->rarity,
                    'color'      => $request->color ? implode(',', $request->color) : null,
                    'number'     => $request->number,
                    'set_name_single'   => $request->set_name_single,
                ]);
            } elseif ($request->category_id == 2) {
                SealedProduct::create([
                    'product_id' => $product->product_id,
                    'set_name'   => $request->set_name,
                    'product_type_sealed' => $request->product_type_sealed,
                ]);
            } elseif ($request->category_id == 3) {
                AccessoryProduct::create([
                    'product_id'   => $product->product_id,
                    'brand' => $request->brand,
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
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rarity'       => 'nullable|string|max:50',
            'color'        => 'nullable|array',
            'color.*'      => 'string|max:50',
            'number'       => 'nullable|string|max:50',
            'set_name'     => 'nullable|string|max:255',
            'set_name_single' => 'nullable|string|max:255',
            'product_type' => 'nullable|string|max:50',
            'brand'        => 'nullable|string|max:50',
            'product_type_sealed' => 'nullable|string|max:50',
        ]);

        $product = Product::findOrFail($id);
        $imagePath = $product->image; // keep existing by default

        if ($request->hasFile('image')) {
            // delete old image if there was one
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $imagePath = null;
        }

        DB::transaction(function () use ($request, $id, $imagePath) {
            $product = Product::findOrFail($id);

            $updateData = [
                'product_name' => $request->product_name,
                'price'        => $request->price,
                'stock'        => $request->stock,
                'image'        => $imagePath,
            ];

            $product->update($updateData);

            if ($product->category_id == 1) {
                SingleProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    [
                        'rarity' => $request->rarity,
                        'color' => $request->color ? implode(',', $request->color) : null,
                        'number' => $request->number,
                        'set_name_single' => $request->set_name_single,
                    ]
                );
            } elseif ($product->category_id == 2) {
                SealedProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    [
                        'set_name' => $request->set_name,
                        'product_type_sealed' => $request->product_type_sealed,
                    ]
                );
            } elseif ($product->category_id == 3) {
                AccessoryProduct::updateOrCreate(
                    ['product_id' => $product->product_id],
                    [
                        'brand' => $request->brand,
                        'product_type' => $request->product_type
                    ]
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
