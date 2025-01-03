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
                    <form action="{{ route('postjadwal') }}" method="POST">
                        @csrf
                        <input type="text" name="id" value="{{ isset($jadwal) ? $jadwal->id : '' }}" hidden>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Hari</label>
                                    <select id="hari" name="hari" class="form-select select2" required>
                                        <option value="">Pilih hari</option>
                                        <option value="Senin"
                                            {{ isset($jadwal) && $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin
                                        </option>
                                        <option value="Selasa"
                                            {{ isset($jadwal) && $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa
                                        </option>
                                        <option value="Rabu"
                                            {{ isset($jadwal) && $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu
                                        </option>
                                        <option value="Kamis"
                                            {{ isset($jadwal) && $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis
                                        </option>
                                        <option value="Jumat"
                                            {{ isset($jadwal) && $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat
                                        </option>
                                    </select>
                                    @error('hari')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Jam Mulai</label>
                                    <input type="time" id="pukul_mulai" name="pukul_mulai" required
                                        value="{{ isset($jadwal) ? $jadwal->pukul : '' }}" class="form-control">
                                    @error('pukul_mulai')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Jam Selesai</label>
                                    <input type="time" id="pukul_selesai" name="pukul_selesai" required readonly
                                        value="{{ old('pukul') }}" class="form-control">
                                    @error('pukul_selesai')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ruang</label>
                                    <input type="text" name="ruang" required
                                        value="{{ isset($jadwal) ? $jadwal->ruang : '' }}">
                                    @error('ruang')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kode Kelas</label>
                                    <select id="kode_kelas" name="kode_kelas" class="form-select select2" required>
                                        <option value="">Pilih Kode Kelas</option>
                                        @foreach ($matkul as $m)
                                            <option value="{{ $m->kode_kelas }}"
                                                {{ isset($jadwal) && substr($jadwal->kode_kelas, 0, 5) == $m->kode_kelas ? 'selected' : '' }}>
                                                {{ $m->kode_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kode_kelas')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Huruf/Angka Kelas</label>
                                    <input type="text" id="huruf_kelas" name="huruf_kelas"
                                        value="{{ isset($jadwal) ? substr($jadwal->kode_kelas, -1) : '' }}" required>
                                    @error('huruf_kelas')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Prodi</label>
                                    <select id="prodi" name="prodi" class="form-select select2" required>
                                        <option value="">Pilih prodi</option>
                                        <option value="TI"
                                            {{ isset($jadwal) && $jadwal->prodi == 'TI' ? 'selected' : '' }}>Teknik
                                            Informatika</option>
                                        <option value="SI"
                                            {{ isset($jadwal) && $jadwal->prodi == 'SI' ? 'selected' : '' }}>Sistem
                                            Informasi</option>
                                        <option value="RPL"
                                            {{ isset($jadwal) && $jadwal->prodi == 'RPL' ? 'selected' : '' }}>Rekayasa
                                            Perangkat Lunak</option>
                                        <option value="BD"
                                            {{ isset($jadwal) && $jadwal->prodi == 'BD' ? 'selected' : '' }}>Bisnis Digital
                                        </option>
                                        <option value="MI"
                                            {{ isset($jadwal) && $jadwal->prodi == 'MI' ? 'selected' : '' }}>Manajemen
                                            Informatika</option>
                                        <option value="KU"
                                            {{ isset($jadwal) && $jadwal->prodi == 'KU' ? 'selected' : '' }}>Kewirausahaan
                                        </option>
                                    </select>
                                    @error('prodi')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Semester</label>
                                    <input type="text" id="semester" name="semester" required
                                        value="{{ isset($jadwal) ? $jadwal->semester : '' }}">
                                    @error('semester')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Mata Kuliah</label>
                                    <input type="text" name="nama_matkul" id="nama_matkul" required readonly
                                        value="{{ isset($jadwal) ? $jadwal->nama_matkul : '' }}">
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
                                            <option value="{{ $d->nama }}"
                                                {{ isset($jadwal) && $jadwal->nama_dosen == $d->nama ? 'selected' : '' }}>
                                                {{ $d->nama }}
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
                                    <select name="asdos1" class="form-select select2" required>
                                        <option value="">Pilih Asisten Dosen 1</option>
                                        @foreach ($asdos as $d)
                                            <option value="{{ $d->nama }}"
                                                {{ isset($jadwal) && $jadwal->asdos1 == $d->nama ? 'selected' : '' }}>
                                                {{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asdos1')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Asisten Dosen 2</label>
                                    <select name="asdos2" class="form-select select2" required>
                                        <option value="">Pilih Asisten Dosen 2</option>
                                        @foreach ($asdos as $d)
                                            <option value="{{ $d->nama }}"
                                                {{ isset($jadwal) && $jadwal->asdos2 == $d->nama ? 'selected' : '' }}>
                                                {{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const matkulData = @json($matkul);
        $(document).ready(function() {
            // Ketika kode kelas berubah
            $('#kode_kelas').change(function() {
                const kodeKelas = $(this).val();

                if (kodeKelas) {
                    // Ambil karakter pertama dari kode kelas
                    const semester = kodeKelas.charAt(0);
                    // Cari data berdasarkan kode kelas dari matkulData
                    const selectedMatkul = matkulData.find(matkul => matkul.kode_kelas === kodeKelas);

                    if (selectedMatkul) {

                        // Isi Nama Mata Kuliah
                        $('#nama_matkul').val(selectedMatkul.nama);
                        // Isi Semester
                        $('#semester').val(semester);

                    } else {
                        alert('Kode Kelas tidak ditemukan!');
                        $('#nama_matkul').val('');
                        $('#semester').val('');
                    }
                } else {
                    // Reset jika tidak ada kode kelas
                    $('#nama_matkul').val('');
                    $('#semester').val('');
                }
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            const inputJamMulai = document.getElementById('pukul_mulai');
            const inputJamSelesai = document.getElementById('pukul_selesai');

            inputJamMulai.addEventListener('input', function() {
                const jamMulai = inputJamMulai.value;

                if (jamMulai) {
                    // Konversi waktu ke menit
                    const [hours, minutes] = jamMulai.split(':').map(Number);
                    const totalMinutes = hours * 60 + minutes + 100; // Tambahkan 100 menit

                    // Hitung kembali jam dan menit
                    const newHours = Math.floor(totalMinutes / 60) %
                        24; // Gunakan mod 24 untuk format 24 jam
                    const newMinutes = totalMinutes % 60;

                    // Format angka ke dua digit
                    const formattedHours = String(newHours).padStart(2, '0');
                    const formattedMinutes = String(newMinutes).padStart(2, '0');

                    // Set nilai pada input Jam Selesai
                    inputJamSelesai.value = `${formattedHours}:${formattedMinutes}`;
                }
            });
        });
    </script>
@endsection
