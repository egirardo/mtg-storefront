@extends('layouts.app')

@section('content')
<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">Product name</th>
            <th class="border border-gray-300 px-4 py-2">Product category</th>
            <th class="border border-gray-300 px-4 py-2">Price</th>
            <th class="border border-gray-300 px-4 py-2">Stock</th>
            <th class="border border-gray-300 px-4 py-2">Created at</th>
            <th class="border border-gray-300 px-4 py-2">Updated at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->category_id }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->price }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->stock }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->created_at->format('Y-m-d H:i') }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $product->updated->format('Y-m-d H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection