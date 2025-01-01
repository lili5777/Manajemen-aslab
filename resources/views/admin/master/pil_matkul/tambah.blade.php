@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Tambah Pilihan Matkul</h4>
                    {{-- <h6></h6> --}}
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('postpilmatkul', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($pil) ? $pil->id : '' }}">
                        <input type="hidden" name="id_pendaftar" value="{{ $pendaftaran->id }}">

                        <div class="col-lg-12">
                            <label>Pilih Mata Kuliah (Maksimal 3 Pilihan):</label>
                            <div id="checkbox-group">
                                @foreach ($matkul as $m)
                                    <div class="form-check">
                                        <input class="form-check-input matkul-checkbox" type="checkbox" name="matkul[]"
                                            value="{{ $m->kode_kelas }}" id="matkul-{{ $m->id }}">
                                        <label class="form-check-label" for="matkul-{{ $m->id }}">
                                            {{ $m->nama_matkul }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('matkul')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('pilmatkul', $pendaftaran->id) }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.matkul-checkbox');
            const maxSelection = 3;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const selected = Array.from(checkboxes).filter(cb => cb.checked);
                    if (selected.length > maxSelection) {
                        this.checked = false;
                        alert(`Maksimal ${maxSelection} mata kuliah yang dapat dipilih.`);
                    }
                });
            });
        });
    </script>
@endsection
