@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Mata Kuliah Detail</h4>
                    <h6>Full details of a Matkul</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Kode Matkul</h4>
                                        <h6>{{ $matkul->kode }}</h6>
                                    </li>
                                    <li>
                                        <h4>Kode Kelas</h4>
                                        <h6>{{ $matkul->kode_kelas }}</h6>
                                    </li>
                                    <li>
                                        <h4>Nama Mata Kuliah</h4>
                                        <h6>{{ $matkul->nama }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
