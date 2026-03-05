@extends('layouts.app')

@section('content')

<section class="flex justify-between items-end">
    <!-- Sorting options -->
    <div class="inline-block min-w-[200px]">    
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
    <div class="bg-gray-50 w-100 mr-5 p-2">
        <form method="GET" action="{{ route('products.index') }}">

        <p>Filters</p>
        <p class="mb-2">Category</p>
        <div class="flex items-center">
            <input id="category_id_1" name="category[]" value="1" type="checkbox" class="checked:bg-blue-500" 
                    {{ in_array('1', request('category', [])) ? 'checked' : '' }} />
            <label for="category_id_1">Singles</label>
        </div>
        <div class="flex items-center">
            <input id="category_id_2" type="checkbox" name="category[]" value="2" class="checked:bg-blue-500"
                    {{ in_array('2', request('category', [])) ? 'checked' : '' }} />
            <label for="category_id_2">Sealed</label>
        </div>
        <div class="flex items-center">
            <input id="category_id_3" type="checkbox" name="category[]" value="3" class="checked:bg-blue-500" 
                    {{ in_array('3', request('category', [])) ? 'checked' : '' }}/>
            <label for="category_id_3">Accessories</label>
        </div>
        
        
        <p>Colors</p>
        <div class="flex items-center">
            <input id="color_white" name="color[]" value="White" type="checkbox" />
            <label for="color_white">White</label>
        </div>
        <div class="flex items-center">
            <input id="color_blue" name="color[]" value="Blue" type="checkbox" />
            <label for="color_blue">Blue</label>
        </div>
        <div class="flex items-center">
            <input id="color_black" name="color[]" value="Black" type="checkbox" />
            <label for="color_black">Black</label>
        </div>
        <div class="flex items-center">
            <input id="color_red" name="color[]" value="Red" type="checkbox" />
            <label for="color_red">Red</label>
        </div>
        <div class="flex items-center">
            <input id="color_green" name="color[]" value="Green" type="checkbox" />
            <label for="color_green">Green</label>
        </div>
        <div class="flex items-center">
            <input id="color_colorless" name="color[]" value="Colorless" type="checkbox" />
            <label for="color_colorless">Colorless</label>
        </div>
        
        <p class="mt-4 mb-2">Price range</p>
        <!-- Range Slider -->
        <div class="w-full px-2">
            <div id="price-slider" class="mb-4"></div>
            <div class="flex justify-between text-sm">
                <span><span id="min-price">0</span>kr</span>
                <span><span id="max-price">100</span>kr</span>
            </div>
        </div>
        <!-- End Range Slider -->

        <p class="mt-4 mb-2">Stock</p>
        <!-- Range Slider -->
        <div class="w-full px-2">
            <div id="stock-slider" class="mb-4"></div>
            <div class="flex justify-between text-sm">
                <span><span id="min-stock">0</span>st</span>
                <span><span id="max-stock">1000</span>st</span>
            </div>
        </div>
        <!-- End Range Slider -->
        <button type="submit" class="mt-10 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">Apply filters</button>
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
            <td class="border border-gray-300 px-4 py-2"><img src="{{ $product->image }}" width="50"></td>
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