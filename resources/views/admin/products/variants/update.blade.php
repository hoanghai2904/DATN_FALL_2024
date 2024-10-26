@extends('admin.layouts.master')

@section('title')
    Cập nhật thuộc tính sản phẩm
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.variants.update', $variant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tên thuộc tính</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" placeholder="Nhập tên thuộc tính" name="name" id="name" value="{{ $variant->name }}">
                    </div>
                </div>

                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">Danh sách thuộc tính</h5>
                        <a class="btn btn-info" id="addAttributeBtn">Thêm thuộc tính mới</a>
                    </div>
                    <div class="card-body">
                        <div class="live-preview {{ count($variant->variantValues) ? '' : 'd-none' }}">
                            <div class="table-responsive table-card">
                                <table id="categoryTable" class="table align-middle table-nowrap table-striped-columns mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tên thuộc tính</th>
                                            <th scope="col" style="width: 150px;">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantBody">
                                        <!-- Hiển thị giá trị thuộc tính hiện có -->
                                        @foreach ($variant->variantValues as $index => $value)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="value[]" value="{{ $value->value }}" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger removeAttributeBtn"><i class="las la-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <select name="status" id="variant_status" class="form-select">
                            <option value="0" {{ $variant->status == 0 ? 'selected' : '' }}>Ẩn</option>
                            <option value="1" {{ $variant->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                        </select>
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

            livePreview.classList.remove("d-none");

            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td></td>
                <td>
                    <input type="text" class="form-control" placeholder="Nhập tên thuộc tính" name="value[]" />
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeAttributeBtn"><i class="las la-trash-alt"></i></button>
                </td>
            `;

            variantBody.appendChild(newRow);
            updateSTT();

            newRow.querySelector(".removeAttributeBtn").addEventListener("click", function(event) {
                event.preventDefault();
                newRow.remove();
                updateSTT();

                if (variantBody.children.length === 0) {
                    livePreview.classList.add("d-none");
                }
            });
        });

        function updateSTT() {
            const rows = document.querySelectorAll("#variantBody tr");
            rows.forEach((row, index) => {
                row.children[0].innerText = index + 1;
            });
        }

        document.querySelectorAll(".removeAttributeBtn").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                const row = button.closest("tr");
                row.remove();
                updateSTT();

                if (document.querySelectorAll("#variantBody tr").length === 0) {
                    document.querySelector(".live-preview").classList.add("d-none");
                }
            });
        });
    </script>
@endpush
