@extends('admin.layouts.master')


@section('title')
    Địa chỉ khách hàng
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-9">
            <div class="card" id="contactList">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for contact...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>

                                        <th scope="col">#ID</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <td class="id"><a href="javascript:void(0);"
                                                class="fw-medium link-primary">#VZ10</a></td>
                                        <td class="name">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0"><img src="assets/images/users/avatar-10.jpg"
                                                        alt="" class="avatar-xs rounded-circle"></div>
                                                <div class="flex-grow-1 ms-2 name">Hà Thế Bảo</div>
                                            </div>
                                        </td>

                                        <td class="date">24 Apr, 2012 <small class="text-muted">1:25AM</small></td>

                                        <td class="lead_score">
                                            <div class="form-check form-switch form-switch-success form-switch-md text-center"
                                                dir="ltr">
                                                <input type="checkbox" class="form-check-input" id=""
                                                    onchange="">
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li><a class="dropdown-item view-item-btn" href="javascript:void(0);"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i></a></li>
                                                <li><a class="dropdown-item remove-item-btn" data-bs-toggle="modal"
                                                        href="#deleteRecordModal"><i
                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ contacts We did not find any
                                        contacts for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">

                        </div>
                    </div>

                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">You are about to delete a contact ?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your contact will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close</button>
                                            <button class="btn btn-danger" id="delete-record">Yes, Delete It!!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete modal -->

                </div>
            </div>
            <!--end card-->
        </div>
       
    </div>
@endsection
