@extends('template.staff.main-staff')
@section('title', 'Home Staff')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Permintaan Publikasi</h1>

        <!-- Sorting Filter -->
        <form method="GET" action="{{ route('staff.home') }}"
            class="mb-4 flex flex-wrap items-center gap-2 md:justify-start justify-center">
            <label for="sort" class="text-lg font-semibold text-green-700">Urutan :</label>
            <select name="sort" id="sort"
                class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                <option value="">-- Semua Urutan --</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terdekat</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terjauh</option>
            </select>

            <select name="pub" id="pub"
                class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                <option value="">-- Semua Jenis --</option>
                <option value="liputan" {{ request('pub') == 'liputan' ? 'selected' : '' }}>Liputan</option>
                <option value="promosi" {{ request('pub') == 'promosi' ? 'selected' : '' }}>Promosi</option>
            </select>

            <select name="proses" id="proses"
                class="form-select bg-[#f3f4f6] border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#1a237e] focus:outline-none max-w-[200px]">
                <option value="">-- Semua Status --</option>
                <option value="diajukan" {{ request('proses') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diterima" {{ request('proses') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="diproses" {{ request('proses') == 'diproses' ? 'selected' : '' }}>Diproses</option>
            </select>

            <button type="submit"
                class="px-4 py-2 bg-green-700 text-white text-sm rounded-md hover:bg-[#0d1a68] transition duration-200 whitespace-nowrap">
                Filter
            </button>

            <a href="{{ route('staff.home') }}" class="px-4 py-2 rounded-md bg-yellow-400 text-black text-sm">
                Reset
            </a>
        </form>

        <div class="space-y-4">
            @foreach ($publikasi as $item)
                @php
                    $isPromosi = $item['jenis'] === 'Publikasi Promosi';
                    $bgClass = $isPromosi
                        ? 'bg-gray-100 text-green-700 border-2 border-green-500'
                        : 'bg-green-900 text-yellow-500 border-2 border-yellow-500';
                    $buttonClass = $isPromosi ? 'bg-green-700 text-white' : 'bg-yellow-400 text-black';
                    $borderClass = $isPromosi ? 'border-t-2 border-green-500' : 'border-t-2 border-yellow-500';
                @endphp
                <div
                    class="rounded-xl p-4 shadow {{ $bgClass }} flex flex-col justify-between min-h-[200px] transition transform hover:scale-[1.02] duration-300">

                    <!-- Responsive Top Labels -->
                    <div class="flex flex-col sm:relative mb-4">
                        <!-- Jenis Publikasi -->
                        <div class="sm:absolute sm:top-0 sm:left-0 mb-2 sm:mb-0">
                            <span
                                class="text-sm px-3 py-1 rounded-full {{ $isPromosi ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                {{ $item['jenis'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Judul dan Pemohon -->
                    <div class="text-center mb-3 mt-0 mt-2 md:mt-3 mx-8">
                        <h2 class="font-bold text-xl mb-2">{{ $item['judul'] }}</h2>
                    </div>

                    <section class="bg-primary rounded-lg pb-6">
                        <div class="overflow-x-auto pb-4">
                            <table class="w-full bg-[#0B4D1E] text-sm text-center rounded-t-lg">
                                <thead>
                                    <tr class="font-semibold text-[#FFC107]">
                                        <th class="py-4 px-5 w-1/5">Kode Kegiatan</th>
                                        <th class="py-4 px-5 w-1/5">Nama Pemohon</th>
                                        <th class="py-4 px-5 w-1/5">Tanggal</th>
                                        <th class="py-4 px-5 w-1/5">Unit</th>
                                        <th class="py-4 px-5 w-1/5">Sub Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-[#0B4D1E] text-[#D9D9D9]">
                                        <td class="pb-4 px-5 w-1/5">{{ $item['id_proses_permohonan'] }}</td>
                                        <td class="pb-4 px-5 w-1/5">{{ $item['nama_pemohon'] }}</td>
                                        <td class="pb-4 px-5 w-1/5">{{ $item['tanggal'] }}</td>
                                        <td class="pb-4 px-5 w-1/5">{{ $item['nama_unit'] }}</td>
                                        <td class="pb-4 px-5 w-1/5">{{ $item['nama_sub_unit'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <h2 class="text-lg font-semibold mb-6 text-white text-center md:text-left px-6">Status Permohonan
                            Publikasi
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
                            <!-- Garis -->
                            <div class="hidden sm:block absolute top-7 left-[100px] right-[100px] h-2 bg-white z-0"></div>
                            <div class="sm:hidden block absolute left-[47px] top-[0px] bottom-[30px] w-1 bg-white z-0">
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-6 sm:gap-0 relative z-10">
                                @foreach ($steps as $label => $date)
                                    @php
                                        // Tandai aktif kalau status sekarang BELUM dilewati
                                        $isActive = $stepReached;

                                        // Kalau label saat ini sama dengan status, hentikan keaktifan berikutnya
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

                    <div
                        class="mt-auto flex flex-col sm:flex-row justify-between items-center pt-4 md:justify-end justify-center">
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
                            class="px-4 py-2 rounded-md bg-red-500 w-full sm:w-auto text-center text-white font-semibold md:ms-2 ms-0 md:mt-0 mt-2"
                            data-batal="{{ $item['id_proses_permohonan'] }}">Batal</a>
                        <a href="{{ route('staff.detail-publikasi', $item['id_proses_permohonan']) }}"
                            class="px-4 py-2 rounded-md {{ $buttonClass }} w-full sm:w-auto text-center text-base font-semibold md:ms-2 ms-0 md:mt-0 mt-2">Detail</a>
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
                    <span class="px-2 sm:px-3 py-1 bg-green-700 text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $publikasi->url($page) }}"
                        class="px-2 sm:px-3 py-1 bg-blue-100 text-yellow-700 rounded hover:bg-blue-200">{{ $page }}</a>
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

@section('script')
    <script>
        $(document).ready(function() {
            // Konfirmasi pembatalan
            $('[data-batal]').on('click', function(e) {
                e.preventDefault();
                const id_proses_permohonan = $(this).data('batal');

                Swal.fire({
                    title: 'Batalkan Permohonan?',
                    html: `Anda membatalkan permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat dibatalkan.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('staff.api.delete.publikasi') }}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                id_proses_permohonan: id_proses_permohonan,
                            },
                            beforeSend: function() {
                                $('[data-batal]').text('Proses Batal Berlangsung').attr(
                                    'disabled', true);
                                $(this).text('Membatalkan...').attr('disabled', true);
                            },
                            success: function(res) {
                                localStorage.setItem('batalkan_message', res.message);
                                location.reload();
                            },
                            error: function(err) {
                                $('[data-batal]').text('Batal').attr(
                                    'disabled', false);
                                alert.fire({
                                    icon: 'error',
                                    title: err.responseJSON.error ?? err
                                        .responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });

            // Konfirmasi terima
            $('[data-terima]').on('click', function(e) {
                e.preventDefault();
                const id_proses_permohonan = $(this).data('terima');

                Swal.fire({
                    title: 'Terima Permohonan?',
                    html: `Anda menerima permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat diubah.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#088404',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Terima',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('staff.api.update.status-publikasi') }}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                id_proses_permohonan: id_proses_permohonan,
                                jenis_proses: 'Diterima',
                            },
                            beforeSend: function() {
                                $('[data-terima]').text('Proses Terima Berlangsung').attr(
                                    'disabled', true);
                                $(this).text('Menerima...').attr('disabled', true);
                            },
                            success: function(res) {
                                localStorage.setItem('terima_message', res.message);
                                location.reload();
                            },
                            error: function(err) {
                                $('[data-terima]').text('Terima').attr(
                                    'disabled', false);
                                alert.fire({
                                    icon: 'error',
                                    title: err.responseJSON.error ?? err
                                        .responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });

            // Konfirmasi diproses
            $('[data-diproses]').on('click', function(e) {
                e.preventDefault();
                const id_proses_permohonan = $(this).data('diproses');

                Swal.fire({
                    title: 'Proses Permohonan?',
                    html: `Anda memproses permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat diubah.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#088404',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Proses',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('staff.api.update.status-publikasi') }}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                id_proses_permohonan: id_proses_permohonan,
                                jenis_proses: 'Diproses',
                            },
                            beforeSend: function() {
                                $('[data-diproses]').text('Proses Diproses Berlangsung').attr(
                                    'disabled', true);
                                $(this).text('Memproses...').attr('disabled', true);
                            },
                            success: function(res) {
                                localStorage.setItem('diproses_message', res.message);
                                location.reload();
                            },
                            error: function(err) {
                                $('[data-diproses]').text('Diproses').attr(
                                    'disabled', false);
                                alert.fire({
                                    icon: 'error',
                                    title: err.responseJSON.error ?? err
                                        .responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
