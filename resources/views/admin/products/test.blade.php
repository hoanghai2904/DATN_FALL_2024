<!-- resources/views/products/edit.blade.php -->
@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Manage Variations for Product {{ $id }}</h1>

        <!-- Nút để mở modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateVariationsModal">
            Generate Variations
        </button>

        <!-- Modal để tạo biến thể -->
        <div class="modal fade" id="generateVariationsModal" tabindex="-1" aria-labelledby="generateVariationsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateVariationsModalLabel">Generate Variations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="generateVariationsForm" action="{{ route('admin.product.variations.generate', $id) }}"
                            method="POST">
                            @csrf

                            <!-- Chọn Type -->
                            <div class="form-group">
                                <label for="types">Type</label>
                                <div id="types">
                                    <div class="form-check">
                                        <!-- Checkbox "All" -->
                                        <input type="checkbox" class="form-check-input" id="select_all_types">
                                        <label class="form-check-label" for="select_all_types">All</label>
                                    </div>
                                    @foreach ($types as $type)
                                        <div class="form-check">
                                            <input type="checkbox" name="attributes[type][]" value="{{ $type->id }}"
                                                class="form-check-input type-checkbox" id="type_{{ $type->id }}">
                                            <label class="form-check-label"
                                                for="type_{{ $type->id }}">{{ $type->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Chọn Weight -->
                            <div class="form-group">
                                <label for="weights">Weight</label>
                                <div id="weights">
                                    <div class="form-check">
                                        <!-- Checkbox "All" -->
                                        <input type="checkbox" class="form-check-input" id="select_all_weights">
                                        <label class="form-check-label" for="select_all_weights">All</label>
                                    </div>
                                    @foreach ($weights as $weight)
                                        <div class="form-check">
                                            <input type="checkbox" name="attributes[weight][]" value="{{ $weight->id }}"
                                                class="form-check-input weight-checkbox" id="weight_{{ $weight->id }}">
                                            <label class="form-check-label"
                                                for="weight_{{ $weight->id }}">{{ $weight->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitVariationsForm">Generate
                            Variations</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng hiển thị các biến thể hiện có -->
        <form action="{{ route('admin.product.variations.update', $id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="mt-5">
                <h3>Existing Variations</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Is Default</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variations as $variation)
                            <tr>
                                <td>
                                    <input type="checkbox" name="select_variations[]" value="{{ $variation->id }}">
                                </td>
                                <td>{{ $variation->id }}</td>
                                <td>
                                    {{-- <img src="{{ asset($variation->image_path) }}" alt="Image" width="50"> --}}
                                </td>
                                <td>{{ $variation->type->name }}</td>
                                <td>{{ $variation->weight->name }}</td>
                                <td>${{ number_format($variation->price_variant, 2) }}</td>
                                <td>
                                    <input type="number" name="variations[{{ $variation->id }}][quantity]" value="{{ $variation->qty }}" class="form-control" min="0">
                                </td>
                                <td>
                                    <input type="radio" name="default_variation" value="{{ $variation->id }}" {{ $variation->is_default ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                    <a href="{{ route('admin.product.variations.update', $variation->id) }}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <button type="submit" class="btn btn-success">Update Variations</button>
        </form>
        
    </div>
@endsection

@push('script')
    <script>
        // Chức năng chọn tất cả cho Type
        document.getElementById('select_all_types').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.type-checkbox');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });

        // Chức năng chọn tất cả cho Weight
        document.getElementById('select_all_weights').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.weight-checkbox');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });

        // Xử lý nút "Generate Variations" để submit form
        document.getElementById('submitVariationsForm').addEventListener('click', function() {
            console.log('Button clicked');
            // Tìm tất cả các checkbox Type được chọn
            

            // Sau khi xử lý, có thể submit form nếu cần
            document.getElementById('generateVariationsForm').submit();
        });
    </script>
@endpush
