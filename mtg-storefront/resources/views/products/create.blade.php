@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Product</h2>

    <form method="POST" action="/products" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @include('errors')

        <p class="text-xs text-gray-600"><span class="text-red-600 font-semibold" aria-hidden="true">*</span> Required fields</p>

        <!-- Category -->
        <div>
            <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-600" aria-hidden="true">*</span></label>
            <select name="category_id" id="category_select" aria-required="true" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select a Category --</option>
                <option value="1" {{ old('category_id') == '1' ? 'selected' : '' }}>Singles</option>
                <option value="2" {{ old('category_id') == '2' ? 'selected' : '' }}>Sealed</option>
                <option value="3" {{ old('category_id') == '3' ? 'selected' : '' }}>Accessories</option>
            </select>
        </div>

        <!-- Product Name -->
        <div>
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-600" aria-hidden="true">*</span></label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" placeholder="Product name"
                aria-required="true"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price <span class="text-red-600" aria-hidden="true">*</span></label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="0.00" step="0.01"
                aria-required="true"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-600" aria-hidden="true">*</span></label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" placeholder="0"
                aria-required="true"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        </div>

        <!-- Sealed Fields -->
        <div id="sealed_fields" class="space-y-5 hidden">
            <div>
                <label for="set_name" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name" id="set_name" value="{{ old('set_name') }}" placeholder="Set name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="product_type_sealed" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <select name="product_type_sealed" id="product_type_sealed"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Product Type --</option>
                    <option value="play_booster" {{ old('product_type_sealed') == 'play_booster' ? 'selected' : '' }}>Play Booster</option>
                    <option value="booster_box" {{ old('product_type_sealed') == 'booster_box' ? 'selected' : '' }}>Booster Box</option>
                    <option value="precon" {{ old('product_type_sealed') == 'precon' ? 'selected' : '' }}>Preconstructed Deck</option>
                    <option value="bundle" {{ old('product_type_sealed') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                    <option value="prerelease_kit" {{ old('product_type_sealed') == 'prerelease_kit' ? 'selected' : '' }}>Prerelease Kit</option>
                    <option value="sld" {{ old('product_type_sealed') == 'sld' ? 'selected' : '' }}>Secret Lair Drop</option>
                    <option value="starter_kit" {{ old('product_type_sealed') == 'starter_kit' ? 'selected' : '' }}>Starter Kit/Deck</option>
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
                    <option value="Common" {{ old('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ old('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ old('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Mythic" {{ old('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                </select>
            </div>
            <fieldset>
                <legend class="block text-sm font-medium text-gray-700 mb-2">Color</legend>
                <div class="flex flex-wrap gap-2">

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-yellow-50 has-checked:border-yellow-400 has-checked:text-yellow-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="White" {{ in_array('White', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        White
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-blue-50 has-checked:border-blue-400 has-checked:text-blue-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Blue" {{ in_array('Blue', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        Blue
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-gray-100 has-checked:border-gray-500 has-checked:text-gray-800 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Black" {{ in_array('Black', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        Black
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-red-50 has-checked:border-red-400 has-checked:text-red-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Red" {{ in_array('Red', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        Red
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-green-50 has-checked:border-green-400 has-checked:text-green-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Green" {{ in_array('Green', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        Green
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer px-3 py-1.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700 has-checked:bg-purple-50 has-checked:border-purple-400 has-checked:text-purple-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 transition">
                        <input type="checkbox" name="color[]" value="Colorless" {{ in_array('Colorless', old('color', [])) ? 'checked' : '' }} class="sr-only" />
                        Colorless
                    </label>

                </div>
            </fieldset>
            <div>
                <label for="set_name_single" class="block text-sm font-medium text-gray-700 mb-1">Set Name</label>
                <input type="text" name="set_name_single" id="set_name_single" value="{{ old('set_name_single') }}" placeholder="Set name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Number</label>
                <input type="text" name="number" id="number" value="{{ old('number') }}" placeholder="Number"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            
        </div>

        <!-- Accessories Fields -->
        <div id="accessories_fields" class="space-y-5 hidden">
            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="product_type" id="product_type" value="{{ old('product_type') }}" placeholder="Product type"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700">
            Add Product
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

    // Run on page load to show the right section (e.g. after validation redirect)
    document.addEventListener('DOMContentLoaded', () => {
        showCategoryFields(categorySelect.value);
    });

    // Run on change
    categorySelect.addEventListener('change', function () {
        showCategoryFields(this.value);
    });
</script>
@endsection