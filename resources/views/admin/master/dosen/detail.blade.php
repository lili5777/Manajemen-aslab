@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Profil Dosen</h4>
                    <h6>Full details of a dosen</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Nama</h4>
                                        <h6>{{ $dosen->nama }}</h6>
                                    </li>
                                    <li>
                                        <h4>NIDN</h4>
                                        <h6>{{ $dosen->nidn }}</h6>
                                    </li>
                                    <li>
                                        <h4>Email</h4>
                                        <h6>{{ $dosen->email }}</h6>
                                    </li>
                                    <li>
                                        <h4>No WA</h4>
                                        <h6>{{ $dosen->no_wa }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        @if ($dosen->foto)
                                            <img src="{{ asset('img/dosen/' . $dosen->foto) }}" alt="img">
                                            <h4>{{ $dosen->foto }}</h4>
                                            <h6>Dosen</h6>
                                        @else
                                            <img src="{{ asset('img/dosen/pf.webp') }}" alt="img">
                                            <h4>{{ $dosen->nama }}</h4>
                                            <h6>Dosen</h6>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
