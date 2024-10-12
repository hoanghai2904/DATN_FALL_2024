@extends('admin.layouts.master')

@section('title', 'Cập nhật trạng thái')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Cập nhật trạng thái</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="status_contacts">Trạng thái</label>
                        <select name="status_contacts" class="form-control" required>
                            <option value="Chưa giải quyết" {{ $contact->status_contacts == 'Chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                            <option value="Đã liên hệ" {{ $contact->status_contacts == 'Đã liên hệ' ? 'selected' : '' }}>Đã liên hệ</option>
                        </select>
                    </div>

                    <div style="margin-top:10px">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn sửa đơn hàng này?')">Cập nhật</button>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Trở về</a>
                    </div>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
