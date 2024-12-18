@extends('admin.layouts.master')

@section('title', 'Quản Lý Mã Giảm Giá')
@section('embed-css')
<link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Quản Lý Bài Viết</li>
</ol>
@endsection
@section('custom-css')
<style>
  #post-table td,
  #post-table th {
    vertical-align: middle !important;
  }
  #post-table span.status-label {
    display: block;
    width: 85px;
    text-align: center;
    padding: 2px 0px;
  }
  #search-input span.input-group-addon {
    padding: 0;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 34px;
    border: none;
    background: none;
  }
  #search-input span.input-group-addon i {
    font-size: 18px;
    line-height: 34px;
    width: 34px;
    color: #f30;
  }
  #search-input input {
    position: static;
    width: 100%;
    font-size: 15px;
    line-height: 22px;
    padding: 5px 5px 5px 34px;
    float: none;
    height: unset;
    border-color: #fbfbfb;
    box-shadow: none;
    background-color: #e8f0fe;
    border-radius: 5px;
  }
</style>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="live-preview">
                        <div>
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-6">
                                  <div id="search-input" class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="search...">
                                  </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-6">
                                  <div class="btn-group pull-right">
                                    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success btn-flat" title="New Post">
                                      <i class="fa fa-plus" aria-hidden="true"></i><span class="hidden-xs"> New Voucher</span>
                                    </a>
                                  </div>
                                </div>
                              </div>
                              <div class="box-body">
                            <table id="post-table" class="table table-hover" style="width:100%; min-width: 768px;">
                                <thead>
                                    <tr>
                                        <th data-width="10px">ID</th>
                                        <th data-orderable="false">Mã</th>
                                        <th data-orderable="false">Tên mã giảm giá</th>
                                        <th data-orderable="false">Giảm giá</th>
                                        <th data-orderable="false">Trạng thái</th>
                                        <th data-orderable="false">Số lượng</th>
                                        <th data-width="60px" data-type="date-euro">Ngày bắt đầu</th>
                                        <th data-width="60px" data-type="date-euro">Ngày kết thúc</th>
                                        <th data-orderable="false" data-width="70px">Hành động</th>
                                    </tr>
                                </thead>
                                @if (!empty($list))
                                    @foreach ($list as $key => $item)
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td> {{ $item->code }}</td>
                                                <td><a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                    >{{ $item->name }}</a></td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}₫
                                                    @else
                                                        {{ number_format($item->discount, 0, '', '.') }}%
                                                    @endif
                                                </td>
                                                <td>
                                                  <div dir="ltr" class="toggle-icon" data-id="{{ $item->id }}">
                                                      @if ($item->status == 0)
                                                          <i class="fa-solid fa-toggle-off" data-status="0"></i>
                                                      @else
                                                          <i class="fa-solid fa-toggle-on" data-status="1"></i>
                                                      @endif
                                                  </div>
                                              </td>  
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->start }}</td>
                                                <td>{{ $item->end }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                        class="btn btn-sm btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <a href="{{ route('admin.vouchers.destroy', $item->id) }}"
                                                            class="btn btn-sm btn-danger delete-item"><i class="fa fa-trash"></i></a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center">Không có mã giảm giá nào</td>
                                    </tr>
                                @endif
                            </table>
                            </div>
                            <div class="float-right">
                                {{ $list->links() }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>


@endsection
@section('embed-js')
  <!-- DataTables -->
  <script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/date-euro.js"></script>
@endsection
@section('custom-js')
<script>
    $(function () {
      var table = $('#post-table').DataTable({
        "language": {
          "zeroRecords":    "Không tìm thấy kết quả phù hợp",
          "info":           "Hiển thị trang <b>_PAGE_/_PAGES_</b> của <b>_TOTAL_</b> bài viết",
          "infoEmpty":      "Hiển thị trang <b>1/1</b> của <b>0</b> bài viết",
          "infoFiltered":   "(Tìm kiếm từ <b>_MAX_</b> bài viết)",
          "emptyTable": "Không có dữ liệu bài viết",
        },
        "lengthChange": false,
         "autoWidth": false,
         "order": [],
        "dom": '<"table-responsive"t><<"row"<"col-md-6 col-sm-6"i><"col-md-6 col-sm-6"p>>>',
        "drawCallback": function(settings) {
          var api = this.api();
          if (api.page.info().pages <= 1) {
            $('#'+ $(this).attr('id') + '_paginate').hide();
          }
        }
      });
  
      $('#search-input input').on('keyup', function() {
          table.search(this.value).draw();
      });
    });
  
    $(document).ready(function(){
  
      $(".deleteDialog").click(function() {
  
        var post_id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
  
        Swal.fire({
          type: 'question',
          title: 'Thông báo',
          text: 'Bạn có chắc muốn xóa bài viết này?',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return fetch(url, {
              method: 'POST',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              body: JSON.stringify({'post_id': post_id}),
            })
            .then(response => {
              if (!response.ok) {
                throw new Error(response.statusText);
              }
              return response.json();
            })
            .catch(error => {
              Swal.showValidationMessage(error);
  
              Swal.update({
                type: 'error',
                title: 'Lỗi!',
                text: '',
                showConfirmButton: false,
                cancelButtonText: 'Ok',
              });
            })
          },
        }).then((result) => {
          if (result.value) {
            Swal.fire({
              type: result.value.type,
              title: result.value.title,
              text: result.value.content,
            }).then((result) => {
              if (result.value)
                location.reload(true);
            });
          }
        })
      });
    });
  </script>
<script>
    const notyf = new Notyf();
    $(document).ready(function() {
        $('body').on('click', '.change-status', function() {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.vouchers.updateStatus') }}",
                method: 'PUT',
                data: {
                    status: isChecked ? 2 : 1, // Hoạt động: 2, Ngừng hoạt động: 1
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    notyf.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        // Hàm kiểm tra trạng thái mã giảm giá theo thời gian thực
        setInterval(function() {
            $.ajax({
                url: "{{ route('admin.vouchers.checkStatus') }}",
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        // Cập nhật trạng thái checkbox cho các mã giảm giá đã hết hạn
                        response.data.forEach(function(id) {
                            let checkbox = $('input[data-id="' + id + '"]');
                            checkbox.prop('checked', false);
                        });
                        notyf.success(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }, 60000); // Kiểm tra mỗi phút
    });
</script>

@endsection