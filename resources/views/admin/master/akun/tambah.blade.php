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
                                <div class="form-group">
                                    <label>STB/NIDN</label>
                                    <input type="text" name="stb" required
                                        value="{{ isset($user) ? $user->stb : '' }}">
                                    @error('stb')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="name" required
                                        value="{{ isset($user) ? $user->name : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" required
                                        value="{{ isset($user) ? $user->email : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" type="password" name="password"
                                        {{ isset($user) ? '' : 'required' }}
                                        placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah password' : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select2" name="role" required>
                                        <option value="">Silahkan Pilih</option>
                                        <option value="admin"
                                            {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="dosen"
                                            {{ isset($user) && $user->role == 'dosen' ? 'selected' : '' }}>
                                            Dosen</option>
                                        <option value="mahasiswa"
                                            {{ isset($user) && $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('akun') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
