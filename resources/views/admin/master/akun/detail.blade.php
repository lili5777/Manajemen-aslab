@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>User Details</h4>
                    <h6>Full details of a user</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4 class="fw-bold">STB/NIDN</h4>
                                        <h6>{{ $user->stb }}</h6>
                                    </li>
                                    <li>
                                        <h4 class="fw-bold">Nama</h4>
                                        <h6>{{ $user->name }}</h6>
                                    </li>
                                    <li>
                                        <h4 class="fw-bold">Email</h4>
                                        <h6>{{ $user->email }}</h6>
                                    </li>
                                    <li>
                                        <h4 class="fw-bold">Role</h4>
                                        <h6>{{ $user->role }}</h6>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        <img src="{{ asset('img/product/product69.jpg') }}" alt="img">
                                        <h4>macbookpro.jpg</h4>
                                        <h6>581kb</h6>
                                    </div>
                                    <div class="slider-product">
                                        <img src="{{ asset('img/product/product69.jpg') }}" alt="img">
                                        <h4>macbookpro.jpg</h4>
                                        <h6>581kb</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
@endsection
