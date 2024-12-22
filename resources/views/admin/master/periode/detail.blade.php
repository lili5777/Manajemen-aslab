@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Periode Details</h4>
                    <h6>Full details of a periode</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4 class="fw-bold">Periode</h4>
                                        <h6>{{ $periode->tahun }}</h6>
                                    </li>
                                    <li>
                                        <h4 class="fw-bold">Semester</h4>
                                        <h6>{{ $periode->semester }}</h6>
                                    </li>
                                    <li>
                                        <h4 class="fw-bold">Status</h4>
                                        <h6>{{ $periode->status }}</h6>
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
