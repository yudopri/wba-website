@extends('layouts.app')

@section('title', 'Fasilitas | PT Wira Buana Arum')

@section('content')

<main>
    <!-- Fasilitas Section -->
    <section class="bg-blue-800 text-white py-6">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-8">Fasilitas</h1>

            <p class="max-w-2xl mx-auto mb-8">
                PT Wira Buana Arum menyediakan berbagai fasilitas untuk memberikan kenyamanan dan menjadi mitra terpercaya bagi Client maupun Tenaga Kerja.
            </p>

            <!-- Image of security personnel -->
            <!-- <div class="flex justify-center mb-8">
                <img alt="Security personnel of PT. CIP" class="rounded-lg" height="200" src="{{ asset('assets/image/fasilitas.png')}}" width="300"/>
            </div> -->

            <!-- Grid of features -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Pelatihan Teknis dan Non-Teknis
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Pendampingan di Tempat Kerja (On-Site Support)
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Fasilitas Magang dan Kerja Sama dengan Mitra
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Program Pengembangan Kedisiplinan
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Absensi menggunakan aplikasi online
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Sarana Keamanan dan Kesehatan Kerja (K3)
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Transportasi Tenaga Kerja
                </div>
                <div class="bg-white text-blue-900 p-4 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-red-500 mr-2"></i>
                    Manajemen Administrasi dan Pelaporan
                </div>
            </div>
        </div>
    </section>

    <!-- Penggantian Tenaga Kerja Section -->
    <section class="bg-white text-black py-16">
        <div class="container mx-auto text-center">
            <!-- Image of professional team -->
            <div class="flex justify-center mb-8">
                <img alt="Professional team of PT. CIP" class="rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/q6f6xnsvFa3MJib8V5AXrT9o2wmqwGFov6zq3pkRSrvOgy3JA.jpg" width="300"/>
            </div>

            <h2 class="text-3xl font-bold mb-4">Penggantian Tenaga Kerja</h2>
            <p class="max-w-2xl mx-auto">
                PT Wira Buana Arum memberikan layanan penggantian personil bagi Tenaga Kerja yang tidak memenuhi target performance yang telah disepakati dengan Client, secara free of charge. Kami menjadikan tenaga pengganti karyawan/mitra Tenaga Kerja yang diamanahkan di perusahaan Client sebagai hal yang utama, baik dari sisi skill dan etos kerja.
            </p>
        </div>
    </section>
</main>

@endsection
