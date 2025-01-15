@forelse($topProducts as $product)

    <tr>
        <td>{{ $product->variants->product->sku_code }}</td>
        <td>
            <img src="{{ Helper::get_image_product_url($product->variants->product->image) }}" 
                 alt="{{ $product->variants->product->name }}"
                 style="width: 40px; height: 40px; object-fit: cover;">
        </td>
        <td><strong>{{ $product->variants->product->name }}</strong> - {{ substr($product->variants->sku, strpos($product->variants->sku, '-') + 1) }}</td>
        <td><strong>{{ number_format($product->total_quantity) }}</strong></td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center">Không có dữ liệu</td>
    </tr>
@endforelse 


