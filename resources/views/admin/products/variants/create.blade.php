@extends('admin.layouts.master')

@section('title')
    Thêm mới thuộc tính sản phẩm
@endsection

@section('style-libs')
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.categories_.store') }}" method="POST">
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
                        <a class="btn btn-info addVariant" id="toggleVariant">Thêm thuộc tính mới</a>
                    </div>
                    <div class="card-body">

                        <div class="live-preview mt-4">
                            <div class="table-responsive table-card">
                                <table id="categoryTable" class="table align-middle table-nowrap table-striped-columns mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 46px;" class="no-sort">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="cardtableCheck">
                                                    <label class="form-check-label" for="cardtableCheck"></label>
                                                </div>
                                            </th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Tên thuộc tính</th>
                                            <th scope="col">Slug</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Ngày tạo mới</th>
                                            <th scope="col" style="width: 150px;">Hành động</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($variantValues as $variantType)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="cardtableCheck01">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $variantType->id }}</td>
                                                <td>
                                                    {{ $variantType->name }}
                                                </td>
                                                <td>
                                                    {{ $variantType->slug }}
                                                </td>
                                                <td>
                                                    @if ($variantType->status == 1)
                                                        <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                            <input type="checkbox" checked data-id="{{ $variantType->id }}"
                                                                class="form-check-input change-status" id="customSwitchsizemd">
                                                        </div>
                                                    @else
                                                        <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                            <input type="checkbox" data-id="{{ $variantType->id }}"
                                                                class="form-check-input change-status" id="customSwitchsizemd">
                                                        </div>
                                                    @endif
    
                                                </td>
                                                <td>{{ $variantType->updated_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.variants.edit', $variantType->id) }}"
                                                        class="btn btn-sm btn-warning">Sửa</a>
                                                    <a href="{{ route('admin.variants.destroy', $variantType->id) }}"
                                                        class="btn btn-sm btn-icon btn-danger delete-item"><i
                                                            class=" ri-delete-bin-line"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}
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

@endpush
