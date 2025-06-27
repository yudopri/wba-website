@extends('layouts.app')

@section('title', 'Program Kerja | PT Wira Buana Arum')

@section('content')

<section class="bg-blue-800 text-white py-6">
            <div class="container mx-auto text-center">
                <h1 class="text-4xl font-bold">Program Kerja</h1>
            </div>
        </section>
        <section class="bg-white py-20">
            <div class="container mx-auto flex flex-col items-center">
                <div class="w-2/3 flex flex-col items-center">
                    <img src="{{ asset('assets/image/proker.jpg')}}" alt="Training Session" class="rounded-lg shadow-lg mb-8">
                    <p class="text-center text-lg">
                    PT. Wira Buana Arum menerapkan Standard Operating Procedure (SOP) kepada setiap tenaga kerja untuk memastikan kualitas dan efisiensi kerja yang tinggi. Selain itu, kami juga berperan aktif dalam memberikan layanan kepada klien internasional melalui kerja sama dengan berbagai pihak.
Kami menjalin kemitraan strategis dengan instansi pemerintah, seperti Dinas Tenaga Kerja, serta lembaga pelatihan profesional (Pusdiklat THP). PT. Wira Buana Arum juga terlibat aktif dalam Asosiasi Penyalur Tenaga Kerja untuk mengembangkan sumber daya manusia yang profesional, handal, dan terpercaya.
</p>
                </div>
            </div>
        </section>
        <section class="bg-gray-100 text-black py-20">
            <div class="container mx-auto flex flex-col items-center">
                <h2 class="text-3xl font-bold mb-8">Program Pembinaan Tenaga Kerja</h2>
                <div class="w-2/3 flex flex-col items-center">
                    <p class="text-center text-lg mb-8">
                    <b>Program Pembinaan Rutin</b>
Program ini merupakan pembinaan tenaga kerja yang dilaksanakan secara rutin. Pelatihan bersifat teknis dan dirancang untuk meningkatkan kompetensi tenaga kerja, termasuk mendapatkan sertifikat keahlian. Fokus utamanya adalah penguasaan Standard Operating Procedure (SOP), peningkatan kedisiplinan, serta pembentukan sikap dan mental (attitude) yang profesional.

<b>Program Pembinaan Khusus</b>
Program ini mencakup pembinaan kerja sama dan magang yang dilakukan secara periodik. Materi pelatihan disesuaikan dengan kebutuhan spesifik masing-masing tenaga kerja untuk mendukung pengembangan keterampilan secara optimal.
</p>
                    <ul class="list-disc list-inside text-left space-y-2">
                        <li><i class="fas fa-check-circle text-blue-500"></i> Pemahaman SOP dan standar operasional kerja.</li>
                        <li><i class="fas fa-check-circle text-blue-500"></i> Peningkatan kedisiplinan dan etos kerja. </li>
                        <li><i class="fas fa-check-circle text-blue-500"></i> Pengembangan keterampilan teknis sesuai bidang pekerjaan. </li>
                        <li><i class="fas fa-check-circle text-blue-500"></i> Pembentukan sikap profesional dan etika kerja.  </li>
                        <li><i class="fas fa-check-circle text-blue-500"></i> Manajemen waktu dan produktivitas.</li>
                        <li><i class="fas fa-check-circle text-blue-500"></i> Dan berbagai macam pelatihan lainnya</li>
                    </ul>
                    <!-- <img src="{{ asset('assets/image/pembinaan.jpg')}}" alt="Training Session" class="rounded-lg shadow-lg mt-8"> -->
                </div>
            </div>
        </section>


        @endsection
