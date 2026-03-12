@extends('layouts.app')

@section('content')

{{-- Determine product subtype --}}
@php
    $isSingle    = $product->single !== null;
    $isSealed    = $product->sealed !== null;
    $isAccessory = $product->accessory !== null;

    $typeLabel = match(true) {
        $isSingle    => 'Single Card',
        $isSealed    => 'Sealed Product',
        $isAccessory => 'Accessory',
        default      => 'Product',
    };

    $typeBadgeClass = match(true) {
        $isSingle    => 'bg-indigo-100 text-indigo-700 border-indigo-200',
        $isSealed    => 'bg-amber-100 text-amber-700 border-amber-200',
        $isAccessory => 'bg-teal-100 text-teal-700 border-teal-200',
        default      => 'bg-gray-100 text-gray-600 border-gray-200',
    };
@endphp

<div class="min-h-screen bg-gray-50">

    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-600 mb-8" aria-label="Breadcrumb">
            <a href="/" class="hover:text-[#1a2e5a] underline hover:no-underline transition-colors focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 rounded">Home</a>
            <span aria-hidden="true">›</span>
            <a href="/products" class="hover:text-[#1a2e5a] underline hover:no-underline transition-colors focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 rounded">Products</a>
            <span aria-hidden="true">›</span>
            <span class="text-gray-800" aria-current="page">{{ $product->product_name }}</span>
        </nav>

        {{-- Main card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden grid grid-cols-1 lg:grid-cols-5">

            {{-- Left: Image Panel --}}
            <div class="lg:col-span-2 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200 relative flex items-center justify-center min-h-72 px-10 pb-10 pt-16">

                {{-- Stock badge --}}
                <div class="absolute top-4 left-4">
                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs tracking-wider uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block" aria-hidden="true"></span>
                            In Stock
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs tracking-wider uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block" aria-hidden="true"></span>
                            Out of Stock
                        </span>
                    @endif
                </div>

                @if ($product->image)
                    <img
                        src="{{ $product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/400x400?text=No+Image+Uploaded' }}"
                        alt="{{ $product->product_name }}"
                        class="max-h-80 w-auto object-contain rounded-lg drop-shadow-md"
                    >
                @else
                    <div class="flex flex-col items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs tracking-widest uppercase text-gray-500">No Image</span>
                    </div>
                @endif
            </div>

            {{-- Right: Details Panel --}}
            <div class="lg:col-span-3 p-8 lg:p-10 flex flex-col gap-6">

                {{-- Type badge + Category --}}
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="inline-block px-3 py-1 rounded-full border text-xs tracking-widest uppercase font-medium {{ $typeBadgeClass }}">
                        {{ $typeLabel }}
                    </span>
                    <span class="text-gray-600 text-sm">{{ $product->category->category_name ?? '' }}</span>
                </div>

                {{-- Product name --}}
                <h1 class="text-3xl lg:text-4xl font-bold text-[#1a2e5a] leading-tight tracking-tight">
                    {{ $product->product_name }}
                </h1>

                {{-- Price + Stock count --}}
                <div class="flex items-end gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-widest mb-1">Price</p>
                        <p class="text-3xl font-bold text-[#1a2e5a]">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-widest mb-1">Stock</p>
                        <p class="text-xl font-semibold text-gray-700">{{ $product->stock }} units</p>
                    </div>
                </div>

                {{-- ─── SINGLE CARD details ─── --}}
                @if ($isSingle)
                    <div>
                        <h2 class="text-xs text-gray-600 uppercase tracking-widest mb-4">Card Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->single->set_name_single)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Set</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->set_name_single }}</dd>
                                </div>
                            @endif
                            @if ($product->single->rarity)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Rarity</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->rarity }}</dd>
                                </div>
                            @endif
                            @if ($product->single->color)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Color(s)</dt>
                                    <dd class="text-gray-800 font-medium">{{ implode(', ', explode(',', $product->single->color)) }}</dd>
                                </div>
                            @endif
                            @if ($product->single->number)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Card #</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->number }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                {{-- ─── SEALED PRODUCT details ─── --}}
                @elseif ($isSealed)
                    <div>
                        <h2 class="text-xs text-gray-600 uppercase tracking-widest mb-4">Product Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->sealed->set_name)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Set</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->sealed->set_name }}</dd>
                                </div>
                            @endif
                            @if ($product->sealed->product_type_sealed)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Type</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->sealed->product_type_sealed }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                {{-- ─── ACCESSORY details ─── --}}
                @elseif ($isAccessory)
                    <div>
                        <h2 class="text-xs text-gray-600 uppercase tracking-widest mb-4">Accessory Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->accessory->brand)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Brand</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->accessory->brand }}</dd>
                                </div>
                            @endif
                            @if ($product->accessory->product_type)
                                <div>
                                    <dt class="text-xs text-gray-600 uppercase tracking-wider mb-0.5">Type</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->accessory->product_type }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

            </div>
        </div>

        {{-- Footer actions --}}
        <div class="mt-6 flex items-center justify-between">

            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-[#1a2e5a] underline hover:no-underline transition-colors focus:outline-2 focus:outline-offset-2 focus:outline-blue-700 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>

            <div class="flex items-center gap-3">
                {{-- Edit button --}}
                <a href="{{ route('products.edit', $product->product_id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors focus:outline-2 focus:outline-offset-2 focus:outline-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" aria-hidden="true" focusable="false">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit
                </a>

                {{-- Delete button --}}
                <form method="POST" action="/products/{{ $product->product_id }}"
                      onsubmit="return confirm('Are you sure you want to delete this product? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-red-200 bg-white text-sm font-medium text-red-700 hover:bg-red-50 hover:border-red-400 transition-colors focus:outline-2 focus:outline-offset-2 focus:outline-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection