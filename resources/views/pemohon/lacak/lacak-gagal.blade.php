@extends('template.pemohon.main-pemohon')

@section('title', 'Lacak')

@section('content')
    <main class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center text-[#1E285F] mb-10 leading-tight">
            Lacak Status Publikasi
        </h1>
        <div class="max-w-5xl mx-auto bg-white rounded-lg">

            {{-- Form Input Kode Publikasi--}}
            <section class="bg-[#C4C4C4] rounded-lg pt-6 pb-4 shadow-lg">
                <h2 class="text-xl font-semibold text-black text-center mb-4 px-4">Kode Publikasi</h2>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6 mx-2" method="GET"
                    action="{{ route('pemohon.lacak') }}">
                    <input id="kode_proses" name="kode_proses" type="text" placeholder="Masukkan kode"
                        class="rounded-full w-full max-w-[280px] py-2 px-6 text-sm placeholder:text-[#999] focus:outline-none"
                        value="{{ isset($id_proses_permohonan) ? $id_proses_permohonan : (isset($publikasi->id_proses_permohonan) ? $publikasi->id_proses_permohonan : '') }}" />
                    <button type="submit"
                        class="bg-[#FFC107] text-black rounded-full px-6 py-2 text-sm font-semibold hover:bg-yellow-400 transition">
                        Cari
                    </button>
                </form>
            </section>

            {{-- Status Proses --}}
            <section class="bg-white rounded-b-lg px-6 pt-6 pb-0 relative overflow-hidden">
                <div class="flex items-center justify-center py-6 bg-white text-center px-4">
                    <div class="max-w-md border-4 border-solid border-red-500 p-4 rounded-lg shadow-lg">
                        <h1 class="text-xl font-semibold text-black mb-6">
                            Kode Publikasi Tidak Dapat Ditemukan
                        </h1>

                        <div class="flex justify-center mb-6">
                            <div
                                class="w-20 h-20 rounded-full border-[6px] border-red-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>

                        <p class="text-black text-base mb-2">
                            Mohon maaf, kode publikasi yang Anda masukan tidak dapat ditemukan atau tidak valid.
                        </p>
                        <p class="text-black text-base">
                            Silakan coba cek kembali kode publikasi atau hubungi staff Biro 4 jika masalah terus berlanjut.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
