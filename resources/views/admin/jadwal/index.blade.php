@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Data Jadwal</h4>
                    <h6>Kelola Jadwal</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('tambahjadwal') }}" class="btn btn-added"><img src="{{ asset('img/icons/plus.svg') }}"
                            alt="img" class="me-1">Tambah Jadwal</a>
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
                                                        src="{{ asset('img/icons/search-whites.svg') }}" alt="img"></a>
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
                                    <th>Hari</th>
                                    <th>Pukul</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>Matkul</th>
                                    <th>Dosen</th>
                                    <th>Asdos 1</th>
                                    <th>Asdos 2</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $a)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $a->hari }}</td>
                                        <td>{{ substr($a->pukul, 0, 5) }} -
                                            {{ \Carbon\Carbon::createFromFormat('H:i', substr($a->pukul, 0, 5))->addMinutes(100)->format('H:i') }}
                                        </td>
                                        <td>{{ $a->ruang }}</td>
                                        <td>{{ $a->kode_kelas }}</td>
                                        <td>{{ $a->prodi }}</td>
                                        <td>{{ $a->semester }}</td>
                                        <td>{{ $a->nama_matkul }}</td>
                                        <td>{{ $a->nama_dosen }}</td>
                                        <td>
                                            @if ($a->asdos1)
                                                {{ $a->asdos1 }}
                                            @else
                                                Belum ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($a->asdos2)
                                                {{ $a->asdos2 }}
                                            @else
                                                Belum ada
                                            @endif
                                        </td>
                                        <td>
                                            <a class="me-3" href="{{ route('detailakun', $a->id) }}">
                                                <img src="{{ asset('img/icons/eye.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3" href="{{ route('editakun', $a->id) }}">
                                                <img src="{{ asset('img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="confirm-text" href="javascript:void(0);"
                                                data-url="{{ route('hapusjadwal', $a->id) }}">
                                                <img src="{{ asset('img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
