@extends('admin.layouts.master')
@push('style')
@endpush
@section('title')
    Nhân viên
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4" >
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tạo mới vai trò</h4>
            </div><!-- end card header -->
    
            <div class="card-body">
                <div class="live-preview">
                    <form action="{{route('admin.addRole')}}" class="row g-3 needs-validation" method="POST">
                        @csrf
                        <div class="col-md-6 position-relative">
                            <label for="validationTooltip01" class="form-label">Vai trò *</label>
                            <input type="text" value="{{ old('role_name') }}" class="form-control" id="validationTooltip01" name="role_name" placeholder="Nhập tên vai trò" >
                            @error('role_name')
                            <small
                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Thêm quyền mới</label>
                            <input type="text" value="{{ old('permission_name') }}" class="form-control" name="permission_name" placeholder="Nhập quyền mới">
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom04" class="form-label">Quyền *</label>
                            <span class="badge bg-danger-subtle text-danger">Click vào input để chọn quyền !</span>
                            <select id="validationCustom04" class="form-select js-example-basic-multiple select2-hidden-accessible" name="permissions[]" multiple >
                                <optgroup label="Quyền hiện có">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('permissions')
                            <small
                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Tạo mới</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-lg-8">
        <div class="card" id="leadsList">
            <div class="card-header border-0">

                <div class="row g-4 align-items-center">
                    <div class="col-sm-3">
                        <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search for...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="hstack gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>Tìm kiếm</button>
                         
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Vai trò</th>
                                    <th class="text-center">Quyền hạn</th>                 
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($roles as $role)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="option{{ $role->id }}">
                                            </div>
                                        </th>
                                        <td class="id"><a href="javascript:void(0);" class="fw-medium link-primary">#{{ $role->id }}</a></td>
                                        <td class="leads_score">{{ $role->name }}</td>
                                        <td class="tags text-center" style="width: 300px;">
                                            @foreach($role->permissions as $permission)
                                                <span class="badge bg-primary-subtle text-primary">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="date">{{ $role->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <div class="form-check form-switch form-switch-success form-switch-md text-center" dir="ltr">
                                                <input type="checkbox" class="form-check-input" {{ $role->deleted_at ? '' : 'checked' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0);"><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal" data-id="{{ $role->id }}"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                    <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal" data-id="{{ $role->id }}">
                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                     
                    </div>
                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>
                </div>

                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" autocomplete="off">
                                <div class="modal-body">
                                    <input type="hidden" id="id-field" />
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="position-absolute bottom-0 end-0">
                                                        <label for="lead-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                            <div class="avatar-xs cursor-pointer">
                                                                <div class="avatar-title bg-light border rounded-circle text-muted">
                                                                    <i class="ri-image-fill"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input class="form-control d-none" value="" id="lead-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                    </div>
                                                    <div class="avatar-lg p-1">
                                                        <div class="avatar-title bg-light rounded-circle">
                                                            <img src="assets/images/users/user-dummy-img.jpg" id="lead-img" class="avatar-md rounded-circle object-fit-cover" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5 class="fs-13 mt-3">Lead Image</h5>
                                            </div>
                                            <div>
                                                <label for="leadname-field" class="form-label">Name</label>
                                                <input type="text" id="leadname-field" class="form-control" placeholder="Enter Name" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div>
                                                <label for="company_name-field" class="form-label">Company Name</label>
                                                <input type="text" id="company_name-field" class="form-control" placeholder="Enter company name" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="leads_score-field" class="form-label">Leads Score</label>
                                                <input type="text" id="leads_score-field" class="form-control" placeholder="Enter lead score" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="phone-field" class="form-label">Phone</label>
                                                <input type="text" id="phone-field" class="form-control" placeholder="Enter phone no" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div>
                                                <label for="location-field" class="form-label">Location</label>
                                                <input type="text" id="location-field" class="form-control" placeholder="Enter location" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div>
                                                <label for="taginput-choices" class="form-label">Tags</label>
                                                <select class="form-control" name="taginput-choices" id="taginput-choices" multiple>
                                                    <option value="Lead">Lead</option>
                                                    <option value="Partner">Partner</option>
                                                    <option value="Exiting">Exiting</option>
                                                    <option value="Long-term">Long-term</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div>
                                                <label for="date-field" class="form-label">Created Date</label>
                                                <input type="date" id="date-field" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" placeholder="Select Date" required />
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" id="add-btn">Add leads</button>
                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end modal-->

                <!-- Modal -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4 class="fs-semibold">You are about to delete a lead ?</h4>
                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting your lead will remove all of your information from our database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">

                                        <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button class="btn btn-danger" id="delete-record">Yes, Delete It!!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->



            </div>
        </div>
    </div>
    <!--end col-->
</div>
@endsection