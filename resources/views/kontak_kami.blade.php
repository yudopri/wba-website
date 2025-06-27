@extends('layouts.app')

@section('title', 'Kontak | PT Wira Buana Arum')

@section('content')

<section class="bg-blue-800 text-white py-6">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold">
            Kontak Kami
        </h1>
    </div>
</section>

<section class="bg-white text-black py-10">
    <div class="container mx-auto text-center">
        <p>
            Jika anda memiliki pertanyaan tentang jasa yang kami sediakan, segera hubungi kami di
        </p>
        <p class="font-bold">
            PT WIRA BUANA ARUM
        </p>
    </div>
</section>

<section class="bg-white py-10">
    <div class="container mx-auto text-center gap-6">
        <div class="bg-blue-800 text-white p-6 rounded-lg inline-block shadow-md max-w-3xl w-full">
            <h2 class="text-xl font-bold">
                KANTOR PUSAT
            </h2>
            <p>
                Permata Sukodono Raya Blok A1 No. 8, Sukodono, Sidoarjo
            </p>
            <p>
                Telepon: (031) 58834012
            </p>
            <p>
                Fax: (031) 58834013
            </p>
            <p>
                E-mail: ptwba@yahoo.co.id
            </p>

            <!-- Google Map Embed -->
            <div class="mt-6">
                <iframe class="w-full h-64 rounded-lg border-none" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA8for2E82HCfTwLU3PSba4QVtzGh6SItY&q=PT+Wira+Buana+Arum,+Sukodono,+Sidoarjo"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>


<section class="bg-gray-100 py-10">
    <div class="container mx-auto">
        <h2 class="text-center text-2xl font-bold mb-6">
            KANTOR CABANG
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold">
                    BANYUWANGI
                </h3>
                <p>
                    Perum Permata Banyuwangi K1, Kalipuro, Banyuwangi
                </p>
                <p>
                    Telepon: (0333) 3381922
                </p>
                <p>
                    E-mail: ptwbabanyuwangi@yahoo.co.id
                </p>
                <!-- Google Map Embed -->
                <div class="mt-6">
                    <iframe class="w-full h-64 rounded-lg border-none" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA8for2E82HCfTwLU3PSba4QVtzGh6SItY&q=PT+Wira+Buana+Arum+Cab.+Banyuwangi,+Kalipuro,+Banyuwangi"
                        allowfullscreen></iframe>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold">
                    TULUNGAGUNG
                </h3>
                <p>
                    Perum Griya Permata Asri Blok C7, Kutoanyar, Tertek, Kec. Tulungagung, Kabupaten Tulungagung
                </p>
                <p>
                    Telepon: +6287887746222
                </p>
                <p>
                    E-mail: ptwbatulungagung@yahoo.co.id
                </p>
                <!-- Google Map Embed -->
                <div class="mt-6">
                    <iframe class="w-full h-64 rounded-lg border-none" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA8for2E82HCfTwLU3PSba4QVtzGh6SItY&q=PT+Wira+Buana+Arum+Perum+Griya+Permata+Asri+Blok+C7,+Tulungagung,+Tulungagung"
                        allowfullscreen></iframe>
                </div>
            </div>

            <!-- Bali section centered -->
            <div class="bg-white p-6 rounded-lg shadow-md col-span-1 md:col-span-2">
                <h3 class="text-xl font-bold text-center">
                    BALI
                </h3>
                <p class="text-center">
                    Jl. Sidakarya Gg. Taman Melati No. 1, Denpasar, Bali
                </p>
                <p class="text-center">
                    E-mail: ptwbabali@yahoo.co.id
                </p>
            </div>
        </div>
    </div>
</section>


@endsection
