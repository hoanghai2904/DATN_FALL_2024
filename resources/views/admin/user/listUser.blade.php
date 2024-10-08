@extends('admin.layouts.master')
@push('style')
@endpush
@section('title')
    Nhân viên
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
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
                            <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Leads</button>
                            <span class="dropdown">
                                <button class="btn btn-soft-info btn-icon fs-14" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-settings-4-line"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Copy</a></li>
                                    <li><a class="dropdown-item" href="#">Move to pipline</a></li>
                                    <li><a class="dropdown-item" href="#">Add to exceptions</a></li>
                                    <li><a class="dropdown-item" href="#">Switch to common form view</a></li>
                                    <li><a class="dropdown-item" href="#">Reset form view to default</a></li>
                                </ul>
                            </span>
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

                                    <th class="sort" data-sort="name">Name</th>
                                    <th class="sort" data-sort="company_name">Email</th>
                                    <th class="sort" data-sort="phone">Phone</th>                 
                                    <th class="sort" data-sort="tags">Chức vụ</th>
                                    <th class="sort" data-sort="tags">Trạng thái</th>
                                    <th class="sort" data-sort="date">Create Date</th>
                                    <th>Hành độnng</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/users/avatar-10.jpg" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                                            </div>
                                            <div class="flex-grow-1 ms-2 name">Tonya Noble</div>
                                        </div>
                                    </td>
                              
                                    <td class="leads_score">baotheha@gmail.com</td>
                                    <td class="phone">580-464-4694</td>
                                
                                    <td class="tags">
                                        <span class="badge bg-primary-subtle text-primary">Lead</span>
                                        <span class="badge bg-primary-subtle text-primary">Partner</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-success form-switch-md text-center" dir="ltr">
                                            <input type="checkbox" class="form-check-input">
                                        </div>
                                    </td>
                                    <td class="date">07 Apr, 2021</td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                          
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="javascript:void(0);"><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                     
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
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