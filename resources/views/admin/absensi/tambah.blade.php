<!-- Modal Tambah Kehadiran -->
<div class="modal fade" id="tambahKehadiranModal" tabindex="-1" aria-labelledby="tambahKehadiranModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahKehadiranModalLabel">Tambah Kehadiran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{route('postkehadiran')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pertemuan_ke" class="form-label">Pertemuan Ke <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="pertemuan_ke" name="pertemuan" required min="1"
                            value="{{ old('pertemuan_ke') }}">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Kehadiran <span
                                class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="alpa" {{ old('status') == 'alpa' ? 'selected' : '' }}>Alpa
                            </option>
                        </select>
                    </div>
                    <input type="text" value="{{$jadwal->id}}" hidden name="id_jadwal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>