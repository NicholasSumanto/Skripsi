@extends('template.pemohon.main-pemohon')

@section('title', 'Lacak')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center text-[#1E285F] mb-10 leading-tight">
            Lacak Status<br>Publikasi Kegiatan
        </h1>
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg">

            {{-- Form Input Kode Kegiatan --}}
            <section class="bg-[#C4C4C4] rounded-lg pt-6 pb-4">
                <h2 class="text-xl font-semibold text-black text-center mb-4">Kode Kegiatan</h2>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6 mx-2">
                    <input id="kode" type="text" placeholder="Masukkan kode"
                        class="rounded-full w-full max-w-[280px] py-2 px-6 text-sm placeholder:text-[#999] focus:outline-none" />
                    <button type="submit"
                        class="bg-[#FFC107] text-black rounded-full px-6 py-2 text-sm font-semibold hover:bg-yellow-400 transition">
                        Cari
                    </button>
                </form>
            </section>
        </div>
    </main>
@endsection

@section('script')
@endsection


@section('script')
@endsection
