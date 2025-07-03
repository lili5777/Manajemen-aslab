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

            <!-- Alert untuk error umum -->
            @if($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Alert untuk error database -->
            @if($errors->has('database'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('database') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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
                                        value="{{ old('stb', isset($user) ? $user->stb : '') }}"
                                        class="{{ $errors->has('stb') ? 'is-invalid' : '' }}">
                                    @error('stb')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="name" required
                                        value="{{ old('name', isset($user) ? $user->name : '') }}"
                                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" required value="{{ old('email', isset($user) ? $user->email : '') }}"
                                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" type="password" name="password"
                                        {{ isset($user) ? '' : 'required' }}
                                        placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah password' : '' }}"
                                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select2" name="role" required>
                                        <option value="">Silahkan Pilih</option>
                                        <option value="admin"
                                            {{ old('role', isset($user) ? $user->role : '') == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="dosen"
                                            {{ old('role', isset($user) ? $user->role : '') == 'dosen' ? 'selected' : '' }}>
                                            Dosen</option>
                                        <option value="mahasiswa"
                                            {{ old('role', isset($user) ? $user->role : '') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                        </option>
                                    </select>
                                    @error('role')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
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