@extends('Client.index');
@section('main')
    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Rigester</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Rigester</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Customer Login Section :::... -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    
        <div class="customer-register mb-10">
            <div class="row justify-content-center">
                <!--register area start-->
                <div class="col-lg-8 col-md-10">
                    <div class="account_form register p-4 border rounded shadow-sm">
                        <h3 class="mb-4 text-center">Register</h3>
    
                        <form action="{{ route('account.Check_rigester') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3">
                                        <label for="full_name">Full Name <span>*</span></label>
                                        <input type="text" id="full_name" name="full_name" class="form-control"
                                            value="{{ old('full_name') }}" required />
                                        @error('full_name')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3 d-flex align-items-center">
                                        <div>
                                            <label for="cover">Avatar</label>
                                            <input type="file" id="cover" name="cover" class="form-control-file"
                                                onchange="previewAvatar(event)" />
                                            @error('cover')
                                                <small
                                                    style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <img id="avatarPreview" src="" alt="Avatar Preview"
                                            class="ml-3 rounded d-none float-left" width="70" height="70" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3">
                                        <label for="phone">Phone <span>*</span></label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone') }}" required />
                                        @error('phone')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3">
                                        <label for="email">Email Address <span>*</span></label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ old('email') }}" required />
                                        @error('email')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="default-form-box mb-3">
                                        <label for="password">Password <span>*</span></label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            required />
                                        @error('password')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="login_submit text-center d-flex justify-content-center align-items-center mt-4">
                                <button class="btn btn-primary mr-2" type="submit" style="width: 150px;">
                                    Register
                                </button>
                                <a href="{{ route('account.login') }}" class="btn btn-secondary"
                                    style="width: 100px;">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->
            </div>
        </div>
    </div>
    
    
    
    <script>
        function previewAvatar(event) {
            const avatarPreview = document.getElementById('avatarPreview');
            const file = event.target.files[0];
            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
                avatarPreview.classList.remove('d-none');
            } else {
                avatarPreview.src = '';
                avatarPreview.classList.add('d-none');
            }
        }
    </script>
    
@endsection
