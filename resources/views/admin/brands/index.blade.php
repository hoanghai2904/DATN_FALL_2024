{{-- extends: Chỉ định layout được sử dụng --}}
@extends('admin.layouts.master')

@section('title')
    Danh sách Brands
@endsection
{{-- section: định nghĩa nội dung của section --}}
@section('content')
    <div class="card">
        <h4 class="card-header">Danh sách</h4>
        <div class="card-body">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-success">Thêm </a>
            <table class="table">
                <thead>
                    <th>STT</th>
<<<<<<< HEAD
                    <th>Nhãn Hiệu</th>
                    <th>Tên thương hiệu</th>
=======
                    <th>Logo</th>
                    <th>Name</th>
                    <th>slug</th>
>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42
                    <th>Hành động</th>
                </thead>
                <tbody>
                    @foreach ($brands as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ Storage::url($item->logo) }}" width="100" height="100" alt="">
                            </td>
                            <td>{{ $item->name }}</td>
<<<<<<< HEAD
=======
                            <td>{{ $item->slug }}</td>
>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42
                            <td>
                                <a href="{{ route('admin.brands.edit', $item->id) }}">
                                    <button class="btn btn-warning">Sửa</button>
                                </a>
<<<<<<< HEAD
                                <form action="{{ route('admin.brands.destroy', $item->id) }}" method="post" style="display:inline;">
=======
                                <form action="{{ route('admin.brands.destroy', $item->id) }}" method="post">
>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('ban co muon xoa khong?')" class="btn btn-danger">Xóa</button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
