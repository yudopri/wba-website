@extends('adminlte::page')

@section('title', 'Saldo Utama')

@section('content_header')
    <h1>Saldo Utama</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #4E2603, #D68F3D);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-wallet mr-2"></i> Saldo Utama
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 5.000.000</h1>
                <p class="lead text-white mb-4">Total Saldo Utama saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Utama terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #8E44AD, #D2B4DE);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-boxes mr-2"></i> Saldo Kas Logistik
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Kas Logistik saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Kas Logistik terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #2F6B2C, #7ED957);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-briefcase mr-2"></i> Saldo Kas Kecil Operasional
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Kas Kecil Operasional saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Kas Kecil Operasional terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #16A085, #48C9B0);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i> Saldo Kas Kecil Lokasi
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Kas Kecil Lokasi saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Kas Kecil Lokasi terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #E67E22, #F5B041);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i> Saldo Kas Gaji
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Kas Gaji saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Kas Gaji terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #C0392B, #EC7063);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Saldo Pajak
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Pajak saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Pajak terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #2980B9, #5DADE2);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i> Saldo Pinjaman
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Pinjaman saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Pinjaman terbaru</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #9B59B6, #AF7AC5);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-file-invoice mr-2"></i> Saldo Tagihan
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Tagihan saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Tagihan terbaru</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #1E3A5F, #4A90E2);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-file-invoice mr-2"></i> Saldo BPJS
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo BPJS saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo BPJS terbaru</small>
            </div>
        </div>
    </div>
</div>

    <!-- Grafik Pie Chart -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i> Statistik Invoice</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartInvoice" style="max-height: 300px;"></canvas>
                </div>
                <div class="card-footer text-center">
                    <small><i class="fas fa-info-circle"></i> Data diambil secara real-time</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i> Statistik Tagihan</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartLaporan" style="max-height: 300px;"></canvas>
                </div>
                <div class="card-footer text-center">
                    <small><i class="fas fa-info-circle"></i> Data diambil secara real-time</small>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ url('/chart-garis-invoice') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Gagal memuat data");
                }
                return response.json();
            })
            .then(data => {
                var ctx = document.getElementById('chartInvoice').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Statistik Invoice',
                            data: data.values,
                            borderColor: '#36A2EB', // Warna garis
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna area di bawah garis
                            fill: false, // Tidak mengisi area bawah garis
                            tension: 0.1, // Membuat garis lebih halus
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal' // Bisa diganti sesuai kebutuhan
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah' // Bisa diganti sesuai data
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching chart data:", error));
    });

    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ url('/chart-garis-laporan') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Gagal memuat data");
                }
                return response.json();
            })
            .then(data => {
                var ctx = document.getElementById('chartLaporan').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Statistik Laporan Permasalahan',
                            data: data.values,
                            borderColor: '#FF6384', // Warna garis
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            tension: 0.1,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error fetching chart data:", error));
    });

</script>

@stop
