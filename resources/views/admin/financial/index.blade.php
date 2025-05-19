@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <!-- Header with animated gradient -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="page-title">
                            <h4 class="fw-bold mb-1">Laporan Keuangan Asisten Dosen</h4>
                            <p class="text-muted mb-0">Detail pendapatan berdasarkan kehadiran</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Card with Glassmorphism Effect -->
            <div class="card border-0 mb-4 overflow-hidden" style="
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(246,248,252,0.9) 100%);
                backdrop-filter: blur(10px);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
                border-radius: 15px;
            ">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="position-relative" style="width: 90px; height: 90px;">
                                <img src="{{asset('img/asdos/' . $asdos->foto)}}" class="rounded-circle border border-4 border-white  position-absolute h-100 w-100"
                                    style="object-fit: cover; left: 0; top: 0;" alt="Foto Profil">
                            </div>
                        </div>
                        <div class="col">
                            <h3 class="mb-1 fw-bold">{{$asdos->nama}}</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{$asdos->stb}}</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{$asdos->jurusan}}</span>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-clock me-2"></i>
                                <small>Bergabung sejak {{ date('M Y', strtotime($asdos->created_at)) }}</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Financial Summary Cards -->
            <div class="row g-4 mb-4">
                <!-- Attendance Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Total Kehadiran</span>
                                    <h2 class="mt-2 mb-0 fw-bold fs-5">{{$pendapatan['kehadiran']}}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-calendar-check text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gross Income Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Pendapatan Kotor</span>
                                    <h2 class="mt-2 mb-0 fw-bold fs-5">Rp{{$pendapatan['pendapatan']}}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-wallet text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Pajak (5%)</span>
                                    <h2 class="mt-2 mb-0 fw-bold text-danger fs-5">- Rp{{$pendapatan['pajak']}}</h2>
                                </div>
                                <div class="bg-danger bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-receipt text-danger fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Income Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Pendapatan Bersih</span>
                                    <h2 class="mt-2 mb-0 fw-bold text-success fs-5">Rp{{$pendapatan['hasilbersih']}}</h2>
                                </div>
                                <div class="bg-info bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-hand-holding-usd text-info fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <style>
        /* Modern Card Styles */
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            border: none;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        /* Modern Timeline */
        .timeline-vertical {
            position: relative;
            padding-left: 50px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 30px;
        }

        .timeline-badge {
            position: absolute;
            left: -50px;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 0 0 5px rgba(40, 167, 69, 0.1);
            z-index: 2;
        }

        .timeline-panel {
            position: relative;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .timeline-panel:before {
            content: '';
            position: absolute;
            top: 20px;
            left: -15px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 15px 15px 15px 0;
            border-color: transparent #fff transparent transparent;
        }

        .timeline-header {
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 15px;
        }

        .timeline-body {
            margin-bottom: 15px;
        }

        .timeline-footer {
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        /* Custom Badges */
        .badge {
            padding: 5px 10px;
            font-weight: 500;
            letter-spacing: 0.3px;
            border-radius: 6px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .timeline-vertical {
                padding-left: 30px;
            }

            .timeline-badge {
                left: -30px;
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>

    <!-- Chart.js for interactive charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Income Distribution Chart
        const incomeCtx = document.getElementById('incomeDistributionChart').getContext('2d');
        const incomeChart = new Chart(incomeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pemrograman Web', 'Basis Data', 'Struktur Data'],
                datasets: [{
                    data: [375000, 225000, 300000],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp' + context.raw.toLocaleString();
                                return label;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Add hover effect to cards
        document.querySelectorAll('.hover-scale').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    </script>
@endsection