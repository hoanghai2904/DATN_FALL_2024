@extends('admin.layouts.master')

@section('title', 'Danh sách danh mục')

@section('content')
    @if(session('message'))
        <h4>{{session('message')}}</h4>
    @endif

    <a href="{{route('admin.categories.create')}}">
        <button class="btn btn-success">Tạo mới</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->slug}}</td>
                <td>
                    {!! $category->status ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-danger">Không hoạt động</span>' !!}
                </td>
                <td>
                    <a href="{{route('admin.categories.show', $category)}}" class="btn btn-info">Xem</a>
                    <a href="{{route('admin.categories.edit', $category)}}" class="btn btn-warning">Sửa</a>
                    <form action="{{route('admin.categories.destroy', $category)}}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
