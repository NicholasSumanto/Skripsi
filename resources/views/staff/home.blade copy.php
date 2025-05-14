@extends('template.staff.main-staff')
@section('title', 'Home Staff')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Permintaan Publikasi</h1>

    <!-- Sorting Filter -->
    <form method="GET" action="{{ route('staff.home') }}" class="mb-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <label for="sort" class="text-lg font-semibold text-green-700">Urutan:</label>
            <select name="sort" id="sort" class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-[#1a237e] focus:outline-none">
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terdekat</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terjauh</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-md hover:bg-[#0d1a68] transition duration-200">Filter</button>
        </div>
    </form>

    <div class="space-y-4">
        @foreach ($publikasi as $item)
        @php
            $isPromosi = $item['jenis'] === 'Publikasi Promosi';
            $bgClass = $isPromosi ? 'bg-gray-100 text-green-700 border-2 border-green-500' : 'bg-green-900 text-yellow-500 border-2 border-yellow-500';
            $buttonClass = $isPromosi ? 'bg-green-700 text-white' : 'bg-yellow-400 text-black';
            $borderClass = $isPromosi ? 'border-t-2 border-green-500' : 'border-t-2 border-yellow-500';
        @endphp
        <div class="rounded-xl p-4 shadow {{ $bgClass }} flex flex-col justify-between min-h-[200px] transition transform hover:scale-[1.02] duration-300">

            <!-- Responsive Top Labels -->
            <div class="flex flex-col sm:relative mb-4">
                <!-- Status -->
                <div class="sm:absolute sm:top-0 sm:right-0 mb-1 sm:mb-0">
                    <span class="inline-block text-sm px-3 py-1 rounded-full bg-blue-200 text-blue-800">
                        {{ $item['status'] ?? 'Diajukan' }}
                    </span>
                </div>
                <!-- Jenis Publikasi -->
                <div class="sm:absolute sm:top-0 sm:left-0 mb-2 sm:mb-0">
                    <span class="text-sm px-3 py-1 rounded-full {{ $isPromosi ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                        {{ $item['jenis'] }}
                    </span>
                </div>
            </div>

            <!-- Judul dan Pemohon -->
            <div class="text-center mb-3">
                <h2 class="font-bold text-xl mb-2">{{ $item['judul'] }}</h2>
                <p class="text-base"><strong>Oleh:</strong> {{ $item['nama_pemohon'] ?? 'nama_pemohon' }}</p>
            </div>

            <!-- Informasi Tambahan -->
            <div class="flex justify-between items-start text-sm mb-3">
                <div>
                    <p class="text-base"><strong>Unit:</strong> {{ $item['unit'] }}</p>
                    <p class="text-base"><strong>Subunit:</strong> {{ $item['subunit'] }}</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-base">Tanggal Acara:</p>
                    <p class="text-base">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Kode dan Tombol -->
            <div class="mt-auto flex flex-col sm:flex-row justify-between items-center pt-4 {{ $borderClass }}">
                <p class="text-lg italic text-center sm:text-left mb-2">{{ $item['kode'] }}</p>
                <a href="#" class="px-4 py-2 rounded-full {{ $buttonClass }} w-full sm:w-auto text-center text-base font-semibold">Detail</a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex flex-wrap justify-center space-x-1 sm:space-x-2 text-sm sm:text-base">
        {{-- First --}}
        @if ($publikasi->onFirstPage())
            <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">&laquo;</span>
        @else
            <a href="{{ $publikasi->url(1) }}" class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">&laquo;</a>
        @endif

        {{-- Previous --}}
        @if ($publikasi->onFirstPage())
            <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">Prev</span>
        @else
            <a href="{{ $publikasi->previousPageUrl() }}" class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">Prev</a>
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
                <span class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded">{{ $page }}</span>
            @else
                <a href="{{ $publikasi->url($page) }}" class="px-2 sm:px-3 py-1 bg-blue-100 text-yellow-700 rounded hover:bg-blue-200">{{ $page }}</a>
            @endif
        @endfor

        {{-- Next --}}
        @if ($publikasi->hasMorePages())
            <a href="{{ $publikasi->nextPageUrl() }}" class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">Next</a>
        @else
            <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">Next</span>
        @endif

        {{-- Last --}}
        @if ($publikasi->currentPage() === $publikasi->lastPage())
            <span class="px-2 sm:px-3 py-1 bg-gray-300 text-gray-600 rounded">&raquo;</span>
        @else
            <a href="{{ $publikasi->url($publikasi->lastPage()) }}" class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded hover:bg-blue-700">&raquo;</a>
        @endif
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/swal.js') }}" defer></script>
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            const userName = localStorage.getItem('user_name');
            if (userName) {
                alert.fire({
                    icon: 'success',
                    title: "Selamat datang, " + userName,
                });
                localStorage.removeItem('user_name');
            }
        });
    </script>
@endsection
