@extends('template.staff.main-staff')
@section('title', 'Detail Permohonan Publikasi')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
@endsection

@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Detail Permohonan Publikasi<br>Promosi Acara</h1>

        <div class="max-w-4xl mx-auto bg-gray-100 text-[#006034] rounded-xl shadow-xl p-10">
            <form id="form-promosi-view" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon :</label>
                        <input type="text" name="nama_pemohon" value="{{ $publikasi->nama_pemohon }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone :</label>
                        <input type="text" name="nomor_handphone" value="{{ $publikasi->nomor_handphone }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" value="{{ $publikasi->email }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul Event :</label>
                        <input type="text" name="judul" value="{{ $publikasi->judul }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan :</label>
                        <input type="text" name="tempat" value="{{ $publikasi->tempat }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara :</label>
                        <input type="date" name="tanggal" value="{{ $publikasi->tanggal }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white"
                            style="height: 50px;">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit :</label>
                        <input type="text" name="unit" value="{{ $publikasi->nama_unit }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit :</label>
                        <input type="text" name="sub_unit" value="{{ $publikasi->nama_sub_unit }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg block mb-2">Materi Promosi :</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Instagram Stories</label>
                            <p>{{ $publikasi->file_stories ? 'Tersedia' : 'Tidak ada file' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1">Instagram Post</label>
                            <p>{{ $publikasi->file_poster ? 'Tersedia' : 'Tidak ada file' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1">Videotron</label>
                            <p>{{ $publikasi->file_video ? 'Tersedia' : 'Tidak ada file' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" rows="6" readonly
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">{{ $publikasi->catatan }}</textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button"
                        onclick="window.location.href='{{ route('pemohon.home') }}';"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
