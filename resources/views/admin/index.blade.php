@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('embed-css')
@endsection

@section('custom-css')
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
</ol>
@endsection

@section('content')
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $count['user'] }}</h3>

          <p>Người Dùng</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua-active">
        <div class="inner">
          <h3>{{ $count['post'] }}</h3>

          <p>Bài Viết</p>
        </div>
        <div class="icon">
          <i class="fa fa-newspaper-o"></i>
        </div>
        <a href="{{ route('admin.post.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-orange">
        <div class="inner">
          <h3>{{ $count['product'] }}</h3>

          <p>Sản Phẩm</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.product.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3>{{ $count['order'] }}</h3>

          <p>Đơn Hàng</p>
        </div>
        <div class="icon">
          <i class="fa fa-list-alt"></i>
        </div>
        <a href="{{ route('admin.order.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <!-- /.row -->
@endsection

@section('embed-js')
  <!-- ChartJS -->
  <script src="{{ asset('AdminLTE/bower_components/chart.js/Chart.js') }}"></script>
@endsection

@section('custom-js')

@endsection
