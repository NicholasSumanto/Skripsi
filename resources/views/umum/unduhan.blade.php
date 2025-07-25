@extends('template.umum.main-umum')

@section('title', 'Unduhan')

@section('content')
<main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
    <div class="p-4 sm:p-2">

        <h2 class="text-3xl font-bold text-[#1a237e] mb-6 text-left">Form Permohonan Publikasi</h2>

        <p class="text-gray-700 mb-8 text-left">
            Silakan unduh form permohonan publikasi berikut, kemudian isi dan kirimkan sesuai prosedur yang berlaku.
        </p>

        <a href="{{ asset('file/test.pdf') }}"
           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-6 rounded-lg transition-colors"
           download>
           Unduh Formulir
        </a>

    </div>
</main>
@endsection
