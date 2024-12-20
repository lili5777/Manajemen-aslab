@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah periode</h4>
                    <h6>Buat periode baru</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postperiode') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input type="text" name="tahun">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('periode') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
