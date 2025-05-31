@extends('admin.layout.master')
@section('konten')
    @if ($ada)
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header mb-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="page-title">
                                <h4>Data Sertifikat</h4>
                                <h6>Kelola sertifikat</h6>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-danger">
                    <h4><i class="fas fa-exclamation-triangle"></i> Anda belum terdaftar sebagai Asisten Labotarium pada periode ini.
                    </h4>
                    <p class="mb-0">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div> 
    @else
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Data Sertifikat</h4>
                        <h6>Kelola sertifikat</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="{{ asset('img/icons/filter.svg') }}" alt="img">
                                        <span><img src="{{ asset('img/icons/closes.svg') }}" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="{{ asset('img/icons/search-white.svg') }}"
                                            alt="img"></a>
                                </div>
                            </div>
                            <div class="wordset">
                                <ul>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                src="{{ asset('img/icons/pdf.svg') }}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                src="{{ asset('img/icons/excel.svg') }}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                src="{{ asset('img/icons/printer.svg') }}" alt="img"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mb-0" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select class="select">
                                                        <option>Choose Product</option>
                                                        <option>Macbook pro</option>
                                                        <option>Orange</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select class="select">
                                                        <option>Choose Category</option>
                                                        <option>Computers</option>
                                                        <option>Fruits</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select class="select">
                                                        <option>Choose Sub Category</option>
                                                        <option>Computer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select class="select">
                                                        <option>Brand</option>
                                                        <option>N/D</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 col-12 ">
                                                <div class="form-group">
                                                    <select class="select">
                                                        <option>Price</option>
                                                        <option>150.00</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <a class="btn btn-filters ms-auto"><img
                                                            src="assets/img/icons/search-whites.svg" alt="img"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Periode </th>
                                        <th>Qrcode</th>
                                        <th>Sertifikat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)

                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    @if($item['asdos']->foto)
                                                        <img src="{{ asset('img/asdos/' . $item['asdos']->foto) }}" alt="foto">
                                                    @else
                                                        <img src="{{ asset('img/default-profile.png') }}" alt="foto">
                                                    @endif
                                                </a>
                                            </td>
                                            <td>{{ $item['asdos']->nama }}</td>
                                            <td>{{ $item['periode']->semester }} - {{ $item['periode']->tahun }}</td>
                                            <td>
                                                <img src="{{ asset('qrcode/' . $item['qr_code']) }}" alt="QR Code" class="qr-thumbnail"
                                                    onclick="showQrModal('{{ asset('qrcode/' . $item['qr_code']) }}')">
                                            </td>
                                            <td>
                                                @if (Auth::user()->role == 'admin')
                                                    @if($item['file_path'])
                                                        <a href="{{ $item['url'] }}" target="_blank"
                                                            class="badge bg-primary border-0 text-white">
                                                            Lihat Sertifikat
                                                        </a>
                                                    @else
                                                        <button type="button" class="badge bg-warning border-0" data-bs-toggle="modal"
                                                            data-bs-target="#uploadModal{{ $item['id'] }}">Belum diupload</button>
                                                    @endif
                                                @else
                                                    @if($item['file_path'])
                                                        <a href="{{ $item['url'] }}" target="_blank"
                                                            class="badge bg-primary border-0 text-white">
                                                            Lihat Sertifikat
                                                        </a>
                                                    @else
                                                        <span class="badge bg-warning border-0">Belum diupload</span>
                                                    @endif
                                                @endif

                                            </td>
                                        </tr>
                                        @include('admin.sertifikat.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Bootstrap -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">Terjadi Kesalahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('error') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if(session('error'))
            <script>
                window.onload = () => {
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                };
            </script>
        @endif

        <!-- Modal untuk menampilkan gambar besar -->
        <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalQrImage" src="" alt="QR Code" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <style>
            .qr-thumbnail {
                width: 80px;
                height: 80px;
                cursor: pointer;
                transition: transform 0.2s;
            }

            .qr-thumbnail:hover {
                transform: scale(1.05);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }
        </style>
        <script>
            function showQrModal(imageSrc) {
                document.getElementById('modalQrImage').src = imageSrc;
                var modal = new bootstrap.Modal(document.getElementById('qrModal'));
                modal.show();
            }
        </script>
    @endif


@endsection