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
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
            <a href="/" class="hover:text-[#1a2e5a] transition-colors">Home</a>
            <span>›</span>
            <a href="/products" class="hover:text-[#1a2e5a] transition-colors">Products</a>
            <span>›</span>
            <span class="text-gray-600">{{ $product->product_name }}</span>
        </nav>

        {{-- Main card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden grid grid-cols-1 lg:grid-cols-5">

            {{-- Left: Image Panel --}}
            <div class="lg:col-span-2 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200 relative flex items-center justify-center min-h-72 px-10 pb-10 pt-16">

                {{-- Stock badge --}}
                <div class="absolute top-4 left-4">
                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs tracking-wider uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            In Stock
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-red-600 text-xs tracking-wider uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs tracking-widest uppercase text-gray-300">No Image</span>
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
                    <span class="text-gray-400 text-sm">{{ $product->category->category_name ?? '' }}</span>
                </div>

                {{-- Product name --}}
                <h1 class="text-3xl lg:text-4xl font-bold text-[#1a2e5a] leading-tight tracking-tight">
                    {{ $product->product_name }}
                </h1>

                {{-- Price + Stock count --}}
                <div class="flex items-end gap-8 border-b border-gray-100 pb-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Price</p>
                        <p class="text-3xl font-bold text-[#1a2e5a]">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Stock</p>
                        <p class="text-xl font-semibold text-gray-700">{{ $product->stock }} units</p>
                    </div>
                </div>

                {{-- ─── SINGLE CARD details ─── --}}
                @if ($isSingle)
                    <div>
                        <h2 class="text-xs text-gray-400 uppercase tracking-widest mb-4">Card Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->single->set_name_single)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Set</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->set_name_single }}</dd>
                                </div>
                            @endif
                            @if ($product->single->rarity)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Rarity</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->rarity }}</dd>
                                </div>
                            @endif
                            @if ($product->single->color)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Color</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->color }}</dd>
                                </div>
                            @endif
                            @if ($product->single->number)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Card #</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->single->number }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                {{-- ─── SEALED PRODUCT details ─── --}}
                @elseif ($isSealed)
                    <div>
                        <h2 class="text-xs text-gray-400 uppercase tracking-widest mb-4">Product Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->sealed->set_name)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Set</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->sealed->set_name }}</dd>
                                </div>
                            @endif
                            @if ($product->sealed->product_type_sealed)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Type</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->sealed->product_type_sealed }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                {{-- ─── ACCESSORY details ─── --}}
                @elseif ($isAccessory)
                    <div>
                        <h2 class="text-xs text-gray-400 uppercase tracking-widest mb-4">Accessory Details</h2>
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                            @if ($product->accessory->brand)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Brand</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->accessory->brand }}</dd>
                                </div>
                            @endif
                            @if ($product->accessory->product_type)
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Type</dt>
                                    <dd class="text-gray-800 font-medium">{{ $product->accessory->product_type }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

            </div>
        </div>

        {{-- Back link --}}
        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#1a2e5a] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>
        </div>

    </div>
</div>

@endsection