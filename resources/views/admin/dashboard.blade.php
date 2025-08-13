@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <!-- Jumlah Pengunjung -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-users mr-2"></i> Jumlah Pengunjung
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-3 text-white">{{ $visitorCount }}</h1>
                    <p class="lead text-white mb-4">Total pengunjung saat ini</p>
                </div>
                <div class="card-footer bg-transparent text-white text-center">
                    <small>Data pengunjung terbaru</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pie Chart -->
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Tracking Invoice
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChartInvoice" style="max-height: 300px;"></canvas>
                </div>
                <div class="card-footer text-center">
                    <small><i class="fas fa-info-circle"></i> Data diambil secara real-time</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i> Statistik Tracking Laporan Permasalahan
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChartLaporan" style="max-height: 300px;"></canvas>
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

        // Fungsi untuk membuat chart
        function createPieChart(canvasId, data) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 20, font: { size: 14 } }
                        }
                    }
                }
            });
        }

        // Fetch data invoice
        fetch("{{ url('/chart-data-invoice') }}")
            .then(res => res.ok ? res.json() : Promise.reject("Gagal memuat data"))
            .then(data => createPieChart('pieChartInvoice', data))
            .catch(err => console.error("Error fetching chart data:", err));

        // Fetch data laporan
        fetch("{{ url('/chart-data-laporan') }}")
            .then(res => res.ok ? res.json() : Promise.reject("Gagal memuat data"))
            .then(data => createPieChart('pieChartLaporan', data))
            .catch(err => console.error("Error fetching chart data:", err));

        // Fetch notifications
        function fetchNotifications() {
            fetch("{{ url('/notifications/get') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('notification-count').textContent = data.label;
                    document.getElementById('notification-dropdown').innerHTML = data.dropdown;
                })
                .catch(err => console.error('Error fetching notifications:', err));
        }

        fetchNotifications();
        setInterval(fetchNotifications, 30000); // refresh tiap 30 detik
    });
</script>
@stop
