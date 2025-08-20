@extends('template.staff.main-staff')
@section('title', 'Home Staff')

@section('content')
    <div class="p-6 bg-white rounded shadow relative">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Permintaan Publikasi</h1>

        <!-- Sorting Filter -->
        <form method="GET" action="{{ route('staff.home') }}" class="mb-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col md:flex-row md:flex-wrap md:items-center gap-2 flex-1 min-w-[300px]">

                <label for="sort" class="text-lg font-semibold text-green-700">Sortir :</label>
                <select name="sort" id="sort" onchange="this.form.submit()"
                    class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                    <option value="">-- Semua Urutan --</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terdekat (Jadwal)
                    </option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terjauh (Jadwal)
                    </option>
                    <option value="baru_diajukan" {{ request('sort') == 'baru_diajukan' ? 'selected' : '' }}>Terbaru
                        Diajukan
                    </option>
                    <option value="lama_diajukan" {{ request('sort') == 'lama_diajukan' ? 'selected' : '' }}>Terlama
                        Diajukan
                    </option>
                </select>

                <select name="pub" id="pub" onchange="this.form.submit()"
                    class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                    <option value="">-- Semua Jenis --</option>
                    <option value="liputan" {{ request('pub') == 'liputan' ? 'selected' : '' }}>Liputan</option>
                    <option value="promosi" {{ request('pub') == 'promosi' ? 'selected' : '' }}>Promosi</option>
                </select>

                <select name="proses" id="proses" onchange="this.form.submit()"
                    class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                    <option value="">-- Semua Status --</option>
                    <option value="diajukan" {{ request('proses') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="diterima" {{ request('proses') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="diproses" {{ request('proses') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                </select>

                <!-- Search bar -->
                <input type="text" name="search" x-model="search" value="{{ request('search') }}"
                    placeholder="Cari publikasi..."
                    class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900 w-full md:w-auto">

                <button type="submit"
                    class="px-4 py-2 rounded-md bg-green-700 text-white text-sm hover:bg-blue-800 transition">
                    Cari
                </button>

                <!-- Tombol Reset -->
                <a href="{{ route('staff.home') }}"
                    class="px-4 py-2 rounded-md bg-yellow-400 text-black text-sm hover:bg-blue-800 hover:text-white transition">
                    Reset
                </a>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto min-w-[280px] justify-end">

                <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-700 whitespace-nowrap w-[70px] text-right">Dari:</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm w-full sm:w-auto"
                            onchange="this.form.submit()">
                    </div>

                    <div class="flex items-center gap-2 mt-3 sm:mt-0">
                        <label class="text-sm text-gray-700 whitespace-nowrap w-[70px] text-right">Sampai:</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm w-full sm:w-auto"
                            onchange="this.form.submit()">
                    </div>
                </div>
            </div>

        </form>

        {{-- CARD --}}
        {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($publikasi as $item)
                @php
                    $isPromosi = $item['jenis'] === 'Publikasi Promosi';
                    $bgClass = $isPromosi
                        ? 'bg-gray-200 text-green-700 border-2 border-green-500'
                        : 'bg-green-900 text-yellow-500 border-2 border-yellow-500';
                    $buttonClass = $isPromosi ? 'bg-yellow-400 text-black' : 'bg-yellow-400 text-black';
                @endphp

                <div class="h-full">
                    <div
                        class="rounded-xl p-4 shadow {{ $bgClass }} flex flex-col h-full transition transform hover:scale-[1.02] duration-300">

                        <div class="flex flex-col sm:relative mb-4">
                            <div class="sm:absolute sm:top-0 sm:left-0 mb-2 sm:mb-0">
                                <span
                                    class="text-sm px-3 py-1 rounded-full {{ $isPromosi ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ $item['jenis'] }}
                                </span>
                            </div>
                        </div>

                        <div class="text-center mb-3 mt-2 md:mt-3 mx-8">
                            <h2 class="font-bold text-xl mb-2">{{ $item['judul'] }}</h2>
                        </div>

                        <section class="bg-primary rounded-lg pb-6">
                            <div class="overflow-x-auto pb-4">
                                <table class="w-full bg-[#0B4D1E] text-sm text-center rounded-t-lg">
                                    <thead>
                                        <tr class="font-semibold text-[#FFC107]">
                                            <th class="py-4 px-5 w-1/5">Kode Publikasi</th>
                                            <th class="py-4 px-5 w-1/5">Nama Pemohon</th>
                                            <th class="py-4 px-5 w-1/5">Tanggal</th>
                                            <th class="py-4 px-5 w-1/5">Unit</th>
                                            <th class="py-4 px-5 w-1/5">Sub Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-t border-[#0B4D1E] text-[#D9D9D9]">
                                            <td class="pb-4 px-5">{{ $item['id_proses_permohonan'] }}</td>
                                            <td class="pb-4 px-5">{{ $item['nama_pemohon'] }}</td>
                                            <td class="pb-4 px-5">{{ $item['tanggal'] }}</td>
                                            <td class="pb-4 px-5">{{ $item['nama_unit'] }}</td>
                                            <td class="pb-4 px-5">{{ $item['nama_sub_unit'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h2 class="text-lg font-semibold mb-6 text-white text-center md:text-left px-6">
                                Status Permohonan Publikasi
                            </h2>

                            @php
                                $steps = [
                                    'Diajukan' => $item['tanggal_diajukan'],
                                    'Diterima' => $item['tanggal_diterima'],
                                    'Diproses' => $item['tanggal_diproses'],
                                    'Selesai' => $item['tanggal_selesai'],
                                ];
                                $activeStep = $item['status'];
                                $stepReached = true;
                            @endphp

                            <div class="relative w-full max-w-4xl mx-auto px-4">
                                <div class="hidden sm:block absolute top-7 left-[100px] right-[100px] h-2 bg-white z-0">
                                </div>
                                <div class="sm:hidden block absolute left-[47px] top-[0px] bottom-[30px] w-1 bg-white z-0">
                                </div>

                                <div class="flex flex-col sm:flex-row sm:justify-between gap-6 sm:gap-0 relative z-10">
                                    @foreach ($steps as $label => $date)
                                        @php
                                            $isActive = $stepReached;
                                            if ($label === $activeStep) {
                                                $stepReached = false;
                                            }
                                        @endphp
                                        <div
                                            class="flex sm:flex-col flex-row sm:items-center items-start sm:w-1/4 w-full gap-4 sm:gap-0">
                                            <div
                                                class="w-16 h-16 mb-5 rounded-full flex items-center justify-center
                                        {{ $isActive ? 'bg-[#00FF6A] text-white border-4 border-white' : 'bg-yellow-400 text-white border-4 border-white' }}">
                                                <i class="{{ $isActive ? 'fas fa-check' : 'far fa-clock' }}"></i>
                                            </div>
                                            <div class="flex flex-col sm:items-center items-start text-white">
                                                <span
                                                    class="text-lg font-semibold {{ $isActive ? 'text-white' : 'text-white/70' }}">
                                                    {{ $label }}
                                                </span>
                                                @if ($date)
                                                    <span
                                                        class="text-sm text-white/70 mt-1 leading-tight text-left sm:text-center">
                                                        {!! str_replace(' ', '<br>', \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y')) !!}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <div class="mt-auto pt-4 flex flex-col sm:flex-row items-center md:justify-end justify-center">
                            @if ($item['status'] === 'Diajukan')
                                <a href="#"
                                    class="px-4 py-2 rounded-md bg-green-500 w-full sm:w-auto text-center text-white font-semibold"
                                    data-terima="{{ $item['id_proses_permohonan'] }}">Diterima</a>
                            @elseif ($item['status'] === 'Diterima')
                                <a href="#"
                                    class="px-4 py-2 rounded-md bg-green-500 w-full sm:w-auto text-center text-white font-semibold"
                                    data-diproses="{{ $item['id_proses_permohonan'] }}">Diproses</a>
                            @endif
                            <a href="#"
                                class="px-4 py-2 rounded-md bg-red-500 w-full sm:w-auto text-center text-white font-semibold md:ms-2 mt-2 sm:mt-0"
                                data-batal="{{ $item['id_proses_permohonan'] }}">Batal</a>
                            <a href="{{ route('staff.detail-publikasi', $item['id_proses_permohonan']) }}"
                                class="px-4 py-2 rounded-md {{ $buttonClass }} w-full sm:w-auto text-center text-base font-semibold md:ms-2 mt-2 sm:mt-0">Detail</a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500 py-8">
                    Belum ada data publikasi yang tersedia.
                </div>
            @endforelse
        </div> --}}

        {{-- TABLE --}}
        {{-- TABLE RESPONSIVE --}}
        <div class="w-full overflow-x-auto">
            <table class="min-w-[800px] w-full text-md text-center bg-white rounded-lg overflow-hidden shadow">
                <thead class="bg-[#0B4D1E] text-[#FFC107] font-semibold">
                    <tr>
                        <th class="py-4 px-5 w-20 whitespace-nowrap">Kode</th>
                        <th class="py-4 px-5">Jenis</th>
                        <th class="py-4 px-5 whitespace-nowrap">Tanggal Pelaksanaan</th>
                        <th class="py-4 px-5">Judul Publikasi</th>
                        <th class="py-4 px-5">Nama Pemohon</th>
                        <th class="py-4 px-5">Sub Unit</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($publikasi as $item)
                        <tr
                            class="border-b text-black text-center hover:bg-blue-100
                                {{ $item['jenis'] === 'Promosi' ? 'bg-yellow-100' : '' }}
                                {{ $item['jenis'] === 'Liputan' ? 'bg-green-100' : '' }}">
                            <td class="py-3 px-5 w-20 text-left whitespace-nowrap">{{ $item['id_proses_permohonan'] }}</td>
                            <td class="py-3 px-5">{{ $item['jenis'] }}</td>
                            <td class="py-3 px-5 whitespace-nowrap">{{ $item['tanggal'] ? \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') : '' }}</td>
                            <td class="py-3 px-5">{{ $item['judul'] }}</td>
                            <td class="py-3 px-5">{{ $item['nama_pemohon'] }}</td>
                            <td class="py-3 px-5">{{ $item['nama_sub_unit'] }}</td>
                            <td class="py-3 px-5">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                {{ $item['status'] === 'Diajukan' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $item['status'] === 'Diterima' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $item['status'] === 'Diproses' ? 'bg-blue-200 text-blue-800' : '' }}
                                {{ $item['status'] === 'Selesai' ? 'bg-gray-200 text-gray-800' : '' }}
                                {{ $item['status'] === 'Batal' ? 'bg-red-200 text-red-800' : '' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="py-3 px-5">
                                <a href="{{ route('staff.detail-publikasi', $item['id_proses_permohonan']) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded-md font-semibold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                Tidak ada permohonan publikasi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex flex-wrap justify-center space-x-1 sm:space-x-2 text-sm sm:text-base">
            {{-- First --}}
            @if ($publikasi->onFirstPage())
                <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">&laquo;</span>
            @else
                <a href="{{ $publikasi->url(1) }}"
                    class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">&laquo;</a>
            @endif

            {{-- Previous --}}
            @if ($publikasi->onFirstPage())
                <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">Prev</span>
            @else
                <a href="{{ $publikasi->previousPageUrl() }}"
                    class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">Prev</a>
            @endif

            {{-- Page Numbers --}}
            @php
                $start = max($publikasi->currentPage() - 2, 1);
                $end = min($start + 4, $publikasi->lastPage());
                if ($end - $start < 4) {
                    $start = max($end - 4, 1);
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $publikasi->currentPage())
                    <span class="px-2 sm:px-3 py-1 bg-blue-200 text-yellow-700 rounded">{{ $page }}</span>
                @else
                    <a href="{{ $publikasi->url($page) }}"
                        class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-100">{{ $page }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if ($publikasi->hasMorePages())
                <a href="{{ $publikasi->nextPageUrl() }}"
                    class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">Next</a>
            @else
                <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">Next</span>
            @endif

            {{-- Last --}}
            @if ($publikasi->currentPage() === $publikasi->lastPage())
                <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">&raquo;</span>
            @else
                <a href="{{ $publikasi->url($publikasi->lastPage()) }}"
                    class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">&raquo;</a>
            @endif
        </div>
    </div>
@endsection
