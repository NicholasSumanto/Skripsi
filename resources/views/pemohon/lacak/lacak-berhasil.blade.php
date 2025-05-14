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
            <section class="bg-[#C4C4C4] rounded-t-lg pt-6">
                <h2 class="text-xl font-semibold text-black text-center mb-4">Kode Kegiatan</h2>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6 mx-2">
                    <input id="kode" type="text" placeholder="Masukkan kode"
                        class="rounded-full w-full max-w-[280px] py-2 px-6 text-sm placeholder:text-[#999] focus:outline-none" />
                    <button type="submit"
                        class="bg-[#FFC107] text-black rounded-full px-6 py-2 text-sm font-semibold hover:bg-yellow-400 transition">
                        Cari
                    </button>
                </form>

                {{-- Tabel Informasi Kegiatan --}}
                <div class="overflow-x-auto">
                    <table class="w-full bg-[#0B4D1E] text-sm text-center">
                        <thead>
                            <tr class="font-semibold text-[#FFC107]">
                                <th class="py-4 px-3">Kode Kegiatan</th>
                                <th class="py-4 px-3">Nama Pemohon</th>
                                <th class="py-4 px-3">Nama Kegiatan</th>
                                <th class="py-4 px-3">Tanggal/Waktu</th>
                                <th class="py-4 px-3">Unit</th>
                                <th class="py-4 px-3">Jenis Publikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-[#0B4D1E] text-[#D9D9D9]">
                                <td class="pb-4 px-3">xxx-xxx-xxx</td>
                                <td class="pb-4 px-3">James Conan</td>
                                <td class="pb-4 px-3">Seminar dari Perusahaan</td>
                                <td class="pb-4 px-3">
                                    21/04/2023<br>15:00:00
                                </td>
                                <td class="pb-4 px-3">Fakultas Teknologi Informasi</td>
                                <td class="pb-4 px-3">Event</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Status Proses --}}
            <section class="bg-primary rounded-b-lg px-6 py-8 relative overflow-hidden">
                <h2 class="text-lg font-semibold mb-6 text-white text-center md:text-left">Status Permohonan Publikasi
                </h2>

                @php
                    $statuses = [
                        ['label' => 'Diajukan', 'date' => '20/04/2023 16:42:23', 'active' => true],
                        ['label' => 'Diterima', 'date' => '20/04/2023 17:42:23', 'active' => true],
                        ['label' => 'Diproses', 'date' => null, 'active' => false],
                        ['label' => 'Selesai', 'date' => null, 'active' => false],
                    ];
                @endphp

                <div class="relative w-full max-w-4xl mx-auto px-4">
                    <!-- Garis -->
                    <div class="hidden sm:block absolute top-7 left-[100px] right-[100px] h-2 bg-white z-0"></div>
                    <div class="sm:hidden block absolute left-[47px] top-[0px] bottom-[30px] w-1 bg-white z-0"></div>

                    <div class="flex flex-col sm:flex-row sm:justify-between gap-6 sm:gap-0 relative z-10">
                        @foreach ($statuses as $status)
                            <div
                                class="flex sm:flex-col flex-row sm:items-center items-start sm:w-1/4 w-full gap-4 sm:gap-0">
                                <div
                                    class="w-16 h-16 mb-5 rounded-full flex items-center justify-center
                {{ $status['active'] ? 'bg-[#00FF6A] text-white border-4 border-white' : 'bg-yellow-400 text-white border-4 border-white' }}">
                                    <i class="{{ $status['active'] ? 'fas fa-check' : 'far fa-clock' }}"></i>
                                </div>

                                <div class="flex flex-col sm:items-center items-start text-white">
                                    <span
                                        class="text-lg font-semibold {{ $status['active'] ? 'text-white' : 'text-white/70' }}">
                                        {{ $status['label'] }}
                                    </span>
                                    @if ($status['date'])
                                        <span class="text-sm text-white/70 mt-1 leading-tight text-left sm:text-center">
                                            {!! str_replace(' ', '<br>', $status['date']) !!}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                {{-- Tombol Batalkan --}}
                <div class="mt-8 text-right">
                    <button type="button"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-full px-6 py-2 shadow">
                        Batalkan Publikasi
                    </button>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('script')
@endsection


@section('script')
@endsection
