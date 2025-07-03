@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah dosen</h4>
                    <h6>Buat dosen baru</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postdosen') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($dosen) ? $dosen->id : '' }}">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Akun</label>
                                    <select name="id_akun" id="id_akun" class="select2" required onchange="fillDataFromAccount()">
                                        <option value="">Pilih Akun</option>
                                        @foreach ($user as $a)
                                            <option value="{{ $a->id }}" 
                                                data-name="{{ $a->name }}"
                                                data-stb="{{ $a->stb }}"
                                                {{ isset($dosen) && $dosen->id_akun == $a->id ? 'selected' : '' }}>
                                                {{ Str::limit($a->name, 20) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_akun')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" id="nama" value="{{ isset($dosen) ? $dosen->nama : '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>NIDN</label>
                                    <input type="text" name="nidn" id="nidn" value="{{ isset($dosen) ? $dosen->nidn : '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>No WA</label>
                                    <input type="text" name="no_wa" value="{{ isset($dosen) ? $dosen->no_wa : '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Foto</label>
                                    <div class="image-upload">
                                        <input type="file" name="foto">
                                        <div class="image-uploads">
                                            <img src="{{ asset('img/icons/upload.svg') }}" alt="img">
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('dosen') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillDataFromAccount() {
            const selectElement = document.getElementById('id_akun');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            
            if (selectedOption.value !== "") {
                document.getElementById('nama').value = selectedOption.getAttribute('data-name');
                document.getElementById('nidn').value = selectedOption.getAttribute('data-stb');
            } else {
                document.getElementById('nama').value = "";
                document.getElementById('nidn').value = "";
            }
        }

        // Jalankan fungsi saat pertama kali load halaman (untuk kasus edit)
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($dosen))
                fillDataFromAccount();
            @endif
        });
    </script>
@endsection