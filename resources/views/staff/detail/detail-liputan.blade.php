@extends('template.staff.main-staff')
@section('title', 'Detail Permohonan Liputan')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
@endsection

@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Detail Permohonan Liputan</h1>
        <div class="max-w-4xl mx-auto bg-[#006034] text-[#FFCC29] rounded-xl shadow-xl p-10">
            <form id="form-liputan" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon * :</label>
                        <input type="text" name="nama_pemohon" value="{{ $publikasi->nama_pemohon }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone * :</label>
                        <input type="text" name="nomor_handphone" value="{{ $publikasi->nomor_handphone }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" value="{{ $publikasi->email }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-white" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul * :</label>
                        <input type="text" name="judul" value="{{ $publikasi->judul }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan * :</label>
                        <input type="text" name="tempat" value="{{ $publikasi->tempat }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara * :</label>
                        <input type="date" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($publikasi->tanggal)->format('Y-m-d') }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Waktu * :</label>
                        <input type="time" name="waktu"
                            value="{{ \Carbon\Carbon::parse($publikasi->waktu)->format('H:i') }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit * :</label>
                        <input type="text" name="unit" value="{{ $publikasi->nama_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit * :</label>
                        <input type="text" name="sub_unit" value="{{ $publikasi->nama_sub_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Rundown dan TOR * :</label>
                        <div class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black">

                            @php
                                $files = json_decode($publikasi->file_liputan, true);
                            @endphp

                            @if (is_array($files))
                                @foreach ($files as $file)
                                    <p>{{ $file }}</p>
                                @endforeach
                            @else
                                <p>Tidak ada file.</p>
                            @endif

                        </div>
                    </div>

                </div>

                <div>
                    <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media? *</label>
                    <div class="flex items-center space-x-6 mt-2 text-[#FFCC29]">
                        <div class="flex items-center">{{ $publikasi->wartawan == 'Ya' ? 'Ya' : 'Tidak' }}</div>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Output * :</label>
                    <div class="flex flex-col space-y-2 mt-2 text-[#FFCC29]">
                        @foreach (explode(',', $publikasi->output) as $output)
                            <div class="flex items-center">{{ ucfirst($output) }}</div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black" rows="6"
                        readonly>{{ $publikasi->catatan }}</textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('pemohon.home') }}"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection
