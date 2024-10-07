@extends('admin.layouts.master')

@section('title', 'Cập nhật danh mục')

@section('content')
    <form action="{{route('admin.categories.update', $category)}}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Tên:</label>
            <input type="text" name="name" value="{{$category->name}}" required>
        </div>
        <div>
            <label>Slug:</label>
            <input type="text" name="slug" value="{{$category->slug}}" required>
        </div>
        <div>
            <label>Trạng thái:</label>
            <input type="checkbox" name="status" value="1" {{$category->status ? 'checked' : ''}}> Hoạt động
        </div>
        <button type="submit">Cập nhật</button>
    </form>
@endsection
