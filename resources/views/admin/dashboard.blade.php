@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
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
@endsection
