@extends('admin.layouts.master')

@section('title', 'Cập nhật danh mục')

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Tên:</label>
            <input type="text" name="name" value="{{ $category->name }}" required>
        </div>
        <div>
            <label>Slug:</label>
            <input type="text" name="slug" value="{{ $category->slug }}" required>
        </div>
        <div>
            <label>Trạng thái:</label>
            <input type="checkbox" name="status" value="1" {{ $category->status ? 'checked' : '' }}> Hoạt động
        </div>
        <button type="submit">Cập nhật</button>
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
