@extends('layouts.app')

@section('title', 'Home | PT Wira Buana Arum')

@section('content')

<!-- Hero Section -->
<section class="relative mt-6" x-data="{ currentSlide: 1, totalSlides: {{ count($slides) }} }" x-init="setInterval(() => { currentSlide = (currentSlide % totalSlides) + 1 }, 5000)">
    <!-- Container Gambar -->
    <div class="relative overflow-hidden h-96">
        @foreach ($slides as $index => $slide)
            <div
                class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="{
                    'opacity-0 z-0': currentSlide !== {{ $index + 1 }},
                    'opacity-100 z-10': currentSlide === {{ $index + 1 }}
                }"
            >
                <img
                    src="{{ asset('assets/image/' . $slide) }}"
                    alt="Slide {{ $index + 1 }}"
                    class="w-full h-full object-cover"
                >
            </div>
        @endforeach
    </div>

    <!-- Overlay Teks Tetap -->
    <div class="absolute inset-0 z-20 bg-black bg-opacity-50 flex items-center justify-center px-6 md:px-12">
        <div class="text-center text-secondary max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-white">PT. Wira Buana Arum</h1>
            <p class="mt-3 text-lg text-white">
               Berfikir, Berkata, Dan Bertindak Benar Adalah Hidup Kami.
            </p>
        </div>
    </div>

    <!-- Navigasi Manual -->
    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 px-4 z-30">
        <button @click="currentSlide = (currentSlide === 1) ? totalSlides : currentSlide - 1" class="bg-gray-800 text-white rounded-full p-2 hover:bg-gray-600 hover:scale-105 transition-transform duration-300">
            ←
        </button>
    </div>
    <div class="absolute top-1/2 right-0 transform -translate-y-1/2 px-4 z-30">
        <button @click="currentSlide = (currentSlide === totalSlides) ? 1 : currentSlide + 1" class="bg-gray-800 text-white rounded-full p-2 hover:bg-gray-600 hover:scale-105 transition-transform duration-300">
            →
        </button>
    </div>
</section>


<!-- Services Section -->
<section class="bg-secondary py-16">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-primary">
        <div class="bg-primary p-8 rounded-lg shadow-lg text-secondary">
            <h2 class="text-xl font-bold mb-4">Fasilitas</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>Menyediakan tenaga pengganti (free of charge)</li>
                <li>Program pelatihan Teknis dan Non-TEknis</li>
                <li>Koperasi simpan pinjam</li>
                <li>Sarana Keamanan dan Kesehatan Kerja (K3)</li>
                <li>Absensi menggunakan aplikasi online</li>
            </ul>
            <a href="/fasilitas" class="mt-4 inline-block bg-blue-800 text-white py-2 px-4 rounded text-center hover:bg-blue-600">READ MORE</a>
        </div>
        <div class="bg-primary p-8 rounded-lg shadow-lg text-secondary">
            <h2 class="text-xl font-bold mb-4">Layanan</h2>
            <p>PT Wira Buana Arum menyediakan beragam tenaga kerja outsourcing berpengalaman yang siap terjun ke dalam perusahaan anda.</p>
            <a href="/layanan" class="mt-4 inline-block bg-blue-800 text-white py-2 px-4 rounded text-center hover:bg-blue-600">READ MORE</a>
        </div>
        <div class="bg-primary p-8 rounded-lg shadow-lg text-secondary">
            <h2 class="text-xl font-bold mb-4">Program Kerja</h2>
            <p>Mencakup perencanaan, organisasi dan kontrol setiap tenaga kerja dengan bantuan koordinator lapangan serta berbagai macam program pembinaan yang disesuaikan dengan kebutuhan.</p>
            <a href="/programkerja" class="mt-4 inline-block bg-blue-800 text-white py-2 px-4 rounded text-center hover:bg-blue-600">READ MORE</a>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <h2 class="text-2xl font-bold text-primary mb-8">Client</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-8">
            @foreach($partners as $partner)
            <div class="bg-white p-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
    <img src="{{ asset($partner->icon) }}" alt="{{ $partner->name_partner }}" class="w-32 h-32 mx-auto object-contain mb-4">
    <h3 class="text-lg font-semibold text-primary">{{ $partner->name_partner }}</h3>
</div>
            @endforeach
        </div>
        <a href="/client" class="bg-blue-800 text-white py-2 px-4 rounded mt-4 inline-block text-center hover:bg-blue-600">LIHAT KLIEN LAINNYA</a>
    </div>
</section>


@endsection
