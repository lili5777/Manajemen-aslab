@extends('admin.layout.master')
@section('konten')
            <div class="page-wrapper">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="row page-titles">
                        <div class="col-md-5 align-self-center">
                            <h4 class="text-themecolor">Pengaturan Bobot Penilaian</h4>
                            <div class="d-flex align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Pengaturan Bobot</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Card Utama -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Total bobot harus berjumlah 100%
                                    </div>
                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <i class="fas fa-check-circle me-2"></i>
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Kriteria</th>
                                                    <th width="20%">Bobot Saat Ini</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                                                        IPK
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary rounded-pill">{{ $ipk->bobot * 100 ?? 0 }}%</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-criteria="ipk"
                                                            data-value="{{ $ipk->bobot * 100 ?? 0 }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <i class="fas fa-book text-success me-2"></i>
                                                        Mata Kuliah Pilihan
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success rounded-pill">{{ $matkul->bobot * 100 ?? 0 }}%</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-criteria="nilai_matkul"
                                                            data-value="{{ $matkul->bobot * 100 ?? 0 }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <i class="fas fa-file-contract text-info me-2"></i>
                                                        Surat Rekomendasi
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-info rounded-pill">{{ $rekomendasi->bobot * 100 ?? 0 }}%</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-criteria="rekomendasi"
                                                            data-value="{{ $rekomendasi->bobot * 100 ?? 0 }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>
                                                        <i class="fas fa-file-signature text-danger me-2"></i>
                                                        Surat Pernyataan
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ $pernyataan->bobot * 100 ?? 0 }}%</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-criteria="pernyataan"
                                                            data-value="{{ $pernyataan->bobot * 100 ?? 0 }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td colspan="2" class="text-end">Total Bobot</td>
                                                    <td>
                                                        @php
    $total = ($ipk->bobot * 100 ?? 0) + ($matkul->bobot * 100 ?? 0) + ($rekomendasi->bobot * 100 ?? 0) + ($pernyataan->bobot * 100 ?? 0);
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $total == 100 ? 'success' : 'danger' }} rounded-pill">{{ $total }}%</span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Bobot -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Bobot</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="weightForm" method="POST" action="{{ route('setting.kriteriaUpdate') }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="criteria" id="criteriaInput">
                                <div class="mb-3">
                                    <label for="weightValue" class="form-label">Nilai Bobot (%)</label>
                                    <input type="number" class="form-control" id="weightValue" name="value" min="0" max="100"
                                        required>
                                    <div class="form-text">Masukkan nilai antara 0-100</div>
                                </div>
                                <div class="alert alert-warning">
                                    Pastikan total bobot tidak melebihi 100% setelah perubahan ini.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript untuk Modal -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var editModal = document.getElementById('editModal');

                    editModal.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;
                        var criteria = button.getAttribute('data-criteria');
                        var value = button.getAttribute('data-value');

                        var modalTitle = editModal.querySelector('.modal-title');
                        var criteriaInput = editModal.querySelector('#criteriaInput');
                        var weightInput = editModal.querySelector('#weightValue');

                        // Set nilai ke modal
                        criteriaInput.value = criteria;
                        weightInput.value = value;

                        // Update judul modal berdasarkan kriteria
                        var criteriaNames = {
                            'ipk': 'IPK',
                            'nilai_matkul': 'Mata Kuliah Pilihan',
                            'rekomendasi': 'Surat Rekomendasi',
                            'pernyataan': 'Surat Pernyataan'
                        };
                        modalTitle.textContent = 'Edit Bobot ' + criteriaNames[criteria];
                    });

                    // Validasi form sebelum submit
                    document.getElementById('weightForm').addEventListener('submit', function (e) {
                        var value = parseInt(document.getElementById('weightValue').value);
                        if (value < 0 || value > 100) {
                            e.preventDefault();
                            alert('Nilai bobot harus antara 0-100');
                        }
                    });
                });
            </script>

            <style>
                .table-hover tbody tr:hover {
                    background-color: rgba(0, 0, 0, 0.02);
                }

                .badge.rounded-pill {
                    font-size: 0.85em;
                    padding: 5px 10px;
                }
            </style>
@endsection