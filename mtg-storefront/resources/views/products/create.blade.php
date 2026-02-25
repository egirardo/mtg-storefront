@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Product</h2>

    <form method="POST" action="/products" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Category -->
        <div>
            <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" id="category_select" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select a Category --</option>
                <option value="1">Singles</option>
                <option value="2">Sealed</option>
                <option value="3">Accessories</option>
            </select>
        </div>

        <!-- Product Name -->
        <div>
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input type="text" name="product_name" id="product_name" placeholder="Product name"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input type="number" name="price" id="price" placeholder="0.00" step="0.01"
                class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" id="stock" placeholder="0"
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
                <input type="text" name="set_name" id="set_name" placeholder="Set name"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Singles Fields -->
        <div id="singles_fields" class="space-y-5 hidden">
            <div>
                <label for="rarity" class="block text-sm font-medium text-gray-700 mb-1">Rarity</label>
                <input type="text" name="rarity" id="rarity" placeholder="Rarity"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="text" name="color" id="color" placeholder="Color"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Number</label>
                <input type="text" name="number" id="number" placeholder="Number"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Accessories Fields -->
        <div id="accessories_fields" class="space-y-5 hidden">
            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="product_type" id="product_type" placeholder="Product type"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
            Add Product
        </button>

    </form>
</div>

<script>
    document.getElementById('category_select').addEventListener('change', function() {
        document.getElementById('sealed_fields').classList.add('hidden');
        document.getElementById('singles_fields').classList.add('hidden');
        document.getElementById('accessories_fields').classList.add('hidden');

        if (this.value == 2) document.getElementById('sealed_fields').classList.remove('hidden');
        if (this.value == 1) document.getElementById('singles_fields').classList.remove('hidden');
        if (this.value == 3) document.getElementById('accessories_fields').classList.remove('hidden');
    });
</script>
@endsection