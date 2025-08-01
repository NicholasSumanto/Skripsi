@extends('template.pemohon.main-pemohon')

@section('title', 'Home')

@section('content')
    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Siang';
        } else {
            $greeting = 'Selamat Malam';
        }
    @endphp

    <main class="flex-grow bg-white pt-10 pb-20 px-4">
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-[#1a237e] leading-tight">
                {{ $greeting }}, <span class="text-green-700">{{ ucfirst(strtok(Auth::user()->name, ' ')) }}</span>!
                <br />
                <span class="text-[#1a237e] font-medium text-2xl md:text-3xl block mt-2">Pilih jenis publikasi yang Anda
                    butuhkan</span>
            </h1>
        </div>


        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Publikasi Liputan -->
            <div
                class="bg-green-900 text-white rounded-2xl shadow-lg p-10 min-h-[420px] flex flex-col justify-between text-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-yellow-400">Publikasi Liputan</h2>
                    <p class="text-lg leading-relaxed">
                        <b>Ingin kegiatan Anda diliput dan didokumentasikan oleh kami?</b><br><br>
                        Pilihan ini ditujukan bagi Anda yang ingin kegiatan internal atau eksternal
                        didokumentasikan dalam bentuk artikel, foto, maupun video untuk dipublikasikan
                        melalui kanal resmi kami.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('pemohon.publikasi.liputan') }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-3 px-6 rounded-full text-lg">
                        Ajukan Publikasi
                    </a>
                </div>
            </div>

            <!-- Publikasi Promosi Acara -->
            <div
                class="bg-gray-300 text-black rounded-2xl shadow-lg p-10 min-h-[420px] flex flex-col justify-between text-center">
                <div>
                    <h2 class="text-3xl font-bold text-green-800 mb-6">Publikasi Promosi Acara</h2>
                    <p class="text-lg leading-relaxed">
                        <b>Ada acara seru yang ingin dipromosikan?</b><br><br>
                        Cocok bagi Anda yang ingin informasi mengenai event, kegiatan, atau pengumuman
                        penting disebarluaskan melalui media publikasi Humas agar menjangkau audiens yang lebih luas.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('pemohon.publikasi.promosi') }}"
                        class="bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-6 rounded-full text-lg">
                        Ajukan Publikasi
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
