@extends('layouts.app')

@section('title', 'Tentang | PT Wira Buana Arum')

@section('content')
<section class="bg-gray-100 text-black py-6">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold mb-8">
            Tentang Kami
        </h1>
        <div class="flex justify-center items-center">
            <div class="w-1/2 text-left">
                <p>
                    PT. Wira Buana Arum didirikan pada tahun 2007 di Sidoarjo. Perusahaan ini bergerak sebagai penyedia jasa tenaga kerja, melayani berbagai instansi dan sektor usaha di berbagai kota di Indonesia seperti Surabaya, Sidoarjo, Gresik, Banyuwangi, dan Denpasar. Dengan pengalaman lebih dari 100 mitra kerja, perusahaan ini menyediakan tenaga kerja yang dikelola secara profesional melalui pengawasan langsung di lapangan oleh koordinator atau supervisor.
                </p>
            </div>
            <div class="w-1/2 flex justify-center">
                <img alt="Person using a tablet" class="rounded-lg" height="300" src="{{ asset('assets/image/logowba.png')}}" width="300"/>
            </div>
        </div>
        <div class="flex justify-center mt-8">
            <div class="bg-blue-800 text-white p-6 rounded-lg shadow-lg mx-4">
                <h2 class="text-2xl font-bold mb-4">
                    VISI:
                </h2>
                <p>
                    Menyediakan sumber daya manusia yang profesional dan bermoral melalui sistem pengembangan terpadu sebagai mitra kerja terpercaya serta memberikan pelayanan maksimal dengan menjalin hubungan baik.
                </p>
            </div>
            <div class="bg-blue-800 text-white p-6 rounded-lg shadow-lg mx-4">
                <h2 class="text-2xl font-bold mb-4">MISI:</h2>
                <p>
                    Mendukung program pemerintah dalam meningkatkan perekonomian bangsa. Menciptakan lapangan kerja serta membangun budaya kerja berkualitas dan profesional. Menjalin kerja sama yang baik dengan mitra di berbagai kota. Menjaga kepercayaan dan kualitas pelayanan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section 2 -->
<section class="bg-white text-black py-20">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">
            Berikut Daftar Pelayanan Kami
        </h2>
        <div class="flex justify-center items-center">
            <div class="w-1/2">
                <!-- Replace this placeholder with an actual image -->
                <img alt="Teamwork and employee collaboration" class="rounded-lg" height="400" src="{{ asset('assets/image/layanan.jpg')}}" width="400"/>
            </div>
            <div class="w-1/2 text-left">
                <div class="bg-blue-100 p-6 rounded-lg shadow-lg mb-4">
                    <h3 class="text-xl font-bold mb-2">
                        <i class="fas fa-users-cog text-blue-800 mr-2"></i> Penyediaan tenaga kerja yang meliputi berbagai sektor seperti produksi, teknisi, customer service, dan cleaning service.
                    </h3>
                    <p>
                        Kami menyediakan berbagai macam tenaga kerja outsourcing yang berpengalaman dan siap membantu perusahaan anda.
                    </p>
                </div>
                <div class="bg-blue-100 p-6 rounded-lg shadow-lg mb-4">
                    <h3 class="text-xl font-bold mb-2">
                        <i class="fas fa-chalkboard-teacher text-blue-800 mr-2"></i> Pelatihan dan pembinaan berkala untuk meningkatkan kualitas karyawan.
                    </h3>
                    <p>
                        Menyediakan pelatihan dan pembinaan berkala untuk meningkatkan kualitas pekerja/buruh bertujuan menghasilkan pekerja/buruh berpengalaman dan terlatih untuk membantu perusahaan dalam memenuhi kebutuhan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
