{{-- Extends layout --}}
@extends('sellers.layout.default')

{{-- Content --}}
@section('content')
<!-- carousel full -->
<div class="carousel-full splide">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach($images as $image)
            <li class="splide__slide">
                <img src="https://res.cloudinary.com/baby-daily-indonesia/image/upload/h_400,ar_1:1,c_fill,g_auto/{{$image->gambar}}" alt="image">
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- * carousel full -->

<div class="section full">
    <div class="wide-block pt-2 pb-2 product-detail-header">
        <h1 class="title">{{ $products->nama_produk }}</h1>
        <div class="text">Stok : {{ $products->stok }}</div>
        <div class="detail-footer">
            <!-- price -->
            <div class="price">
                <div class="current-price">Rp.{{ $products->harga }},-</div>
            </div>
            <!-- * price -->
        </div>


    </div>
</div>


<div class="section full mt-2 mb-3">
    <div class="section-title">Product Details</div>
    <ul class="listview simple-listview">
                <li>
                    <div class="col text-secondary">
                        Kategori
                    </div>
                    <div class="col">
                    {{$products->nama_kategori}}
                    </div>
                </li>
                <li>
                    <div class="col text-secondary">
                        Brand
                    </div>
                    <div class="col">
                    {{$products->brand}}
                    </div>
                </li>
                <li>
                    <div class="col text-secondary">
                        Stok
                    </div>
                    <div class="col">
                    {{$products->stok}}
                    </div>
                </li>
            </ul>
    <div class="wide-block pt-2 pb-2">
        {!! $products->deskripsi !!}
    </div>
</div>

@include('sellers.elements.bottom-produk-detail')
<!-- include('sellers.elements.form-modal') -->
@endsection