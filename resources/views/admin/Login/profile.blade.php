@extends('admin.layouts.master')
@section('content')

        <div class="container-fluid">

            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
                    <div class="overlay-content">
                        <div class="text-end p-3">
                            <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                    <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="fs-16 mb-1">Anna Adame</h5>
                                <p class="text-muted mb-0">Lead Designer / Developer</p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Complete Your Profile</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">30%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">Portfolio</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-add-fill align-bottom me-1"></i> Add</a>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-body text-body">
                                        <i class="ri-github-fill"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="gitUsername" placeholder="Username" value="@daveadame">
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-primary">
                                        <i class="ri-global-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com" value="www.velzon.com">
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-success">
                                        <i class="ri-dribbble-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="dribbleName" placeholder="Username" value="@dave_adame">
                            </div>
                            <div class="d-flex">
                                <div class="avatar-xs d-block flex-shrink-0 me-3">
                                    <span class="avatar-title rounded-circle fs-16 bg-danger">
                                        <i class="ri-pinterest-fill"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="pinterestName" placeholder="Username" value="Advance Dave">
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li>
                              
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstnameInput" placeholder="Enter your firstname" value="Dave">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="lastnameInput" placeholder="Enter your lastname" value="Adame">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="phonenumberInput" placeholder="Enter your phone number" value="+(1) 987 6543">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter your email" value="daveadame@velzon.com">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="JoiningdatInput" class="form-label">Joining Date</label>
                                                    <input type="text" class="form-control" data-provider="flatpickr" id="JoiningdatInput" data-date-format="d M, Y" data-deafult-date="24 Nov, 2021" placeholder="Select date" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="skillsInput" class="form-label">Skills</label>
                                                    <select class="form-control" name="skillsInput" data-choices data-choices-text-unique-true multiple id="skillsInput">
                                                        <option value="illustrator">Illustrator</option>
                                                        <option value="photoshop">Photoshop</option>
                                                        <option value="css">CSS</option>
                                                        <option value="html">HTML</option>
                                                        <option value="javascript" selected>Javascript</option>
                                                        <option value="python">Python</option>
                                                        <option value="php">PHP</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="designationInput" class="form-label">Designation</label>
                                                    <input type="text" class="form-control" id="designationInput" placeholder="Designation" value="Lead Designer / Developer">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="websiteInput1" class="form-label">Website</label>
                                                    <input type="text" class="form-control" id="websiteInput1" placeholder="www.example.com" value="www.velzon.com" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="cityInput" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="cityInput" placeholder="City" value="California" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">Country</label>
                                                    <input type="text" class="form-control" id="countryInput" placeholder="Country" value="United States" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="zipcodeInput" class="form-label">Zip Code</label>
                                                    <input type="text" class="form-control" minlength="5" maxlength="6" id="zipcodeInput" placeholder="Enter zipcode" value="90011">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <label for="exampleFormControlTextarea" class="form-label">Description</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your description" rows="3">Hi I'm Anna Adame,It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is European languages are members of the same family.</textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Updates</button>
                                                    <button type="button" class="btn btn-soft-success">Cancel</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                                    <input type="password" class="form-control" id="oldpasswordInput" placeholder="Enter current password">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput" class="form-label">New Password*</label>
                                                    <input type="password" class="form-control" id="newpasswordInput" placeholder="Enter new password">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                                    <input type="password" class="form-control" id="confirmpasswordInput" placeholder="Confirm password">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Change Password</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                 
                                </div>
                                <!--end tab-pane-->
                             
                               
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Velzon.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by Themesbrand
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection