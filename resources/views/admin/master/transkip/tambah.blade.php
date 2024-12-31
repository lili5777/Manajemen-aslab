@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah akun</h4>
                    <h6>Buat akun baru</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postakun') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <input type="hidden" name="id" value="{{ isset($user) ? $user->id : '' }}">
                                <input type="hidden" name="id_pendaftar" value="{{ $id }}">
                                <div class="form-group">
                                    <label>KODE</label>
                                    <input type="text" name="kode" required
                                        value="{{ isset($user) ? $user->kode : '' }}">
                                    @error('kode')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Matkul</label>
                                    <input type="text" name="nama_matkul" required
                                        value="{{ isset($user) ? $user->nama_matkul : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>SKS</label>
                                    <input type="text" name="sks" required
                                        value="{{ isset($user) ? $user->sks : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nilai</label>
                                    <input id="nilai" type="text" name="nilai"
                                        value="{{ isset($user) ? $user->nilai : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('transkip', $id) }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
