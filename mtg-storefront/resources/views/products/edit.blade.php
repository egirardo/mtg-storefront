@extends('layouts.app')

@section('content')

@php $colors = $product->single?->color ? explode(',', $product->single->color) : []; @endphp

<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Update Product</h2>

    <form method="POST" action="/products/{{$product->product_id}}" enctype="multipart/form-data" novalidate class="space-y-5">
        @csrf
        @method('PUT')
        @include('errors')

        <p class="text-xs text-gray-500"><span class="text-red-500 font-semibold" aria-hidden="true">*</span> Required fields</p>

        <!-- Category -->
        <div>
            <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">
                Category
                <span class="ml-1 inline-flex items-center gap-1 text-xs font-normal text-gray-600 bg-gray-100 border border-gray-200 rounded px-1.5 py-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Locked
                </span>
            </label>
            <select name="category_id" id="category_select" disabled aria-describedby="category-notice" class="w-full border border-gray-200 rounded-md px-3 py-2 text-gray-600 bg-gray-50 cursor-not-allowed opacity-75 focus:outline-none">
                <option value="">-- Select a Category --</option>
                <option value="1" {{ $product->category_id == 1 ? 'selected' : '' }}>Singles</option>
                <option value="2" {{ $product->category_id == 2 ? 'selected' : '' }}>Sealed</option>
                <option value="3" {{ $product->category_id == 3 ? 'selected' : '' }}>Accessories</option>
            </select>
            <input type="hidden" name="category_id" value="{{ $product->category_id }}" />
            <p id="category-notice" class="mt-1.5 flex items-start gap-1.5 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Category cannot be changed. To use a different category, delete this listing and create a new one.
            </p>
        </div>

        <!-- Product Name -->
        <div>
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">
                Product Name <span class="text-red-600" aria-hidden="true">*</span>
            </label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Product Name"
                aria-required="true"
                aria-describedby="@error('product_name') product_name_error @enderror"
                aria-invalid="{{ $errors->has('product_name') ? 'true' : 'false' }}"
                class="w-full border rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('product_name') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}" />
            @error('product_name')
                <p id="product_name_error" class="mt-1 text-sm text-red-600 flex items-center gap-1" aria-live="polite">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 shrink-0" aria-hidden="true"><path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                Price <span class="text-red-600" aria-hidden="true">*</span>
            </label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" placeholder="0"
                aria-required="true"
                aria-describedby="@error('price') price_error @enderror"
                aria-invalid="{{ $errors->has('price') ? 'true' : 'false' }}"
                class="w-full border rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('price') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}" />
            @error('price')
                <p id="price_error" class="mt-1 text-sm text-red-600 flex items-center gap-1" aria-live="polite">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 shrink-0" aria-hidden="true"><path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                Stock <span class="text-red-600" aria-hidden="true">*</span>
            </label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" placeholder="0"
                aria-required="true"
                aria-describedby="@error('stock') stock_error @enderror"
                aria-invalid="{{ $errors->has('stock') ? 'true' : 'false' }}"
                class="w-full border rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('stock') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}" />
            @error('stock')
                <p id="stock_error" class="mt-1 text-sm text-red-600 flex items-center gap-1" aria-live="polite">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 shrink-0" aria-hidden="true"><path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/400x400?text=No+Image+Uploaded' }}" class="h-32 w-32 object-cover rounded-md border border-gray-300 mb-2" alt="Current product image" />
                    <label for="remove_image" class="flex items-center gap-2 text-sm text-red-700 cursor-pointer">
                        <input type="checkbox" name="remove_image" id="remove_image" value="1" />
                        Remove current image
                    </label>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*"
                aria-describedby="@error('image') image_error @enderror"
                aria-invalid="{{ $errors->has('image') ? 'true' : 'false' }}"
                class="w-full border rounded-md px-3 py-2 text-gray-700 file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ $errors->has('image') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}" />
            @error('image')
                <p id="image_error" class="mt-1 text-sm text-red-600 flex items-center gap-1" aria-live="polite">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 shrink-0" aria-hidden="true"><path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Sealed Fields -->
        <div id="sealed_fields" class="space-y-5 hidden">
            <div>
                <label for="set_name" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name" id="set_name" value="{{ old('set_name', $product->sealed?->set_name) }}" placeholder="Set Name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="product_type_sealed" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <select name="product_type_sealed" id="product_type_sealed"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Product Type --</option>
                    <option value="play_booster" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'play_booster' ? 'selected' : '' }}>Play Booster</option>
                    <option value="booster_box" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'booster_box' ? 'selected' : '' }}>Booster Box</option>
                    <option value="precon" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'precon' ? 'selected' : '' }}>Preconstructed Deck</option>
                    <option value="bundle" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'bundle' ? 'selected' : '' }}>Bundle</option>
                    <option value="prerelease_kit" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'prerelease_kit' ? 'selected' : '' }}>Prerelease Kit</option>
                    <option value="sld" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'sld' ? 'selected' : '' }}>Secret Lair Drop</option>
                    <option value="starter_kit" {{ old('product_type_sealed', $product->sealed?->product_type_sealed) == 'starter_kit' ? 'selected' : '' }}>Starter Kit/Deck</option>
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
                    <option value="Common" {{ old('rarity', $product->single?->rarity) == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ old('rarity', $product->single?->rarity) == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ old('rarity', $product->single?->rarity) == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Mythic" {{ old('rarity', $product->single?->rarity) == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                </select>
            </div>
            <fieldset>
                <legend class="block text-sm font-medium text-gray-700 mb-2">Color</legend>
                <div class="flex flex-wrap gap-2">
                    @php $selectedColors = old('color', $colors); @endphp

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-yellow-50 has-checked:border-yellow-400 has-checked:text-yellow-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="White" {{ in_array('White', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        White
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-blue-50 has-checked:border-blue-400 has-checked:text-blue-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Blue" {{ in_array('Blue', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        Blue
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-gray-100 has-checked:border-gray-500 has-checked:text-gray-800 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Black" {{ in_array('Black', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        Black
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-red-50 has-checked:border-red-400 has-checked:text-red-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Red" {{ in_array('Red', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        Red
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-green-50 has-checked:border-green-400 has-checked:text-green-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Green" {{ in_array('Green', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        Green
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-purple-50 has-checked:border-purple-400 has-checked:text-purple-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Colorless" {{ in_array('Colorless', $selectedColors) ? 'checked' : '' }} class="sr-only" />
                        Colorless
                    </label>
                </div>
            </fieldset>
            <div>
                <label for="set_name_single" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name_single" id="set_name_single" placeholder="Set name" value="{{ old('set_name_single', $product->single?->set_name_single) }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Number</label>
                <input type="text" name="number" id="number" placeholder="Number" value="{{ old('number', $product->single?->number) }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Accessories Fields -->
        <div id="accessories_fields" class="space-y-5 hidden">
            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="product_type" id="product_type" placeholder="Product type" value="{{ old('product_type', $product->accessory?->product_type) }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700">
            Update Product
        </button>

    </form>

    <!-- Delete Form -->
    <form method="POST" action="/products/{{ $product->product_id }}"
        onsubmit="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full mt-3 bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-2 focus:outline-offset-2 focus:outline-red-700">
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

    document.addEventListener('DOMContentLoaded', () => {
        showCategoryFields(categorySelect.value);

        // Move focus to the error summary so screen readers announce it immediately
        const errorSummary = document.getElementById('error-summary');
        if (errorSummary) {
            errorSummary.focus();
        }
    });

    categorySelect.addEventListener('change', function () {
        showCategoryFields(this.value);
    });
</script>

@endsection