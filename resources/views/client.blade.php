@extends('layouts.app')

@section('title', 'Client | PT Wira Buana Arum')

@section('content')

<section class="bg-blue-800 text-white py-6 relative">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold">
        Client
        </h1>
    </div>
</section>

<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-8">
            @foreach($partners as $partner)
            <div class="bg-white p-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
    <img src="{{ asset($partner->icon) }}" alt="{{ $partner->name_partner }}" class="w-32 h-32 mx-auto object-contain mb-4">
    <h3 class="text-lg font-semibold text-primary">{{ $partner->name_partner }}</h3>
</div>
            @endforeach
        </div>
    </div>
</section>

@endsection
