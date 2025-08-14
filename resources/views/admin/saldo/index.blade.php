@extends('adminlte::page')

@section('title', 'Saldo Utama')

@section('content_header')
    <h1>Saldo Utama</h1>
@endsection

@section('content')
<div class="container">
    <!-- Baris Saldo Utama: full-width dan center -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-8">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #4E2603, #D68F3D);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center justify-content-center">
                        <i class="fas fa-wallet mr-2"></i> Saldo Utama
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-3 text-white">Rp. {{ number_format($saldoUtama->saldo ?? 0, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-4">Total Saldo Utama saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Saldo Utama terbaru</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris saldo lain: 4 kolom per baris -->
    <div class="row">
        <!-- Contoh 1 saldo -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #8E44AD, #D2B4DE);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-boxes mr-2"></i> Kas Logistik
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. {{ number_format($logisticsCash->saldo ?? 0, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-4">Total Kas Logistik saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Kas Logistik terbaru</small>
                </div>
            </div>
        </div>

        <!-- lain-lain... -->
        <!-- Ganti semua col-lg-4 menjadi col-lg-6 seperti di atas -->
        <!-- Kas Kecil Operasional -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #2F6B2C, #7ED957);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-briefcase mr-2"></i> Kas Kecil Operasional
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. {{ number_format($kasOperasional->saldo ?? 0, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-4">Total Kas Kecil Operasional saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Kas Kecil Operasional terbaru</small>
                </div>
            </div>
        </div>

        <!-- Kas Kecil Lokasi -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #16A085, #48C9B0);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i> Kas Kecil Lokasi
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. {{ number_format($kasLokasi->saldo ?? 0, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-4">Total Kas Kecil Lokasi saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Kas Kecil Lokasi terbaru</small>
                </div>
            </div>
        </div>

        <!-- Kas Gaji -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #E67E22, #F5B041);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-money-bill-wave mr-2"></i> Kas Gaji
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. 500.000</h1>
                    <p class="lead text-white mb-4">Total Kas Gaji saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Kas Gaji terbaru</small>
                </div>
            </div>
        </div>
<div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #f05f05ff, #d92d16ff);">
               <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-file-invoice-dollar mr-2"></i> Pajak
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. 500.000</h1>
                    <p class="lead text-white mb-4">Total Pajak saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Pajak terbaru</small>
                </div>
            </div>
        </div>

        <!-- Pinjaman -->
         <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #1f0063ff, #2f09a2ff);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-hand-holding-usd mr-2"></i> Pinjaman
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. 500.000</h1>
                    <p class="lead text-white mb-4">Total Pinjaman saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Pinjaman terbaru</small>
                </div>
            </div>
        </div>

        <!-- Tagihan -->
         <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #0b833bff, #0d7c66ff);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-file-invoice mr-2"></i> Invoice
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. {{ number_format($invoice ?? 0, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-4">Total Invoice saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data Invoice terbaru</small>
                </div>
            </div>
        </div>

        <!-- BPJS -->
         <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #0d7627ff, #F5B041);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-file-invoice mr-2"></i> BPJS
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. 500.000</h1>
                    <p class="lead text-white mb-4">Total BPJS saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data BPJS terbaru</small>
                </div>
            </div>
        </div>

        <!-- dan seterusnya... semua col-lg-4 jadi col-lg-6 -->
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
