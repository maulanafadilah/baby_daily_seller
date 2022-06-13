<div class="appHeader">
    <div class="left">
        <a href="#" class="headerButton text-primary" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
            <ion-icon name="menu-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        {{ $page_title }}
    </div>
    <div class="right">
        <a href="{{ route('sellerproducts.create') }}" class="headerButton toggle-searchbox text-primary">
            <ion-icon name="add-circle-outline"></ion-icon>
        </a>
        <a href="#" class="headerButton toggle-searchbox text-primary">
            <ion-icon name="search-outline"></ion-icon>
        </a>
    </div>
</div>
<!-- * App Header -->