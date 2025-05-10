@extends('template.pemohon.main-pemohon')
@section('title', 'Form Liputan')

@section('content')
<main class="flex-grow bg-gray-50 py-16 px-6">
    <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Liputan</br></h1>
    <div class="max-w-4xl mx-auto bg-[#006034] text-[#FFCC29] rounded-xl shadow-xl p-10">
        <form id="form-liputan" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-lg">Nama Pemohon :</label>
                    <input type="text" name="nama_pemohon" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Nomor Handphone :</label>
                    <input type="text" name="nomor_hp" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Email :</label>
                    <input type="email" name="email" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Judul :</label>
                    <input type="text" name="judul" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Tempat Pelaksanaan :</label>
                    <input type="text" name="tempat" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Tanggal Acara :</label>
                    <input type="date" name="tanggal" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Waktu :</label>
                    <input type="time" name="waktu" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Unit :</label>
                    <input type="text" name="unit" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                </div>

                <div>
                    <label class="font-semibold text-lg">Rundown dan TOR :</label>
                    <input type="file" name="tor" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none bg-white text-black">
                </div>
            </div>

            <div>
                <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media?</label>
                <div class="flex items-center space-x-6 mt-2 text-[#FFCC29]">
                    <label class="flex items-center"><input type="radio" name="media" value="ya" class="mr-2"> Ya</label>
                    <label class="flex items-center"><input type="radio" name="media" value="tidak" class="mr-2"> Tidak</label>
                </div>
            </div>

            <div>
                <label class="font-semibold text-lg">Output :</label>
                <div class="flex flex-col space-y-2 mt-2 text-[#FFCC29]">
                    <label class="flex items-center"><input type="checkbox" name="output[]" value="artikel" class="mr-2"> Artikel</label>
                    <label class="flex items-center"><input type="checkbox" name="output[]" value="foto" class="mr-2"> Foto</label>
                    <label class="flex items-center"><input type="checkbox" name="output[]" value="video" class="mr-2"> Video</label>
                </div>
            </div>

            <div>
                <label class="font-semibold text-lg">Catatan :</label>
                <textarea name="catatan" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black" rows="6"></textarea>
            </div>

            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-[#FFCC29] hover:bg-yellow-500 text-black font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
                <button type="button"
                    onclick="document.getElementById('form-liputan').reset(); window.location.href='{{ route('pemohon.home') }}';"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                    Batal
                </button>

            </div>
        </form>
    </div>
</main>
@endsection
