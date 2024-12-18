@extends('admin.layouts.master')

@section('title', 'Tạo mới danh mục')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div>
            <label>Tên:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Slug:</label>
            <input type="text" name="slug" required>
        </div>
        <div>
            <label>Trạng thái:</label>
            <input type="checkbox" name="status" value="1" checked> Hoạt động
        </div>
        <button type="submit">Tạo mới</button>
    </form>
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
