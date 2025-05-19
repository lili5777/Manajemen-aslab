<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ Request::routeIs('admin') ? 'active' : '' }}">
                    <a href="{{ route('admin') }}"><img src="{{ asset('img/icons/dashboard.svg') }}" alt="img" ><span>
                            Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('img/icons/product.svg') }}" alt="img"><span>
                            Master</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('ketentuan') }}" class="{{ Request::routeIs('ketentuan') ? 'active' : '' }}">Ketentuan</a></li>
                        @if (auth()->user()->role == 'mahasiswa')
                            <li><a href="{{ route('zpendaftar') }}" class="{{ Request::routeIs('zpendaftar') ? 'active' : '' }}">Pendaftaran</a>
                            </li>
                        @endif
                        @if (auth()->user()->role == 'admin')
                            <li><a href="{{ route('pendaftar') }}" class="{{ Request::routeIs('pendaftar') ? 'active' : '' }}">Data Pendaftar</a>
                            </li>
                        @endif
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'dosen')
                            <li><a href="{{ route('asdos') }}" class="{{ Request::routeIs('asdos') ? 'active' : '' }}">Data Asisten Labotarium</a></li>
                        @endif
                        <li><a href="{{ route('dosen') }}" class="{{ Request::routeIs('dosen') ? 'active' : '' }}">Data Dosen</a></li>
                        <li><a href="{{ route('matkul') }}" class="{{ Request::routeIs('matkul') ? 'active' : '' }}">Data Mata Kuliah Pratikum</a></li>
                        @if (auth()->user()->role == 'admin')
                        <li><a href="{{ route('akun') }}" class="{{ Request::routeIs('akun') ? 'active' : '' }}">Data Akun</a></li>
                        <li><a href="{{ route('periode') }}" class="{{ Request::routeIs('periode') ? 'active' : '' }}">Data Periode</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('img/icons/places.svg') }}" alt="img"><span>
                            Jadwal</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('jadwal') }}" class="{{ Request::routeIs('jadwal') ? 'active' : '' }}">Data Jadwal</a></li>
                    </ul>
                </li>
                @if (auth()->user()->role == 'admin')
                <li class="submenu">
                    <a href="javascript:void(0);"><i data-feather="alert-octagon"></i><span>
                            Verifikasi</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('verifikasi') }}" class="{{ Request::routeIs('verifikasi') ? 'active' : '' }}">Verifikasi Pendaftar</a></li>
                    </ul>
                </li>
                @endif
                <li class="submenu">
                    <a href="javascript:void(0);"><i data-feather="layers"></i><span> Absensi</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        @if (auth()->user()->role == 'mahasiswa')
                        <li><a href="{{route('absen')}}" class="{{ Request::routeIs('absen') ? 'active' : '' }}">Absensi</a></li>
                        @else
                            <li><a href="{{route('kelolaabsensi')}}" class="{{ Request::routeIs('kelolaabsensi') ? 'active' : '' }}">Verifikasi Absensi</a></li>
                        @endif
                        
                    </ul>
                </li>
                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'mahasiswa')
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="{{ asset('img/icons/purchase1.svg') }}"
                                alt="img"><span> Sertifikat</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{route('sertifikat')}}">Data Sertifikat</a></li>
                            {{-- <li><a href="addpurchase.html">Add Purchase</a></li>
                            <li><a href="importpurchase.html">Import Purchase</a></li> --}}
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="{{ asset('img/icons/expense1.svg') }}"
                                alt="img"><span>
                                Finansial</span> <span class="menu-arrow"></span></a>
                        <ul>
                            @if (auth()->user()->role == 'mahasiswa')
                            <li><a href="{{route('financial')}}">Data Fincial</a></li>
                            @else
                            <li><a href="{{route('rekapfinancial')}}">Rekap Fincial</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('img/icons/users1.svg') }}" alt="img"><span>
                            Users</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="newuser.html">New User </a></li>
                        <li><a href="userlists.html">Users List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('img/icons/settings.svg') }}"
                            alt="img"><span>
                            Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="generalsettings.html">General Settings</a></li>
                        <li><a href="emailsettings.html">Email Settings</a></li>
                        <li><a href="paymentsettings.html">Payment Settings</a></li>
                        <li><a href="currencysettings.html">Currency Settings</a></li>
                        <li><a href="grouppermissions.html">Group Permissions</a></li>
                        <li><a href="taxrates.html">Tax Rates</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
