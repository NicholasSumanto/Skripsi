@extends('template.pemohon.main-pemohon')
@section('title', 'Form Promosi')

@section('content')
<main class="flex-grow bg-gray-50 py-16 px-6">
    <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Promosi Acara</h1>

    <div class="max-w-4xl mx-auto bg-gray-100 text-[#006034] rounded-xl shadow-xl p-10">
        <form id="form-promosi" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-lg">Nama Pemohon :</label>
                    <input type="text" name="nama_pemohon" placeholder="Nama Pemohon" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Nomor Handphone :</label>
                    <input type="text" name="nomor_hp" placeholder="+62" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Email :</label>
                    <input type="email" name="email" placeholder="email@gmail.com" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Judul Event :</label>
                    <input type="text" name="judul_event" placeholder="Judul Event" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Tempat Pelaksanaan :</label>
                    <input type="text" name="tempat" placeholder="Tempat Pelaksanaan" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Tanggal Acara :</label>
                    <input type="date" name="tanggal_acara" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>

                <div>
                    <label class="font-semibold text-lg">Unit :</label>
                    <input type="text" name="unit" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                </div>
            </div>

            <div class="mt-6">
                <label class="font-semibold text-lg block mb-2">Materi Promosi :</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Instagram Stories</label>
                        <input type="file" name="materi_instagram_stories" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>
                    <div>
                        <label class="block mb-1">Instagram Post</label>
                        <input type="file" name="materi_instagram_post" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>
                    <div>
                        <label class="block mb-1">Videotron</label>
                        <input type="file" name="materi_videotron" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <label class="font-semibold text-lg">Catatan :</label>
                <textarea name="catatan" rows="6" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white"></textarea>
            </div>

            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-[#006034] hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
                <button type="button"
                    onclick="document.getElementById('form-promosi').reset(); window.location.href='{{ route('pemohon.home') }}';"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
