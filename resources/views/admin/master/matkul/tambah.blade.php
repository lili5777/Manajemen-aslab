@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah matkul</h4>
                    <h6>Buat matkul baru</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postmatkul') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" name="kode" required
                                        value="{{ isset($matkul) ? $matkul->kode : '' }}">
                                    @error('matkul')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Mata Kuliah Praktek</label>
                                    <input type="text" name="nama" value="{{ isset($matkul) ? $matkul->nama : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('matkul') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
