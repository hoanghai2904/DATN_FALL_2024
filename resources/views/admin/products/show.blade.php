@extends('admin.layouts.master')

@section('title')
    Chi tiết sản phẩm : {{ $product->name }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-lg-5">
                            <div class="col-xl-4 col-md-8 mx-auto">
                                <div class="product-img-slider sticky-side-div">

                                    <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                        <div class="swiper-wrapper">
                                            {{-- @foreach ($product->galleries as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                                    class="img-fluid d-block" />
                                                </div>
                                            @endforeach --}}
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt=""
                                                class="img-fluid d-block" />
                                        </div>
                                        {{-- <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div> --}}
                                    </div>

                                    <!-- end swiper thumbnail slide -->
                                    {{-- <div class="swiper product-nav-slider mt-2">
                                        <div class="swiper-wrapper">

                                            @foreach ($product->galleries as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                                    class="img-fluid d-block" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div> --}}
                                    <!-- end swiper nav slide -->
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-xl-8">
                                <div class="mt-xl-0 mt-5">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4>{{ $product->name }}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><a href="#"
                                                        class="text-primary d-block">{{ $product->brand->name }}</a></div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Mã sản phẩm : <span
                                                        class="text-body fw-medium">{{ $product->sku }}</span></div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Số lượng : <span
                                                        class="text-body fw-medium">{{ $product->qty }}</span></div>
                                                <div class="vr"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                        <div class="text-muted fs-16">
                                            <span class="mdi mdi-star text-warning"></span>
                                            <span class="mdi mdi-star text-warning"></span>
                                            <span class="mdi mdi-star text-warning"></span>
                                            <span class="mdi mdi-star text-warning"></span>
                                            <span class="mdi mdi-star text-warning"></span>
                                        </div>
                                        {{-- <div class="text-muted">( 5.50k Customer Review )</div> --}}
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-4 col-sm-6">
                                            <h5 class="mb-0">
                                                @php
                                                    // Calculate the sale percentage
                                                    $salePer = 0;
                                                    if ((float) $product->price_sale > 0) {
                                                        $salePer = round(
                                                            (($product->price - $product->price_sale) /
                                                                $product->price) *
                                                                100,
                                                        );
                                                    }
                                                @endphp

                                                @if ((float) $product->price_sale > 0)
                                                    <div class="d-flex align-items-center mx-2">
                                                        <!-- Sale Percentage Badge -->
                                                        <span class="badge bg-light text-danger me-2">
                                                            -{{ $salePer }}%
                                                        </span>

                                                        <!-- Sale Price -->
                                                        <div data-order="{{ $product->price_sale }}"
                                                            class="fw-bold text-danger">
                                                            {{ number_format((float) $product->price_sale, 0, ',', '.') }}₫
                                                        </div>

                                                        <!-- Original Price -->
                                                        <del data-order="{{ $product->price }}" class="text-muted ms-2"
                                                            style="font-size: 0.85em;">
                                                            {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                        </del>
                                                    </div>
                                                @else
                                                    <div data-order="{{ $product->price }}" class="fw-bold text-danger mb-3">
                                                        {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                    </div>
                                                @endif


                                            </h5>

                                        </div>
                                        <!-- end col -->
                                        {{-- <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-file-copy-2-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Mã sản phẩm :</p>
                                                        <h6 class="mb-0">{{ $product->sku }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                        {{-- <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div
                                                            class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-stack-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Available Stocks :</p>
                                                        <h5 class="mb-0">1,230</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                        {{-- <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div
                                                            class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-inbox-archive-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Total Revenue :</p>
                                                        <h5 class="mb-0">$60,645</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                    </div>

                                    <div class="row">
                                        @foreach ($variantTypes as $variantTypeName => $variants)
                                            <div class="mb-3">
                                                <div class="col-xl-6">
                                                    <div class="mt-2">
                                                        <h5 class="fs-14">{{ $variantTypeName }} :</h5>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @foreach ($variants as $variant)
                                                                <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Out of Stock">
                                                                    <input type="radio" class="btn-check"
                                                                        name="productsize-radio"
                                                                        id="variant-{{ $variant->variantValue->id }}"
                                                                        autocomplete="off">
                                                                    <label
                                                                        class="btn btn-outline-secondary border p-2 d-flex justify-content-center align-items-center text-center"
                                                                        for="variant-{{ $variant->variantValue->id }}">
                                                                        {{ $variant->variantValue->value }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                        <!-- end col -->

                                        {{-- <div class="col-xl-6">
                                            <div class=" mt-4">
                                                <h5 class="fs-14">Colors :</h5>
                                                <div class="d-flex flex-wrap gap-2">

                                                    <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-placement="top" title="Out of Stock">
                                                        <button type="button"
                                                            class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-primary"
                                                            >
                                                            <i class="ri-checkbox-blank-circle-fill"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="mb-3">
                                            <div class="d-flex">
                                                <button class="btn btn-outline-secondary" id="decrement"
                                                    type="button">-</button>
                                                <input type="number" class="text-center" id="qty" name="qty"
                                                    value="1" min="1">
                                                <button class="btn btn-outline-secondary" id="increment"
                                                    type="button">+</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-dark ">Thêm vào giỏ</button>
                                    </div>

                                    <!-- end row -->

                                    <div class="mt-4 text-muted">
                                        <h5 class="fs-14">Mô tả sản phẩm :</h5>
                                        <p>{{ $product->description }}</p>
                                    </div>



                                    <div class="product-content mt-5">
                                        <h5 class="fs-14 mb-3">Chi tiết sản phẩm :</h5>
                                        <nav>
                                            <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab"
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                                        href="#nav-speci" role="tab" aria-controls="nav-speci"
                                                        aria-selected="true">Đặc điểm </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                        href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                        aria-selected="false">Mô tả</a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                                aria-labelledby="nav-speci-tab">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">Danh mục</th>
                                                                <td>{{ $product->category->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Thương hiệu</th>
                                                                <td>{{ $product->brand->name }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                                aria-labelledby="nav-detail-tab">
                                                <div>
                                                    <h5 class="font-size-16 mb-3">{{ $product->name }}
                                                    </h5>
                                                    <p>{!! $product->content !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product-content -->

                                    <div class="mt-5">
                                        <div>
                                            <h5 class="fs-14 mb-3">Xếp hạng và đánh giá</h5>
                                        </div>
                                        <div class="row gy-4 gx-0">
                                            <div class="col-lg-4">
                                                <div>
                                                    <div class="pb-3">
                                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                    <div class="fs-16 align-middle text-warning">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-half-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h6 class="mb-0">4.5 out of 5</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="text-muted">Total <span
                                                                    class="fw-medium">5.50k</span> reviews
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">5 star</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-success"
                                                                            role="progressbar" style="width: 50.16%"
                                                                            aria-valuenow="50.16" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">2758</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">4 star</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-success"
                                                                            role="progressbar" style="width: 19.32%"
                                                                            aria-valuenow="19.32" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">1063</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">3 star</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-success"
                                                                            role="progressbar" style="width: 18.12%"
                                                                            aria-valuenow="18.12" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">997</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">2 star</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-warning"
                                                                            role="progressbar" style="width: 7.42%"
                                                                            aria-valuenow="7.42" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">408</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">1 star</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-danger"
                                                                            role="progressbar" style="width: 4.98%"
                                                                            aria-valuenow="4.98" aria-valuemin="0"
                                                                            aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">274</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-8">
                                                <div class="ps-lg-4">
                                                    @if ($comments->isNotEmpty())
                                                        <div class="d-flex flex-wrap align-items-start gap-3">
                                                            <h5 class="fs-14">Đánh giá: </h5>
                                                        </div>

                                                        <div class="me-lg-n3 pe-lg-4" data-simplebar
                                                            style="max-height: 225px;">
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach ($comments as $comment)
                                                                    <li class="py-2">
                                                                        <div class="border border-dashed rounded p-3">
                                                                            <div class="d-flex align-items-start mb-3">
                                                                                <div class="hstack gap-3">
                                                                                    <div
                                                                                        class="badge rounded-pill bg-success mb-0">
                                                                                        <i
                                                                                            class="mdi mdi-star"></i>{{ $comment->rating }}
                                                                                    </div>
                                                                                    <div class="vr"></div>
                                                                                    <div class="flex-grow-1">
                                                                                        <p class="text-muted mb-0">
                                                                                            {{ $comment->comment }}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex align-items-end">
                                                                                <div class="flex-grow-1">
                                                                                    <h5 class="fs-14 mb-0">
                                                                                        {{ $comment->user->full_name }}
                                                                                    </h5>
                                                                                </div>

                                                                                <div class="flex-shrink-0">
                                                                                    <p class="text-muted fs-13 mb-0">
                                                                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y : H:i') }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <p>Hiện tại không có đánh giá nào.</p>
                                                    @endif
                                                </div>
                                            </div>


                                            <!-- end col -->
                                        </div>
                                        <!-- end Ratings & Reviews -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
@endsection

@push('script')
    <script>
        // Lấy các phần tử button và input
        const decrement = document.getElementById('decrement');
        const increment = document.getElementById('increment');
        const qtyInput = document.getElementById('qty');

        decrement.addEventListener('click', () => {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue > 0) {
                qtyInput.value = currentValue - 1;
            } else {
                qtyInput.value = 0; // Đảm bảo không có giá trị âm
            }
        });

        increment.addEventListener('click', () => {
            let currentValue = parseInt(qtyInput.value);
            qtyInput.value = currentValue + 1;
        });

        qtyInput.addEventListener('input', () => {
            let currentValue = parseInt(qtyInput.value);
            if (isNaN(currentValue) || currentValue < 0) {
                qtyInput.value = 0; // Nếu giá trị âm, đặt lại thành 0
            }
        });
    </script>
@endpush