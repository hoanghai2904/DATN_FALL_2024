@extends('admin.layouts.master')

@section('title', 'Tạo mới danh mục')

@section('content')
    <form action="{{route('admin.categories.store')}}" method="POST">
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
