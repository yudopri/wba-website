@extends('layouts.app')

@section('title', 'Gallery | PT Wira Buana Arum')

@section('content')

<section class="bg-blue-800 text-white py-6">
   <div class="container mx-auto text-center">
      <h1 class="text-3xl font-bold">Gallery</h1>
   </div>
</section>

<section class="container mx-auto py-10">
   <div class="grid grid-cols-3 gap-4">
      <!-- Menampilkan gambar secara dinamis dari database -->
      @foreach($galleries as $gallery)
         <div class="gallery-item">
            <img alt="{{ $gallery->title }}" class="w-full h-auto" height="150" src="{{ asset($gallery->image_url) }}" width="200" />
            <p class="text-center mt-2 text-sm">{{ $gallery->title }}</p>
         </div>
      @endforeach
   </div>
</section>

@endsection
