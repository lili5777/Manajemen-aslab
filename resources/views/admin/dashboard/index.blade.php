@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            @if (auth()->user()->role == 'mahasiswa')
                <div class="content bg-light rounded-3 shadow-sm p-4 pb-1 text-center text-md-start mb-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 mb-4 mb-md-0">
                            <img src="{{ asset('img/brs.png') }}" alt="Illustration" class="img-fluid"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-12 col-md-6">
                            <h1 class="fw-bold">Hi, {{ Auth::user()->name }}</h1>
                            <p class="text-muted fs-5">Ready to start your journey as an Asisten Laboratorium?</p>
                            <a href="{{ route('zpendaftar') }}" class="btn btn-primary rounded-pill px-4 py-2 hover-effect">
                                Daftar Jadi Asisten Lab
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role == 'dosen')
                <div class="content bg-light rounded-3 shadow-sm p-4 pb-1 text-center text-md-start mb-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 mb-4 mb-md-0">
                            <img src="{{ asset('img/tcr.svg') }}" alt="Illustration" class="img-fluid"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-12 col-md-6">
                            <h1 class="fw-bold">Hi, {{ Auth::user()->name }}</h1>
                            <p class="text-muted fs-5">Ready to monitor and manage your Laboratory Assistants efficiently?</p>
                            <a href="{{ route('jadwal') }}" class="btn btn-primary rounded-pill px-4 py-2 hover-effect">
                                Lihat Asisten Lab Anda
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role == 'admin')
                <div class="content bg-light rounded-3 shadow-sm p-4 pb-1 text-center text-md-start mb-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 mb-4 mb-md-0">
                            <img src="{{ asset('home/assets/img/7712733_3714960-Photoroom.png') }}" alt="Illustration" class="img-fluid"
                                style="max-width: 75%; height: auto;">
                        </div>
                        <div class="col-12 col-md-6">
                            <h1 class="fw-bold">Hi, {{ Auth::user()->name }}</h1>
                            <p class="text-muted fs-5">Ready to monitor and manage your Laboratory Assistants efficiently?</p>
                            <a href="{{ route('asdos') }}" class="btn btn-primary rounded-pill px-4 py-2 hover-effect">
                                Lihat Asisten Lab Anda
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count hover-effect">
                        <div class="dash-counts">
                            <h4>{{ $pendaftar }}</h4>
                            <h5>Pendaftar</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das1 hover-effect">
                        <div class="dash-counts">
                            <h4>{{ $asdos }}</h4>
                            <h5>Asisten Laboratorium</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das2 hover-effect">
                        <div class="dash-counts">
                            <h4>{{ $jadwal }}</h4>
                            <h5>Praktek</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file-text"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3 hover-effect">
                        <div class="dash-counts">
                            <h4>{{$sertifikat}}</h4>
                            <h5>Sertifikat</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->



        </div>
    </div>

    <style>
        .hover-effect:hover {
            background-color: #0056b3 !important;
            transform: translateY(-5px);
            transition: all 0.3s ease;
            color: white !important;
        }

        .hover-effect:hover h5,
        .hover-effect:hover h4,
        .hover-effect:hover i {
            color: white !important;
        }

        .dash-count {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feed-item {
            padding: 10px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .feed-item:hover {
            background-color: #f8f9fa;
            border-left: 3px solid #0d6efd;
        }

        .feed-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

                const regCtx = document.getElementById('registrationsChart').getContext('2d');
                new Chart(regCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Pendaftar',
                            data: [12, 19, 15, 25, 22, 30, 28, 35, 30, 28, 32, 40],
                            backgroundColor: 'rgba(13, 110, 253, 0.2)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Lab Distribution Chart
                const labCtx = document.getElementById('labDistributionChart').getContext('2d');
                new Chart(labCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Komputasi', 'Sistem Digital', 'Jaringan', 'Multimedia', 'Basis Data'],
                        datasets: [{
                            data: [15, 10, 8, 12, 7],
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.8)',
                                'rgba(25, 135, 84, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(220, 53, 69, 0.8)',
                                'rgba(111, 66, 193, 0.8)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });

            });
    </script>
@endsection