@extends('layouts.app')

@section('title', 'Article | PT Wira Buana Arum')

@section('content')
<main class="container mx-auto px-4 py-6">
   <div class="text-center mb-8 bg-blue-800 text-white p-6 rounded-lg">
    <h1 class="text-4xl font-bold mb-4">
        Wira Buana Arum Article
    </h1>
    <p class="mb-4">
        Ini adalah laman artikel PT Wira Buana Arum Group
        <br />
        Jika memiliki pertanyaan silahkan hubungi:
        <a href="mailto:ptwba@yahoo.co.id?subject=Pertanyaan&body=Halo, saya ingin bertanya..." 
           class="underline hover:text-black">
            contact ptwba@yahoo.co.id
        </a>
    </p>
    <a href="/kontak" class="bg-white text-blue-800 px-4 py-2 rounded hover:bg-blue-600 hover:text-white">
        Contact Us
    </a>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <div class="border rounded-lg shadow-lg overflow-hidden">
            <img
    src="{{ $article->image ? asset($article->image) : asset('images/default-image.jpg') }}"
    alt="{{ $article->title }}"
    class="w-full h-48 object-cover"
    width="600"
    height="400"
/>

                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">
                        {{ $article->title }}
                    </h2>
                    <p class="text-gray-600 mb-4">
                        {{ \Illuminate\Support\Str::limit($article->description, 100) }}
                    </p>
                    <a href="{{ route('article.showReadmore', $article->id) }}" class="text-blue-600 hover:text-black">
                        READ MORE
                    </a>
                </div>
                <div class="bg-gray-100 p-4 text-gray-600 text-sm">
                    {{ \Carbon\Carbon::parse($article->date)->format('F j, Y') }}
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center">
                <p class="text-gray-600">No articles found at the moment.</p>
            </div>
        @endforelse
    </div>
    <div class="text-center mt-8">
        {{ $articles->links() }}
    </div>
</main>
@endsection
