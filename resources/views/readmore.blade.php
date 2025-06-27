@extends('layouts.app')

@section('title', $article->title . ' | PT Wira Buana Arum')

@section('content')
<body class="bg-white text-black font-sans">
  <div class="container mx-auto px-4 py-8">
    <div class="mb-8">
      <a class="text-sm text-gray-600" href="{{ route('article.showReadmore', $article->id) }}">
        NEWS UPDATE
      </a>

      <h1 class="text-3xl font-bold mt-4">
        {{ $article->title }}
      </h1>

      <!-- Menampilkan Tanggal Artikel -->
      <p class="text-sm text-gray-500 mt-2">
        Published on: {{ $article->created_at->format('F j, Y') }}
      </p>
    </div>

    <div class="flex flex-col lg:flex-row">
      <div class="lg:w-2/3">
        <p class="mb-4">{{ $article->description }}</p>
      </div>
      <div class="lg:w-1/3 lg:pl-8">
        @if ($article->image)
          <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-auto">
        @else
          <p>No Image Available</p>
        @endif
      </div>
    </div>

    <div class="mt-16">
      <h2 class="text-2xl font-bold mb-4">
        Other Latest News
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($latestArticles as $latest)
          <div class="border p-4">
            @if ($latest->image)
              <img src="{{ asset($latest->image) }}" alt="{{ $latest->title }}" class="w-full h-auto mb-4">
            @endif
            <h3 cla    ss="text-lg font-bold mb-2">
              {{ $latest->title }}
            </h3>
            <p class="text-sm mb-4">
              {{ Str::limit($latest->description, 100) }}
            </p>
            <a href="{{ route('article.showReadmore', $latest->id) }}" class="px-4 py-2 border border-black text-black hover:bg-gray-200">
              Read More &gt;
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</body>
@endsection

