@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah Jadwal</h4>
                    <h6>Buat jadwal baru</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Hari</label>
                                    <input type="text" name="hari" required value="{{ old('hari') }}">
                                    @error('hari')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Pukul</label>
                                    <input type="time" name="pukul" required value="{{ old('pukul') }}"
                                        class="form-control">
                                    @error('pukul')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ruang</label>
                                    <input type="text" name="ruang" required value="{{ old('ruang') }}">
                                    @error('ruang')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kode Kelas</label>
                                    <select name="kode_kelas" class="form-select select2" required>
                                        <option value="">Pilih Kode Kelas</option>
                                        @foreach ($matkul as $m)
                                            <option value="{{ $m->kode_kelas }}">{{ $m->kode_kelas }}
                                            </option>
                                        @endforeach

                                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                    </select>
                                    @error('kode_kelas')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Prodi</label>
                                    <input type="text" name="prodi" required value="{{ old('prodi') }}">
                                    @error('prodi')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Semester</label>
                                    <input type="text" name="semester" required value="{{ old('semester') }}">
                                    @error('semester')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Mata Kuliah</label>
                                    <input type="text" name="nama_matkul" required value="{{ old('nama_matkul') }}">
                                    @error('nama_matkul')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Dosen</label>
                                    <select name="nama_dosen" class="form-select select2" required>
                                        <option value="">Pilih Nama Dosen</option>
                                        @foreach ($dosen as $d)
                                            <option value="{{ $d->nama }}">{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Asisten Dosen 1</label>
                                    <input type="text" name="asdos1" value="{{ old('asdos1') }}">
                                    @error('asdos1')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Asisten Dosen 2</label>
                                    <input type="text" name="asdos2" value="{{ old('asdos2') }}">
                                    @error('asdos2')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('jadwal') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
