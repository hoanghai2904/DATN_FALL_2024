<div class="support-cart mini-cart">
    
    <div class="top-cart-content">
        <ul id="cart-sidebar" class="mini-products-list count_li">
            @if ($cart->totalQty)
                <ul class="list-item-cart">
                    @foreach ($cart->items as $key => $item)
                        <li class="item productid-{{ $key }}">
                            <a class="product-image"
                                href="{{ route('product_page', ['id' => $item['item']?->product?->id]) }}"
                                title="{{ $item['item']->product->name . ' - ' . $item['item']->color }}">
                                <img alt="{{ $item['item']->product->name . ' - ' . $item['item']->color }}"
                                    src="{{ Helper::get_image_product_url($item['item']->product->image) }}"
                                    width="80"
                                    onError="this.onerror=null; this.src='{{ asset('images/no_image.png') }}';" />
                            </a>
                            <div class="detail-item">
                                <div class="product-details">
                                    <a href="javascript:;" data-id="{{ $key }}" title="Xóa"
                                        class="remove-item-cart fa fa-remove" data-url="{{ route('remove_cart') }}"
                                        onclick="removeItem($(this));">
                                    </a>
                                    <p class="product-name">
                                        <a href="{{ route('product_page', ['id' => $item['item']->product->id]) }}"
                                            title="{{ $item['item']->product->name . ' - ' . $item['item']->color }}">{{ $item['item']->product->name . ' - ' . $item['item']->color }}
                                        </a>
                                    </p>
                                </div>
                                <div class="product-details-bottom">
                                    <span
                                        class="price pricechange">{{ number_format($item['price'], 0, ',', '.') }}₫</span>
                                    <div class="quantity-select">
                                        <input class="variantID" type="hidden" name="variantId"
                                            value="{{ $key }}">
                         
                <div>
                    <div class="top-subtotal">Tổng cộng: <span
                            class="price">{{ number_format($cart->totalPrice, 0, ',', '.') }}₫</span></div>
                </div>
                <div>
                    <div class="actions clearfix">
                        <a href="javascript:;" onclick="showCheckout($(this));" class="btn btn-gray btn-checkout"
                            title="Thanh toán" data-url="{{ route('show_checkout') }}">
                            <span>Thanh toán</span>
                        </a>
                        <a href="{{ route('show_cart') }}" class="view-cart btn btn-white margin-left-5"
                            title="Giỏ hàng">
                            <span>Giỏ hàng</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="no-item">
                    <p>Không có sản phẩm nào trong giỏ hàng.</p>
                </div>
            @endif
        </ul>
    </div>
</div>
<div id="menu-overlay"></div>
