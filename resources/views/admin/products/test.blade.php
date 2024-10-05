<!-- resources/views/products/edit.blade.php -->
@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    
    <form id="product-form" action="#12" method="POST">
        @csrf
        @method('POST')

        <!-- Thông tin sản phẩm -->
        <div class="form-group">
            <label for="name">Product Name</label>
            {{-- <input type="text" name="name" class="form-control" value="{{ $product->name }}"> --}}
        </div>

        <div class="form-group">
            <label for="price">Product Price</label>
            {{-- <input type="number" name="price" class="form-control" value="{{ $product->price }}"> --}}
        </div>

        <!-- Biến thể sản phẩm -->
        <h3>Product Variations</h3>
        <div id="variations-container">
            <!-- Nơi chứa các biến thể sẽ được thêm vào -->
        </div>

        <!-- Nút thêm mới biến thể -->
        <button type="button" class="btn btn-success" id="add-variation-btn">Add New Variation</button>

        <!-- Nút submit form -->
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let variationIndex = 0;

    // Khi người dùng nhấn nút "Thêm mới biến thể"
    $('#add-variation-btn').on('click', function() {
        // Tạo HTML mới cho biến thể
        const newVariation = `
            <div class="variation-item">
                <div class="form-group">
                    <label for="new_variation_name_${variationIndex}">Variation Name</label>
                    <input type="text" name="new_variations[${variationIndex}][name]" class="form-control">
                </div>

                <div class="form-group">
                    <label for="new_variation_sku_${variationIndex}">Variation SKU</label>
                    <input type="text" name="new_variations[${variationIndex}][sku]" class="form-control">
                </div>

                <div class="form-group">
                    <label for="new_variation_price_${variationIndex}">Variation Price</label>
                    <input type="number" name="new_variations[${variationIndex}][price]" class="form-control">
                </div>

                <button type="button" class="btn btn-danger remove-variation-btn">Remove</button>
                <hr>
            </div>
        `;

        // Thêm HTML mới vào container
        $('#variations-container').append(newVariation);
        
        // Tăng chỉ số index để không bị trùng lặp các biến thể
        variationIndex++;
    });

    // Xóa biến thể
    $(document).on('click', '.remove-variation-btn', function() {
        $(this).closest('.variation-item').remove();
    });

    // Sử dụng Ajax để gửi form khi người dùng submit
    $('#product-form').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn submit form theo cách thông thường

        // Lấy dữ liệu form
        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            success: function(response) {
                // Xử lý thành công
                alert('Product updated successfully!');
                window.location.href = ""; // Chuyển hướng sau khi thành công
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi
                alert('An error occurred while updating the product.');
                console.error(xhr.responseText);
            }
        });
    });
</script>
@endsection
