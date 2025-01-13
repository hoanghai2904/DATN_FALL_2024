<div class="support-wishlist mini-wishlist">
    <a class="btn-support-wishlist" href="{{ route('show_wishlist') }}">
        <i class="fa fa-heart" color: #FFFFFF;></i>
        <span class="cnt crl-bg count_item_pr">{{ session('wishlist', collect())->count() }}</span>
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    </a>
</div>
<div id="menu-overlay"></div>