{{-- Extends layout --}}
@extends('sellers.layout.default')
{{-- Content --}}
@section('content')
@include('sellers.elements.header-list-products')
@include('sellers.elements.search-produk')

@if(session()->has('success'))
<div id="toast-12" class="toast-box toast-center show">
    <div class="in">
        <div class="text">
            {{ session('success') }}
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        closeToastBox('toast-12')
    }, 2000);
</script>
@endif

<div class="section full mb-3">
    <div class="section-title">Semua <span>({{$count}})</span></div>
    <div class="infinite-scroll">
        <ul class="listview image-listview media mb-2" id="myUL">
            @foreach($products as $product)
            <li>
                <a href="{{ route('sellerproducts.show',$product->id) }}" class="item">
                    <div class="imageWrapper">
                        <img src="https://res.cloudinary.com/baby-daily-indonesia/image/upload/w_64,ar_1:1,c_fill,g_auto/{{$product->cover}}" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            {{ $product->nama_produk }}
                            <div class="text-muted">Rp {{$product->harga}}</div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        {{$products->links()}}
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="/js/jquery.jscroll.min.js"></script>

<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="/img/load.gif" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>

<script>
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>

        
@endsection