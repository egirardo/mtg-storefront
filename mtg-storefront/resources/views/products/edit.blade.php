@extends('layouts.app')

@section('content')

@php $colors = $product->single?->color ? explode(',', $product->single->color) : []; @endphp

<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Update Product</h2>

    <form method="POST" action="/products/{{$product->product_id}}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')
        @include('errors')

        <!-- Category -->
        <div>
            <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" id="category_select" disabled class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select a Category --</option>
                <option value="1" {{ $product->category_id == 1 ? 'selected' : '' }}>Singles</option>
                <option value="2" {{ $product->category_id == 2 ? 'selected' : '' }}>Sealed</option>
                <option value="3" {{ $product->category_id == 3 ? 'selected' : '' }}>Accessories</option>
            </select>
            <!-- input field below is there so that posting doesn't get an error because disabled fields don't send info to db -->
            <input type="hidden" name="category_id" value="{{ $product->category_id }}" />
            <small>Category cannot be changed, if you need to change the category please delete this listing and add a new one with the correct category.</small>
        </div>

        <!-- Product Name -->
        <div>
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="{{$product->product_name}}" placeholder="Product Name"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input type="number" name="price" id="price" value="{{$product->price}}" step="0.01" placeholder="0"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" id="stock" value="{{$product->stock}}" placeholder="0"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-32 w-32 object-cover rounded-md border border-gray-300 mb-2" />
                    <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                        <input type="checkbox" name="remove_image" value="1" />
                        Remove current image
                    </label>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        </div>

        <!-- Sealed Fields -->
        <div id="sealed_fields" class="space-y-5 hidden">
            <div>
                <label for="set_name" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name" id="set_name" value="{{$product->sealed?->set_name}}" placeholder="Set Name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="product_type_sealed" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <select name="product_type_sealed" id="product_type_sealed"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Product Type --</option>
                    <option value="play_booster" {{ $product->sealed?->product_type_sealed == 'play_booster' ? 'selected' : '' }}>Play Booster</option>
                    <option value="booster_box" {{ $product->sealed?->product_type_sealed == 'booster_box' ? 'selected' : '' }}>Booster Box</option>
                    <option value="precon" {{ $product->sealed?->product_type_sealed == 'precon' ? 'selected' : '' }}>Preconstructed Deck</option>
                    <option value="bundle" {{ $product->sealed?->product_type_sealed == 'bundle' ? 'selected' : '' }}>Bundle</option>
                    <option value="prerelease_kit" {{ $product->sealed?->product_type_sealed == 'prerelease_kit' ? 'selected' : '' }}>Prerelease Kit</option>
                    <option value="sld" {{ $product->sealed?->product_type_sealed == 'sld' ? 'selected' : '' }}>Secret Lair Drop</option>
                    <option value="starter_kit" {{ $product->sealed?->product_type_sealed == 'starter_kit' ? 'selected' : '' }}>Starter Kit/Deck</option>
                </select>
            </div>
        </div>

        <!-- Singles Fields -->
        <div id="singles_fields" class="space-y-5 hidden">
            <div>
                <label for="rarity" class="block text-sm font-medium text-gray-700 mb-1">Rarity</label>
                <select name="rarity" id="rarity"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Rarity --</option>
                    <option value="Common" {{ $product->single?->rarity == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ $product->single?->rarity == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ $product->single?->rarity == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Mythic" {{ $product->single?->rarity == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                <div class="flex flex-wrap gap-2">

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-yellow-50 has-[:checked]:border-yellow-400 has-[:checked]:text-yellow-700 transition">
                        <input type="checkbox" name="color[]" value="White" {{ in_array('White', $colors) ? 'checked' : '' }} class="hidden" />
                        White
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-blue-50 has-[:checked]:border-blue-400 has-[:checked]:text-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Blue" {{ in_array('Blue', $colors) ? 'checked' : '' }}  class="hidden" />
                        Blue
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-gray-100 has-[:checked]:border-gray-500 has-[:checked]:text-gray-800 transition">
                        <input type="checkbox" name="color[]" value="Black" {{ in_array('Black', $colors) ? 'checked' : '' }}  class="hidden" />
                        Black
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-red-50 has-[:checked]:border-red-400 has-[:checked]:text-red-700 transition">
                        <input type="checkbox" name="color[]" value="Red" {{ in_array('Red', $colors) ? 'checked' : '' }}  class="hidden" />
                        Red
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-green-50 has-[:checked]:border-green-400 has-[:checked]:text-green-700 transition">
                        <input type="checkbox" name="color[]" value="Green" {{ in_array('Green', $colors) ? 'checked' : '' }}  class="hidden" />
                        Green
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-[:checked]:bg-purple-50 has-[:checked]:border-purple-400 has-[:checked]:text-purple-700 transition">
                        <input type="checkbox" name="color[]" value="Colorless" {{ in_array('Colorless', $colors) ? 'checked' : '' }}  class="hidden" />
                        Colorless
                    </label>

                </div>
            </div>
            <div>
                <label for="set_name_single" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name_single" id="set_name_single" placeholder="Set name" value="{{$product->single?->set_name_single}}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Number</label>
                <input type="text" name="number" id="number" placeholder="Number" value="{{$product->single?->number}}" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            
        </div>

        <!-- Accessories Fields -->
        <div id="accessories_fields" class="space-y-5 hidden">
            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="product_type" id="product_type" placeholder="Product type" value="{{$product->accessory?->product_type}}" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
            Update Product
        </button>

    </form>
    
    <!-- Delete Form -->
    <form method="POST" action="/products/{{ $product->product_id }}" 
        onsubmit="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full mt-3 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
            Delete Product
        </button>
    </form>
</div>

<script>
    function showCategoryFields(value) {
        document.getElementById('sealed_fields').classList.add('hidden');
        document.getElementById('singles_fields').classList.add('hidden');
        document.getElementById('accessories_fields').classList.add('hidden');

        if (value == 2) document.getElementById('sealed_fields').classList.remove('hidden');
        if (value == 1) document.getElementById('singles_fields').classList.remove('hidden');
        if (value == 3) document.getElementById('accessories_fields').classList.remove('hidden');
    }

    const categorySelect = document.getElementById('category_select');

    // Run on page load to show the right section immediately
    document.addEventListener('DOMContentLoaded', () => {
        showCategoryFields(categorySelect.value);
    });

    // Run on change as before
    categorySelect.addEventListener('change', function () {
        showCategoryFields(this.value);
    });
</script>

@endsection