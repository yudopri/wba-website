<header class="bg-gradient-to-r from-primary to-black text-secondary shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo and Brand Name -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('assets/image/logowba.png') }}" alt="Logo PT Wira Buana Arum" class="w-12 h-12">
            <div class="text-2xl font-bold">
                <a href="/" class="hover:text-blue-500 relative inline-block group">PT Wira Buana Arum
                <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>
        </div>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex space-x-6">
            @foreach(['TENTANG KAMI', 'LAYANAN', 'ARTICLE', 'PROGRAM KERJA', 'FASILITAS', 'CLIENT', 'GALLERY', 'KONTAK KAMI','LOGIN'] as $link)
                <a href="{{ route(strtolower(str_replace(' ', '-', $link))) }}" class="hover:text-blue-500 relative inline-block group">
                    {{ $link }}
                    <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            @endforeach
        </nav>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-secondary" id="menu-btn" aria-label="Toggle Navigation Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Navigation Menu (Initially Hidden) -->
    <div class="hidden" id="menu">
        <nav class="flex flex-col space-y-4 py-4 px-6">
            @foreach(['TENTANG KAMI', 'LAYANAN', 'ARTICLE', 'PROGRAM KERJA', 'FASILITAS', 'CLIENT', 'GALLERY', 'KONTAK KAMI','LOGIN'] as $link)
                <a href="{{ route(strtolower(str_replace(' ', '-', $link))) }}" class="hover:text-blue-500 relative inline-block group">
                    {{ $link }}
                    <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            @endforeach
        </nav>
    </div>
</header>

<script>
    // Mobile menu toggle functionality
    document.getElementById('menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden'); // Toggle the visibility of the menu
    });
</script>
