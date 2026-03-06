@extends('layouts.app')

@section('content')

<section class="flex justify-between items-end">
    <!-- Sorting options -->
    <div class="inline-block min-w-50">    
    <label for="sorting" class="block mb-1 text-sm text-slate-800">
        Sort by
    </label>  

    <div class="relative inline-block">
        <form method="GET" action=" {{ route('products.index') }}">
            <select id="sorting"
            name="sort"
            class="bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
            
            <option value="alphabetically" 
                {{ request('sort', 'alphabetically') == 'alphabetically' ? 'selected' : '' }}>
                Alphabetically
            </option>
            
            <option value="by-category" 
                {{ request('sort', 'by-category') == 'by-category' ? 'selected' : '' }}>
                By category
            </option>
            
            <option value="price-low-high" 
                {{ request('sort', 'price-low-high') == 'price-low-high' ? 'selected' : '' }}>
                Price, low to high
            </option>
            
            <option value="price-high-low" 
                {{ request('sort', 'price-high-low') == 'price-high-low' ? 'selected' : '' }}>
                Price, high to low
            </option>
            
            </select>
        </form>

        <svg xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.2"
        stroke="currentColor"
        class="h-5 w-5 absolute top-1/2 -translate-y-1/2 right-2 text-slate-700 pointer-events-none">
        
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
        </svg>

    </div>
    </div>

    <!-- Create new-button -->
    <div class="justify-self-end">
        <a href="/products/create" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">Add product</a>
    </div>
</section>


<!-- Table section -->
<section class="flex mt-10 filter-section">
    <!-- Filter sidebar -->
    <div class="bg-gray-50 w-100 mr-5 p-5">
        <form method="GET" action="{{ route('products.index') }}">

            <h4 class="font-bold text-lg text-center">Filters</h4>
            <p class="mb-2">Category</p>

            <!-- Categories filter -->
            @foreach ($categories as $category)
            <div class="flex items-center">
                <input id="category_id_{{ $category->category_id }}" 
                        name="category[]" 
                        value="{{ $category->category_id }}" 
                        type="checkbox" 
                        class="checked:bg-blue-500" 
                        {{ in_array((string) $category->category_id, request('category', [])) ? 'checked' : '' }} />
                <label for="category_id_{{ $category->category_id }}">{{ ucfirst($category->category_name) }}</label>
            </div>
            @endforeach
            
            <!-- Color filter -->
            <p>Colors</p>
            @foreach ($colors as $color)
            <div class="flex items-center">
                <input id="color_{{ strtolower($color) }}" 
                        name="color[]" 
                        value="{{ $color }}" 
                        type="checkbox" 
                        {{ in_array((string) $color, request('color', [])) ? 'checked' : '' }}/>
                <label for="color_{{ strtolower($color) }}">{{ $color }}</label>
            </div>
            @endforeach

            
            <p class="mt-4 mb-2">Price range</p>
            <!-- Range Slider -->
            <div class="w-full px-2">
                <div id="price-slider"
                    data-min="{{ $minPrice }}"
                    data-max="{{ $maxPrice }}"
                    data-current-min="{{ request('min_price', $minPrice) }}"
                    data-current-max="{{ request('max_price', $maxPrice) }}"
                    class="mb-4"></div>
                <div class="flex justify-between text-sm">
                    <input type="hidden" name="min_price" id="min_price_input" value="{{ request('min_price', $minPrice) }}">
                    <input type="hidden" name="max_price" id="max_price_input" value="{{ request('max_price', $maxPrice) }}">

                    <span><span id="min-price">{{ request('min_price', $minPrice) }}</span>kr</span>
                    <span><span id="max-price">{{ request('max_price', $maxPrice) }}</span>kr</span>
                </div>
            </div>
            <!-- End Range Slider -->


            <p class="mt-4 mb-2">Stock</p>
            <!-- Range Slider -->
            <div class="w-full px-2">
                <div id="stock-slider"
                    data-min="{{ $minStock }}"
                    data-max="{{ $maxStock }}"
                    data-current-min="{{ request('min_stock', $minStock) }}"
                    data-current-max="{{ request('max_stock', $maxStock) }}"
                    class="mb-4"></div>
                <div class="flex justify-between text-sm">
                    <input type="hidden" name="min_stock" id="min_stock_input" value="{{ request('min_stock', $minStock) }}">
                    <input type="hidden" name="max_stock" id="max_stock_input" value="{{ request('max_stock', $maxStock) }}">

                    <span><span id="min-stock">{{ request('min_stock', $minStock) }}</span>st</span>
                    <span><span id="max-stock">{{ request('max_stock', $minStock) }}</span>st</span>
                </div>
            </div>
            <!-- End Range Slider -->

            
            <div class="flex flex-col gap-5 items-center">
                <button type="submit" class="mt-10 w-fit bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">Apply filters</button>
                <a href="{{ route('products.index') }}" class="underline">Clear filters</a>
            </div>
        </form>
    </div>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">Product image</th>
            <th class="border border-gray-300 px-4 py-2">Product name</th>
            <th class="border border-gray-300 px-4 py-2">Product category</th>
            <th class="border border-gray-300 px-4 py-2">Price</th>
            <th class="border border-gray-300 px-4 py-2">Stock</th>
            <th class="border border-gray-300 px-4 py-2">Created at</th>
            <th class="border border-gray-300 px-4 py-2">Updated at</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr class="h-fit">
            <td class="border border-gray-300 px-4 py-2"><img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/400x400?text=No+Image+Uploaded' }}"  width="50"></td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->product_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->category_id }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->price }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->stock }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->created_at?->format('Y-m-d H:i') }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->updated_at?->format('Y-m-d H:i') }}</td>
            <td class="border-b border-gray-300 px-4 py-2">

                <div class="flex align-middle justify-evenly">
                    <a href="{{ route('products.edit', $product->product_id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>

                    <form action="{{ route('products.destroy', ['product' => $product->product_id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</section>
@endsection