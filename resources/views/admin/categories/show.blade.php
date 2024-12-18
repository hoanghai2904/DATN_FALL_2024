@extends('admin.layouts.master')

@section('title', 'Chi tiết danh mục')

@section('content')
    <ul>
        <li><strong>ID:</strong> {{ $category->id }}</li>
        <li><strong>Tên:</strong> {{ $category->name }}</li>
        <li><strong>Slug:</strong> {{ $category->slug }}</li>
        <li><strong>Trạng thái:</strong>
            {!! $category->status
                ? '<span class="badge bg-success">Hoạt động</span>'
                : '<span class="badge bg-danger">Không hoạt động</span>' !!}
        </li>
    </ul>
@endsection
<script>
    const notyf = new Notyf();
    $(document).ready(function() {
        $('body').on('click', '.change-status', function() {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');
            console.log(isChecked, id);


            $.ajax({
                url: "{{ route('admin.product.change-status') }}",
                method: 'PUT',
                data: {
                    status: isChecked,
                    id: id
                },
                success: function(data) {
                    // toastr.success(data.message)
                    notyf.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })

        })
    })
</script>
