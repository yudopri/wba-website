@extends('layouts.app')

@section('title', 'Layanan | PT Wira Buana Arum')

@section('content')
<main class="bg-blue-800 text-white py-6">
   <div class="container mx-auto text-center">
      <h1 class="text-4xl font-bold mb-4">
         Layanan Kami
      </h1>
      <p class="text-lg">
         Kami menyediakan tenaga kerja outsourcing terbaik untuk memenuhi kebutuhan perusahaan Anda.
      </p>
   </div>
</main>

<section class="bg-gray-100 py-16">
   <div class="container mx-auto px-6 text-center">
      <p class="text-xl mb-8 font-medium">
         Berikut daftar Tenaga Kerja Outsourcing yang kami sediakan:
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
         @foreach ($services as $service)
         <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
            <!-- Ikon/Logo Layanan -->
            <div class="flex justify-center items-center w-full h-48 bg-blue-100">
               @if ($service->icon)
               <img src="{{ asset($service->icon) }}" alt="{{ $service->name_service }}" class="w-16 h-16 object-contain">
               @else
               <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 100 15.292 4 4 0 000-15.292z" />
               </svg>
               @endif
            </div>
            <div class="p-6">
               <h3 class="text-xl font-semibold text-blue-900 mb-2">{{ $service->name_service }}</h3>
               <p class="text-sm text-gray-600">
                  {{ $service->description ?? 'Deskripsi belum tersedia.' }}
               </p>
            </div>
         </div>
         @endforeach
      </div>
      <p class="mt-8 text-lg">
         Hubungi kami untuk informasi lebih lanjut mengenai jenis Tenaga Kerja yang Anda perlukan.
      </p>
      <a href="/kontak" class="mt-4 inline-block bg-blue-800 text-white py-2 px-6 rounded-lg shadow hover:bg-blue-600 transition duration-300">
         Hubungi Kami
      </a>
   </div>
</section>
@endsection
