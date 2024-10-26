@extends('admin.layouts.master')

@section('title')
    Thêm mới thuộc tính sản phẩm
@endsection

@section('style-libs')
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.variants.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tên thuộc tính</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    {{-- <label class="form-label" for="name">Tên thuộc tính</label> --}}
                                    <input type="text" class="form-control" placeholder="Nhập tên thuộc tính"
                                        name="name" id="name">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">Danh sách thuộc tính</h5>
                        <a class="btn btn-info" id="addAttributeBtn">Thêm thuộc tính mới</a>
                    </div>
                    <div class="card-body">

                        <div class="live-preview d-none">
                            <div class="table-responsive table-card">
                                <table id="categoryTable"
                                    class="table align-middle table-nowrap table-striped-columns mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tên thuộc tính</th>
                                            <th scope="col" style="width: 150px;">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label" for="variant_status">Trạng thái</label>
                                <select name="status" id="variant_status" class="form-select">
                                    <option value="0">Ẩn</option>
                                    <option value="1" selected>Kích hoạt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        document.getElementById("addAttributeBtn").addEventListener("click", function(event) {
            const variantBody = document.getElementById("variantBody");
            const livePreview = document.querySelector(".live-preview");

            // Hiển thị danh sách thuộc tính nếu đang bị ẩn
            livePreview.classList.remove("d-none");

            // Tạo một hàng mới với label và input
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
            <td></td> <!-- STT sẽ được cập nhật sau -->
            <td>
                <input type="text" class="form-control" placeholder="Nhập tên thuộc tính" name="value[]" />
            </td>
            <td>
                <button type="button" class="btn btn-danger removeAttributeBtn"><i class="las la-trash-alt"></i></button>
            </td>
        `;

            // Thêm hàng mới vào variantBody
            variantBody.appendChild(newRow);

            // Cập nhật STT
            updateSTT();

            // Xóa hàng khi nhấn nút "Xóa"
            newRow.querySelector(".removeAttributeBtn").addEventListener("click", function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định (nếu có)
                newRow.remove();
                updateSTT(); // Cập nhật lại STT sau khi xóa

                // Kiểm tra nếu không còn hàng nào thì ẩn lại danh sách
                if (variantBody.children.length === 0) {
                    livePreview.classList.add("d-none");
                }
            });
        });

        function updateSTT() {
            const rows = document.querySelectorAll("#variantBody tr");
            rows.forEach((row, index) => {
                row.children[0].innerText = index + 1; // Gán STT theo thứ tự hàng
            });
        }
    </script>
@endpush
