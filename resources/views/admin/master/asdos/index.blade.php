@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Data Pendaftar</h4>
                    <h6>Kelola Pendaftar</h6>
                </div>
                @if (auth()->user()->role == 'admin')
                <div class="page-btn">
                    <a href="{{ route('tambahpendaftar') }}" class="btn btn-added"><img src="{{ asset('img/icons/plus.svg') }}"
                            alt="img" class="me-1">Tambah Pendaftar</a>
                </div>
                @endif
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
                                    <th>Stambuk </th>
                                    <th>Jurusan</th>
                                    <th>WA</th>
                                    <th>Skor</th>
                                    <th>Rank</th>
                                    <th>periode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asdos as $p)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ asset('img/asdos/' . $p->foto) }}" alt="asdos">
                                            </a>
                                        </td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->stb }}</td>
                                        <td>{{ $p->jurusan }}</td>
                                        <td>{{ $p->no_wa }}</td>
                                        <td>{{ $p->skor }}</td>
                                        <td>{{ $p->rank }}</td>
                                        <td>{{ $p->periode }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('detailasdos', $p->id) }}">
                                                <img src="{{ asset('img/icons/eye.svg') }}" alt="img">
                                            </a>
                                            @if (auth()->user()->role == 'admin')
                                            <a class="me-3" href="{{ route('editpendaftar', $p->id) }}">
                                                <img src="{{ asset('img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="confirm-text" href="javascript:void(0);"
                                                data-url="{{ route('hapusasdos', $p->id) }}">
                                                <img src="{{ asset('img/icons/delete.svg') }}" alt="img">
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
