{{-- Extends layout --}}
@extends('sellers.layout.default')

{{-- Content --}}
@section('content')

<!-- <div class="header-large-title">
    <h1 class="title">Dashboard</h1>
    <h4 class="subtitle text-primary"></h4>
</div> -->

<div class="section full mt-3 mb-3">

        <div class="section mt-3 mb-3">
            <!-- <div class="section-title">Jumlah Produk</div> -->
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-end">
                    <div>
                        <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">
                            {{ $sellers->nama_toko }}
                        </h5>
                        <h6 class="card-subtitle mt-1">Jumlah Produk: {{$count}}</h6>
                    </div>
                </div>
            </div>
        </div>

    <div class="section full mt-3 mb-3">

        <h2 class="section-title">Produk Terbaru</h2>
        <ul class="listview image-listview media mb-2" style="background: transparent; border: 0;">
            @foreach($products as $product)
            <li>
                <a href="{{ route('sellerproducts.show',$product->id) }}" class="item">
                    <div class="imageWrapper">
                    <img src="https://res.cloudinary.com/baby-daily-indonesia/image/upload/w_64,ar_1:1,c_fill,g_auto/{{$product->cover}}" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            {{ $product->nama_produk }}
                            <div class="text-muted">Jumlah Stok {{ $product->stok }}</div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>

    </div>
</div>
@endsection