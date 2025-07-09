@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ isset($pendaftar) ? 'Edit Pendaftar' : 'Tambah Pendaftar' }}</h4>
                    <h6>{{ isset($pendaftar) ? 'Perbarui data pendaftar' : 'Buat pendaftar baru' }}</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postpendaftar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{ isset($pendaftar) ? $pendaftar->id : '' }}" hidden>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            @if (auth()->user()->role == 'admin')
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Akun</label>

                                    <select name="id_user" class="select2" required>
                                        {{-- <option value="" >Pilih Akun</option> --}}
                                        <option value="">Pilih Akun</option>
                                        @foreach ($user as $a)
                                            <option value="{{ $a->id }}"
                                                {{ isset($pendaftar) && $pendaftar->id_user == $a->id ? 'selected' : '' }}>
                                                {{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_user')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            @if (auth()->user()->role == 'mahasiswa')
                            <input type="text" value="{{auth()->user()->id}}" name="id_user" hidden>
                            @endif
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', isset($pendaftar) ? $pendaftar->nama : '') }}" required>
                                    @error('nama')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Stambuk</label>
                                    <input type="text" name="stb" class="form-control"
                                        value="{{ old('stb', isset($pendaftar) ? $pendaftar->stb : '') }}" required>
                                    @error('stb')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" class="form-control"
                                        value="{{ old('alamat', isset($pendaftar) ? $pendaftar->alamat : '') }}" required>
                                    @error('alamat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control"
                                        value="{{ old('jurusan', isset($pendaftar) ? $pendaftar->jurusan : '') }}"
                                        required>
                                    @error('jurusan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir', isset($pendaftar) ? $pendaftar->tempat_lahir : '') }}"
                                        required>
                                    @error('tempat_lahir')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="ttl" class="form-control"
                                        value="{{ old('ttl', isset($pendaftar) ? $pendaftar->ttl : '') }}" required>
                                    @error('ttl')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>No WhatsApp</label>
                                    <input type="text" name="no_wa" class="form-control"
                                        value="{{ old('no_wa', isset($pendaftar) ? $pendaftar->no_wa : '') }}" required>
                                    @error('no_wa')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control" accept=".png, .jpg, .jpeg"
                                        value="{{ old('foto', isset($pendaftar) ? $pendaftar->foto : '') }}">
                                    @if (isset($pendaftar) && $pendaftar->foto)
                                        <p class="mt-2">Foto saat ini: <a
                                                href="{{ asset('img/asdos/' . $pendaftar->foto) }}" target="_blank">Lihat
                                                Foto</a></p>
                                    @endif
                                    @error('foto')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Transkip</label>
                                    <input type="file" name="transkip" class="form-control"
                                        value="{{ old('transkip', isset($pendaftar) ? $pendaftar->transkip : '') }}" accept=".pdf">
                                    @if (isset($pendaftar) && $pendaftar->transkip)
                                        <p class="mt-2">Transkip saat ini: <a
                                                href="{{ asset('file/transkip/' . $pendaftar->transkip) }}"
                                                target="_blank">Lihat Transkip</a></p>
                                    @endif
                                    @error('transkip')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Surat Pernyataan</label>
                                    <input type="file" name="surat_pernyataan" class="form-control"
                                        value="{{ old('surat_pernyataan', isset($pendaftar) ? $pendaftar->surat_pernyataan : '') }}" accept=".pdf>
                                    @if (isset($pendaftar) && $pendaftar->surat_pernyataan)
                                        <p class="mt-2">Surat Pernyataan saat ini: <a
                                                href="{{ asset('file/surat_pernyataan/' . $pendaftar->surat_pernyataan) }}"
                                                target="_blank">Lihat Surat</a></p>
                                    @endif
                                    @error('surat_pernyataan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Surat Rekomendasi</label>
                                    <input type="file" name="surat_rekomendasi" class="form-control" accept=".pdf
                                        value="{{ old('surat_rekomendasi', isset($pendaftar) ? $pendaftar->surat_rekomendasi : '') }}">
                                    @if (isset($pendaftar) && $pendaftar->surat_rekomendasi)
                                        <p class="mt-2">Surat Rekomendasi saat ini: <a
                                                href="{{ asset('file/surat_rekomendasi/' . $pendaftar->surat_rekomendasi) }}"
                                                target="_blank">Lihat Surat</a></p>
                                    @endif
                                    @error('surat_rekomendasi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit"
                                    class="btn btn-submit me-2">{{ isset($pendaftar) ? 'Update' : 'Submit' }}</button>
                                <a href="{{ route('pendaftar') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
