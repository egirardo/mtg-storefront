@extends('layouts.app')

@section('content')

<!-- Create new-button -->
<div class="justify-self-end">
    <a href="/products/create" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700" role="button">Add product</a>
</div>

<!-- Table section -->
<section class="flex flex-col lg:flex-row mt-10 filter-section">

    <!-- Filter / sorting sidebar -->
    <div class="bg-gray-50 w-full lg:w-1/4 lg:mr-5 mb-6 lg:mb-0 p-5">
        <form method="GET" action="{{ route('products.index') }}">

            <!-- Sorting options -->
            <div class="w-full">    
            <label for="sorting" class="block mb-1 text-gray-900 font-bold text-lg">Sort by</label>  

            <div class="relative w-full">
                <select id="sorting"
                    name="sort"
                    aria-describedby="sort-description"
                    class="w-full bg-white text-gray-900 text-base border-2 border-gray-400 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 focus:border-blue-700 hover:border-gray-600 shadow-sm appearance-none cursor-pointer">
                <span id="sort-description" class="sr-only">Choose how to sort the products list</span>
                    
                    <option value="alphabetically" 
                        {{ request('sort') == 'alphabetically' || !request('sort') ? 'selected' : '' }}>
                        Alphabetically
                    </option>
                    <option value="by-category" 
                        {{ request('sort') == 'by-category' ? 'selected' : '' }}>
                        By category
                    </option>
                    <option value="price-low-high" 
                        {{ request('sort') == 'price-low-high' ? 'selected' : '' }}>
                        Price, low to high
                    </option>
                    <option value="price-high-low" 
                        {{ request('sort') == 'price-high-low' ? 'selected' : '' }}>
                        Price, high to low
                    </option>
                </select>

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

            <h4 class="font-bold text-lg mt-10">Filters</h4>
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
                <label for="color_{{ strtolower($color) }}">{{ $color }}</label>
            </div>
            @endforeach

            
                <!-- Price range filter -->
                <fieldset class="mt-4 border-0 p-0">
                    <legend class="mb-2 text-gray-900 font-medium">Price range</legend>
                    <!-- Range Slider -->
                    <div class="w-full px-2">
                        <div id="price-slider"
                            data-min="{{ $minPrice }}"
                            data-max="{{ $maxPrice }}"
                            data-current-min="{{ request('min_price', $minPrice) }}"
                            data-current-max="{{ request('max_price', $maxPrice) }}"
                            role="group"
                            aria-label="Price range slider"
                            class="mb-4"></div>
                        <div class="flex justify-between text-sm text-gray-900">
                            <input type="hidden" name="min_price" id="min_price_input" value="{{ request('min_price', $minPrice) }}" aria-label="Minimum price">
                            <input type="hidden" name="max_price" id="max_price_input" value="{{ request('max_price', $maxPrice) }}" aria-label="Maximum price">

                            <span aria-live="polite">$<span id="min-price">{{ request('min_price', $minPrice) }}</span></span>
                            <span aria-live="polite">$<span id="max-price">{{ request('max_price', $maxPrice) }}</span></span>
                        </div>
                    </div>
                </fieldset>
                <!-- End Range Slider -->

                <!-- Stock filter -->
                <fieldset class="mt-4 border-0 p-0">
                    <legend class="mb-2 text-gray-900 font-medium">Stock</legend>
                    <!-- Range Slider -->
                    <div class="w-full px-2">
                        <div id="stock-slider"
                            data-min="{{ $minStock }}"
                            data-max="{{ $maxStock }}"
                            data-current-min="{{ request('min_stock', $minStock) }}"
                            data-current-max="{{ request('max_stock', $maxStock) }}"
                            role="group"
                            aria-label="Stock range slider"
                            class="mb-4"></div>
                        <div class="flex justify-between text-sm text-gray-900">
                            <input type="hidden" name="min_stock" id="min_stock_input" value="{{ request('min_stock', $minStock) }}" aria-label="Minimum stock">
                            <input type="hidden" name="max_stock" id="max_stock_input" value="{{ request('max_stock', $maxStock) }}" aria-label="Maximum stock">

                            <span aria-live="polite"><span id="min-stock">{{ request('min_stock', $minStock) }}</span>st</span>
                            <span aria-live="polite"><span id="max-stock">{{ request('max_stock', $maxStock) }}</span>st</span>
                        </div>
                    </div>
                </fieldset>
                <!-- End Range Slider -->

            <div class="mt-10">
                <a href="{{ route('products.index') }}" class="text-gray-900 underline hover:no-underline focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 rounded">Clear filters</a>
            </div>
        </form>
    </div>

    <!-- Products table -->
    <div class="flex flex-1 flex-col min-w-0">
    <table class="table-auto w-full border-collapse border border-gray-300" role="table" aria-describedby="table-description">
        <caption class="sr-only" id="table-description">Product inventory table with sorting and filtering options</caption>
        <thead>
            <tr class="bg-gray-100">
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900 whitespace-nowrap">Image</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900">Name</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900">Category</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900 whitespace-nowrap">Price</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900 whitespace-nowrap">Stock</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900">Created At</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900">Updated At</th>
                <th scope="col" class="border border-gray-300 p-2 text-left text-gray-900 whitespace-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="h-fit transition-colors duration-150 hover:bg-blue-50">
                <td class="border border-gray-300 p-2 h-20">
                    <img class="justify-self-center" src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/400x400?text=No+Image+Uploaded' }}" width="50" alt="{{ $product->image ? 'Product image of ' . $product->product_name : 'No image available for ' . $product->product_name }}">
                </td>
                <td class="border border-gray-300 p-2 text-gray-900"><a href="{{route('products.show', $product->product_id)}}" class="text-blue-700 hover:text-blue-900 underline hover:no-underline font-medium focus:outline-2 focus:outline-offset-2 focus:outline-blue-700">{{ $product->product_name }}</a></td>
                <td class="border border-gray-300 p-2 text-gray-900">{{ $product->category->category_name }}</td>
                <td class="border border-gray-300 p-2 text-gray-900 whitespace-nowrap">{{ $product->price }}</td>
                <td class="border border-gray-300 p-2 text-gray-900 whitespace-nowrap">{{ $product->stock }}</td>
                <td class="border border-gray-300 p-2 text-gray-900">{{ $product->created_at?->format('Y-m-d H:i') }}</td>
                <td class="border border-gray-300 p-2 text-gray-900">{{ $product->updated_at?->format('Y-m-d H:i') }}</td>

                <td class="border-b border-gray-300 px-4 py-2">
                    <div class="flex align-middle justify-evenly">

                        <!-- EDIT -->
                        <a href="{{ route('products.edit', $product->product_id) }}" aria-label="Edit {{ $product->product_name }}" class="text-gray-700 hover:text-blue-700 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            <span class="sr-only">Edit</span>
                        </a>

                        <!-- DELETE — form is hidden; the button below opens the modal -->
                        <form id="delete-form-{{ $product->product_id }}"
                              action="{{ route('products.destroy', ['product' => $product->product_id]) }}"
                              method="POST"
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button type="button"
                                data-delete-form="delete-form-{{ $product->product_id }}"
                                data-product-name="{{ $product->product_name }}"
                                aria-label="Delete {{ $product->product_name }}"
                                class="text-gray-700 hover:text-red-700 focus:outline-2 focus:outline-offset-2 focus:outline-red-700 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            <span class="sr-only">Delete</span>
                        </button>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination -->
    @if ($products->hasPages())
    <nav class="flex items-center gap-x-1 justify-center mt-10" aria-label="Product list pagination" role="navigation">
    
    <!-- Previous -->
    <a href="{{ $products->previousPageUrl() }}" 
        class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-base rounded-lg text-gray-900 hover:bg-gray-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 {{ $products->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}" 
        aria-label="Go to previous page"
        {{ $products->onFirstPage() ? 'aria-disabled=true' : '' }}>
       
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        <span class="sr-only">Previous page</span>
    </a>

    <div class="flex items-center gap-x-1">
        <span class="min-h-9.5 min-w-9.5 flex justify-center items-center border-2 border-gray-600 text-gray-900 py-2 px-3 text-base rounded-full" aria-current="page">{{ $products->currentPage() }}</span>
        <span class="min-h-9.5 flex justify-center items-center text-gray-700 py-2 px-1.5 text-base" aria-hidden="true">of</span>
        <span class="min-h-9.5 flex justify-center items-center text-gray-700 py-2 px-1.5 text-base">{{ $products->lastPage() }}</span>
    </div>

    <!-- Next page -->
    <a href="{{ $products->nextPageUrl() }}" 
        class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-base rounded-lg text-gray-900 hover:bg-gray-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 {{ !$products->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}" 
        aria-label="Go to next page"
        {{ !$products->hasMorePages() ? 'aria-disabled=true' : '' }}>
        <span class="sr-only">Next page</span>
        
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    </nav>
    @endif
<!-- End Pagination -->
</div>
</section>

{{-- Accessible delete confirmation modal (shared partial) --}}
@include('partials._delete_confirm_modal')

@endsection