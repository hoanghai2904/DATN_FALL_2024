<div class="support-wishlist mini-wishlist">
    <a class="btn-support-wishlist" href="{{ route('show_wishlist') }}">
        <i class="fa fa-heart" color: #FFFFFF;></i>
        <span class="cnt crl-bg count_item_pr">{{ session('wishlist', collect())->count() }}</span>
    </a>
</div>
<div id="menu-overlay"></div>