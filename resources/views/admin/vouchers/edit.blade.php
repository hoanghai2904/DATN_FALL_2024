@extends('admin.layouts.master')

@section('title', 'Chỉnh Sửa Voucher')
@section('embed-css')

@endsection
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('admin.vouchers.index') }}"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Quản Lý Voucher</a></li>
  <li class="active">Sửa Voucher</li>
</ol>
@endsection
@section('content')
@if ($errors->any())
  <div class="callout callout-danger">
    <h4>Warning!</h4>
    <ul style="margin-bottom: 0;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
    <form id="createproduct-form" method="POST" action="{{ route('admin.vouchers.update',[$find->id]) }}" autocomplete="off"
        class="needs-validation" novalidate>
        @method('PUT')
        @csrf
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name-input">Tên mã giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Tên mã giảm giá..."
                                        id="name-input" name="name" value="{{ old('name', $find->name) }}" oninput="generateCode()">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="code-input">Code</label>
                                    <input type="text" class="form-control" placeholder="Mã giảm giá..."
                                        id="code-input" name="code" value="{{ old('code', $find->code) }}" readonly>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Loại giảm giá</label>
                                    <select class="form-control" aria-label="Default select example" name="discount_type">
                                        <option value="" disabled {{ old('discount_type', $find->discount_type) == '' ? 'selected' : '' }}>Chọn loại giảm giá</option>
                                        <option value="0" {{ old('discount_type', $find->discount_type) == '0' ? 'selected' : '' }}>%</option>
                                        <option value="1" {{ old('discount_type', $find->discount_type) == '1' ? 'selected' : '' }}>Đ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Trạng thái</label>
                                    <select class="form-control" aria-label="Default select example" name="status">
                                        <option value="" disabled {{ old('status', $find->status) == '' ? 'selected' : '' }}>Chọn trạng thái</option>
                                        <option value="2" {{ old('status', $find->status) == '2' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="1" {{ old('status', $find->status) == '1' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Giá trị giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Nhập giá trị giảm giá"
                                    id="numberInput" oninput="formatNumber(this)" name="discount" min="1" value="{{ old('discount', $find->discount) }}"> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Số lần sử dụng</label>
                                    <input type="number" class="form-control" id="numberInput" name="max_uses" 
                                           placeholder="Nhập giá trị giảm giá" 
                                           value="{{ old('max_uses', $find->max_uses) }}" 
                                           min="1" oninput="formatNumber(this)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Số lượng</label>
                                    <input type="text" class="form-control" placeholder="Nhập số lượng..."
                                    id="numberInput" oninput="formatNumber(this)" name="qty" min="1" value="{{ old('qty', $find->qty) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="start" value="{{ old('start', $find->start) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="end" value="{{ old('end', $find->end) }}">
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                </div>
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                </div>
            </div>
        </div>
        </div>
        <!-- end row -->

    </form>
    @endsection
    
    @section('embed-js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.15/tinymce.min.js"></script>
    @endsection
    @section('custom-js')
    <script>
        tinymce.init({
          selector: 'textarea#post-content',
          plugins: 'media image code table link lists preview fullscreen',
          toolbar: 'undo redo | formatselect | fontsizeselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image media table | code preview fullscreen',
          toolbar_drawer: 'sliding',
          entity_encoding : "raw",
          branding: false,
          /* enable title field in the Image dialog*/
          image_title: true,
          height: 400,
          min_height: 300,
          relative_urls: false,
          /* Link Custom */
          link_assume_external_targets: 'http',
          /* disable media advanced tab */
          media_alt_source: false,
          media_poster: false,
          /* enable automatic uploads of images represented by blob or data URIs*/
          automatic_uploads: true,
          /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
          */
          file_picker_types: 'image',
          /* and here's our custom image picker*/
          file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
      
            /*
              Note: In modern browsers input[type="file"] is functional without
              even adding it to the DOM, but that might not be the case in some older
              or quirky browsers like IE, so you might want to add it to the DOM
              just in case, and visually hide it. And do not forget do remove it
              once you do not need it anymore.
            */
      
            input.onchange = function () {
              var file = this.files[0];
      
              var reader = new FileReader();
              reader.onload = function () {
                /*
                  Note: Now we need to register the blob in TinyMCEs image blob
                  registry. In the next release this part hopefully won't be
                  necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
      
                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
              };
              reader.readAsDataURL(file);
            };
      
            input.click();
          }
        });
      
        $(document).ready(function(){
          $("#upload").change(function() {
            $('.upload-image .image-preview').css('background-image', 'url("' + getImageURL(this) + '")');
          });
        });
      
        function getImageURL(input) {
          return URL.createObjectURL(input.files[0]);
        };
      </script>
    <script>
        function generateCode() {
            const nameInput = document.getElementById('name-input').value;
            const codeInput = document.getElementById('code-input');

            // Get the current date
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0'); // Get the day
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Get the month (0-indexed)

            // Extract the first letter of each word from the name input
            const firstLetters = nameInput
                .split(' ')
                .map(word => word.charAt(0).toUpperCase()) // Get the first letter and convert to uppercase
                .join(''); // Join them without spaces

            // Generate a code based on the first letters and the current day and month
            if (firstLetters) {
                const code = `${firstLetters}-${month}${day}`;
                codeInput.value = code;
            } else {
                codeInput.value = '';
            }
        }
    </script>
@endsection
