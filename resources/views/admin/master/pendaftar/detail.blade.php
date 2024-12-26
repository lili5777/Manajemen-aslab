@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Pendaftar</h4>
                    <h6>Data Pendaftar</h6>
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
                                        <h6>{{ $p->nama }}</h6>
                                    </li>
                                    <li>
                                        <h4>Stambuk</h4>
                                        <h6>{{ $p->stb }}</h6>
                                    </li>
                                    <li>
                                        <h4>Alamat</h4>
                                        <h6>{{ $p->alamat }}</h6>
                                    </li>
                                    <li>
                                        <h4>Jurusan</h4>
                                        <h6>{{ $p->jurusan }}</h6>
                                    </li>
                                    <li>
                                        <h4>Tempat Tanggal Lahir</h4>
                                        <h6>{{ $p->tempat_lahir }}, {{ $p->ttl }}</h6>
                                    </li>
                                    <li>
                                        <h4>No WA</h4>
                                        <h6>{{ $p->no_wa }}</h6>
                                    </li>
                                    <li>
                                        <h4>Periode</h4>
                                        <h6>{{ $p->periode }}</h6>
                                    </li>
                                    <li>
                                        <h4>IPK</h4>
                                        <h6>{{ $p->ipk }}</h6>
                                    </li>
                                    <li>
                                        <h4>Status</h4>
                                        <h6>{{ $p->status }}</h6>
                                    </li>
                                    <li>
                                        <h4>Transkip Nilai</h4>
                                        @if ($p->transkip)
                                            <a href="{{ asset('file/transkip/' . $p->transkip) }}"
                                                class="btn btn-primary btn-sm px-3 my-2 mx-2" target="_blank">
                                                Lihat
                                            </a>
                                        @else
                                            <b class="text-red">Tidak Ada</b>
                                        @endif

                                    </li>
                                    <li>
                                        <h4>Surat Rekomendasi</h4>
                                        @if ($p->surat_pernyataan)
                                            <a href="{{ asset('file/surat_rekomendasi/' . $p->surat_rekomendasi) }}"
                                                class="btn btn-primary btn-sm px-3 my-2 mx-2" target="_blank">
                                                Lihat
                                            </a>
                                        @else
                                            <b class="text-red">Tidak Ada</b>
                                        @endif

                                    </li>
                                    <li>
                                        <h4>Surat Pernyataan</h4>
                                        @if ($p->surat_pernyataan)
                                            <a href="{{ asset('file/surat_pernyataan/' . $p->surat_pernyataan) }}"
                                                class="btn btn-primary btn-sm px-3 my-2 mx-2" target="_blank">
                                                Lihat
                                            </a>
                                        @else
                                            <b class="text-red">Tidak Ada</b>
                                        @endif
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
                                        <img src="{{ asset('img/asdos/' . $p->foto) }}" alt="img">
                                        <h4>{{ $p->foto }}</h4>

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
