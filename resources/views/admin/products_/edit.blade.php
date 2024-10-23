<!-- Hiển thị thông tin sản phẩm -->
<h1>Cập nhật sản phẩm: {{ $product->name }}</h1>

<table class="table">
    <thead>
        <tr>
            <th>Hình ảnh</th>
            <th>Loại</th>                                                           
            <th>Trọng Lượng</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product->variants as $variant)
            <tr>
                <td>
                    <img src="{{ $product->thumbnail }}" alt="Thumbnail" style="width: 50px; height: 50px;">
                </td>
                <td>{{ $variant->variantType->name }}</td>
                <td>{{ $variant->variantValue->value }}</td>
                <td>{{ $variant->qty }}</td>
                <td>{{ number_format($variant->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

