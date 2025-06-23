@extends('template.staff.main-staff')
@section('title', 'Dashboard Staff')

@section('custom-header')
    <link rel="stylesheet"href="{{ asset('css/calendar_v2.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar_v2.css') }}">
    <style>
        .bg-hijau {
            background-color: #28a745 !important;
            color: white !important;
            font-weight: bold !important;
        }

        .bg-kuning {
            background-color: #ffc107 !important;
            font-weight: bold !important;
        }

        .bg-ungu {
            background-color: #6f42c1 !important;
            color: white !important;
            font-weight: bold !important;
        }
    </style>
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col md:flex-row max-w-10xl mx-auto w-full items-stretch">
            <!-- Bagian Calendar -->
            <div class="basis-2/3 bg-white p-8 sm:p-2 flex flex-col justify-center">
                <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Agenda Publikasi</h1>
                <div id="calendar" class="w-full min-h-[400px] p-0 mb-4"></div>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold mb-2 block">Keterangan :</span>
                    <span class="bg-hijau text-white px-2 py-1 rounded-md mb-2 inline-block">Liputan</span> : Hari
                    Pelaksanaan Kegiatan Publikasi Liputan. <br>
                    <span class="bg-kuning text-white px-2 py-1 rounded-md mb-2 inline-block">Promosi</span> : Hari
                    Pelaksanaan Kegiatan Publikasi Promosi. <br>
                    <span class="bg-ungu text-white px-2 py-1 rounded-md mb-2 inline-block">Liputan & Promosi</span> : Hari
                    Pelaksanaan Kegiatan Publikasi Liputan dan Promosi.
                </p>
            </div>

            <!-- Bagian Kiri -->
            <div class="basis-1/3 bg-white p-8 sm:p-2 flex flex-col gap-6">
                @foreach ($cards as $card)
                    @php
                        $status = $card['stat']['status'];
                        $persen = $card['stat']['persen'];
                        $arrowUp = $status === 'bertambah';
                        $arrowDown = $status === 'berkurang';
                        $colorClass = $arrowUp ? 'text-green-600' : ($arrowDown ? 'text-red-600' : 'text-gray-500');
                    @endphp

                    <div class="bg-gray-200 rounded-xl shadow-md p-6 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm text-gray-500 font-medium">{{ $card['title'] }}</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($card['count']) }}</p>
                            <div class="text-sm mt-1 font-semibold flex items-center gap-1 {{ $colorClass }}">
                                @if ($arrowUp)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 10l7-7 7 7" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                @elseif ($arrowDown)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 14l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                @endif
                                {{ abs($persen) }}% {{ ucfirst($status) }} dari kemarin
                            </div>
                        </div>
                        <div class="ml-4 bg-{{ $card['iconColor'] }}-100 p-3 rounded-full">
                            @switch($card['icon'])
                                @case('user')
                                    <svg class="w-6 h-6 text-{{ $card['iconColor'] }}-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-6 8a6 6 0 0112 0H4z" />
                                    </svg>
                                @break

                                @case('megaphone')
                                    <svg class="w-6 h-6 text-{{ $card['iconColor'] }}-500" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M18.458 3.11A1 1 0 0 1 19 4v16a1 1 0 0 1-1.581.814L12 16.944V7.056l5.419-3.87a1 1 0 0 1 1.039-.076ZM22 12c0 1.48-.804 2.773-2 3.465v-6.93c1.196.692 2 1.984 2 3.465ZM10 8H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6V8Zm0 9H5v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @break

                                @case('camera')
                                    <svg class="w-6 h-6 text-{{ $card['iconColor'] }}-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-3l-1-2H8L7 5H4zm6 3a3 3 0 110 6 3 3 0 010-6z" />
                                    </svg>
                                @break

                                @case('check-circle')
                                    <svg class="w-6 h-6 text-{{ $card['iconColor'] }}-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @break

                                @default
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 20 20">
                                        <path d="M10 10h.01" />
                                    </svg>
                            @endswitch
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        <hr class="my-8 border-gray-300">
        <div class="w-full p-8 sm:p-2">
            <h1 class="text-3xl font-bold mb-6 text-[#1a237e] text-center md:text-center">Daftar
                Publikasi Terbaru</h1>
            <div x-data="publikasi()">
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm text-center">
                        <thead class="bg-gray-200 text-green-700">
                            <tr>
                                <th class="border py-2 px-1">Kode</th>
                                <th class="border py-2 px-1">Jenis</th>
                                <th class="border py-2 px-1">Tanggal</th>
                                <th class="border py-2 px-1">Nama Publikasi</th>
                                <th class="border py-2 px-1">Unit</th>
                                <th class="border py-2 px-1">Sub Unit</th>
                                <th class="border py-2 px-1">Status</th>
                                <th class="border py-2 px-1">Tautan</th>
                                <th class="border py-2 px-1">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in paginatedData" :key="item.id">
                                <tr class="bg-gray-100">
                                    <td class="border py-2 px-1" x-text="item.kode"></td>
                                    <td class="border py-2 px-1" x-text="item.jenis"></td>
                                    <td class="border py-2 px-1" x-text="item.tanggal"></td>
                                    <td class="border py-2 px-1" x-text="item.nama"></td>
                                    <td class="border py-2 px-1" x-text="item.unit"></td>
                                    <td class="border py-2 px-1" x-text="item.subUnit"></td>
                                    <td class="border py-2 px-1 text-center">
                                        <span class="text-sm font-semibold px-2 py-1 rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-700': item.status === 'Selesai',
                                                'bg-red-100 text-red-700': item.status === 'Batal',
                                                'bg-yellow-100 text-yellow-700': item.status !== 'Selesai' && item
                                                    .status !== 'Batal'
                                            }"
                                            x-text="item.status">
                                        </span>
                                    </td>
                                    <td class="border py-2 px-1 text-blue-500 underline">
                                        <button @click="openLinkModal(item.tautan)"
                                            class="underline text-blue-500">Lihat</button>
                                    </td>
                                    <td class="border py-2 px-1">
                                        <a :href="`{{ route('staff.detail-publikasi', ':id') }}`.replace(':id', item.kode)"
                                            class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-900"
                                            target="_blank" rel="noopener">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="paginatedData.length === 0">
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td>
                                </tr>
                            </template>

                            <template x-for="item in paginatedData" :key="item.id">
                                <tr class="bg-gray-100">
                                    ...
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-end my-2">
                <a href="{{ route('staff.home') }}" class="text-blue-700 hover:underline font-semibold">
                    Lihat Daftar Publikasi Lain &rarr;
                </a>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <!-- JS Addon -->
    <script src="{{ asset('js/calendar_v2.core.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            const today = '{{ \Carbon\Carbon::now()->format('Y-m-d') }}';

            $.ajax({
                url: "{{ route('api.get.tanggal-jadwal') }}",
                method: 'GET',
                dataType: 'json',
                success: function(tanggalList) {
                    const groupedByTanggal = {};

                    tanggalList.forEach(item => {
                        if (!groupedByTanggal[item.tanggal]) {
                            groupedByTanggal[item.tanggal] = [];
                        }
                        groupedByTanggal[item.tanggal].push(item.jenis);
                    });

                    const popups = {};

                    Object.keys(groupedByTanggal).forEach(tanggal => {
                        const jenisList = groupedByTanggal[tanggal];
                        const jenisUnik = [...new Set(jenisList)];

                        let modifier = '';

                        if (jenisUnik.length > 1) {
                            modifier = 'bg-ungu';
                        } else {
                            modifier = jenisUnik[0] === 'Liputan' ? 'bg-hijau' : 'bg-kuning';
                        }

                        popups[tanggal] = {
                            modifier
                        };
                    });

                    const calendar = new VanillaCalendar('#calendar', {
                        settings: {
                            selection: {
                                day: 'single',
                            },
                            visibility: {
                                daysOutside: false,
                            }
                        },
                        popups: popups,
                        actions: {
                            clickDay(event, self) {
                                const selectedDate = self.selectedDates[0];
                                if (!selectedDate) return;

                                $.ajax({
                                    url: `{{ route('api.get.jadwal-publikasi') }}`,
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    data: {
                                        tanggal: selectedDate
                                    },
                                    dataType: 'json',
                                    beforeSend: function() {
                                        Swal.fire({
                                            title: 'Loading',
                                            text: 'Memuat Jadwal...',
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });
                                    },
                                    success: function(data) {
                                        if (data.length === 0) {
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Tidak ada jadwal',
                                                text: `Tidak ada kegiatan pada tanggal ${selectedDate}.`
                                            });
                                        } else {
                                            let htmlContent =
                                                `<div style="text-align:left; max-height:400px; overflow-y:auto;">`;

                                            const liputanList = data.filter(item =>
                                                item
                                                .jenis === 'Liputan');
                                            const promosiList = data.filter(item =>
                                                item
                                                .jenis === 'Promosi');

                                            function renderSection(judul, list) {
                                                if (list.length === 0) return '';

                                                let sectionHTML =
                                                    `<h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #444;">${judul}</h3>`;

                                                list.forEach((item, index) => {
                                                    const statusClass = item
                                                        .status ===
                                                        'Diproses' ?
                                                        'text-yellow-600' :
                                                        'text-red-600';

                                                    const hariPelaksanaan =
                                                        item
                                                        .hariPelaksanaan ??
                                                        'text-green-500'

                                                    sectionHTML += `
                                                    <div style="
                                                        border: 1px solid #e0e0e0;
                                                        border-radius: 8px;
                                                        padding: 12px 16px;
                                                        margin-bottom: 12px;
                                                        background-color: #f8f9fa;
                                                        box-shadow: 1px 1px 5px rgba(0,0,0,0.05);
                                                    ">
                                                        <div class="font-bold text-2xl"><span class="${hariPelaksanaan}">${item.hari_h}</span>${item.nama}</div>
                                                        <div class="${statusClass} text-sm mt-1 font-semibold text-xl">
                                                            ${item.status}
                                                        </div>

                                                        <div style="margin-top: 6px;">
                                                            <strong>Tempat:</strong> ${item.tempat}<br>
                                                            ${item.waktu ? `<strong>Waktu:</strong> ${item.waktu}` : ''}
                                                        </div>
                                                    </div>
                                                `;
                                                });

                                                return sectionHTML;
                                            }

                                            htmlContent += renderSection('Liputan',
                                                liputanList);
                                            htmlContent += renderSection('Promosi',
                                                promosiList);

                                            htmlContent += `</div>`;

                                            Swal.fire({
                                                title: `Jadwal Tanggal ${selectedDate}`,
                                                html: htmlContent,
                                                width: 700,
                                                confirmButtonText: 'Tutup',
                                                confirmButtonColor: '#6c757d',
                                            });

                                        }
                                    },

                                    error: function(xhr) {
                                        let message =
                                            'Terjadi kesalahan. Silakan coba lagi.';
                                        if (xhr.responseJSON?.error) {
                                            message = xhr.responseJSON.error;
                                        } else if (xhr.responseJSON?.errors) {
                                            message = Object.values(xhr.responseJSON
                                                .errors).flat().join('\n');
                                        }
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: message,
                                            timer: 7000,
                                        });
                                    }
                                });
                            }
                        }
                    });

                    calendar.init();
                },
                error: function(xhr) {
                    let message = 'Gagal mengambil daftar tanggal. Silakan coba lagi.';
                    if (xhr.responseJSON?.error) {
                        message = xhr.responseJSON.error;
                    } else if (xhr.responseJSON?.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    alert.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: message,
                        timer: 7000,
                    });
                }
            });
        });
    </script>

    <script>
        function publikasi() {
            return {
                search: '',
                selectedJenis: '',
                selectedStatus: '',
                sortOrder: '',
                startDate: '',
                endDate: '',
                selectedData: {},
                currentPage: 1,
                pageSize: 20,
                originalData: [],

                async init() {
                    try {
                        const params = new URLSearchParams({
                            pub: this.selectedJenis,
                            sort: this.sortOrder,
                            tanggal_mulai: this.startDate,
                            tanggal_selesai: this.endDate,
                        });

                        const response = await fetch(`{{ route('staff.api.get.publikasi') }}?${params.toString()}`);
                        const data = await response.json();
                        this.originalData = data.map(item => ({
                            id: item.id,
                            kode: item.id_proses_permohonan,
                            tanggal: item.tanggal,
                            nama: item.nama,
                            unit: item.unit,
                            subUnit: item.subUnit,
                            status: item.status,
                            jenis: item.jenis,
                            tautan: item.tautan ?? '-',
                        }));
                    } catch (error) {
                        console.error('Gagal mengambil data:', error);
                    }
                },

                get filteredData() {
                    let filtered = this.originalData.filter(item => {
                        return (
                            (this.search === '' || item.nama.toLowerCase().includes(this.search
                                .toLowerCase())) &&
                            (this.selectedJenis === '' || item.jenis === this.selectedJenis) &&
                            (this.selectedStatus === '' || item.status === this.selectedStatus) &&
                            (this.startDate === '' || new Date(item.tanggal) >= new Date(this.startDate)) &&
                            (this.endDate === '' || new Date(item.tanggal) <= new Date(this.endDate))
                        );
                    });

                    if (this.sortOrder) {
                        filtered = filtered.sort((a, b) => {
                            return this.sortOrder === 'asc' ?
                                new Date(a.tanggal) - new Date(b.tanggal) :
                                new Date(b.tanggal) - new Date(a.tanggal);
                        });
                    }

                    return filtered;
                },

                get totalPages() {
                    return Math.ceil(this.filteredData.length / this.pageSize);
                },

                get paginatedData() {
                    const startIndex = (this.currentPage - 1) * this.pageSize;
                    const endIndex = startIndex + this.pageSize;
                    return this.filteredData.slice(startIndex, endIndex);
                },

                formatDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                },

                openLinkModal(tautan) {
                    if (!tautan || tautan.length === 0 || tautan === '-' || tautan === '["-"]') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak ada tautan tersedia',
                            confirmButtonText: 'Tutup',
                            customClass: {
                                popup: 'rounded-xl shadow-lg p-6',
                                title: 'text-gray-800 text-xl font-semibold',
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md focus:outline-none'
                            }
                        });
                        return;
                    }

                    let links = [];

                    try {
                        links = JSON.parse(tautan);
                    } catch (e) {
                        links = tautan.split(',').map(t => t.trim());
                    }

                    const htmlList = links.map(link => {
                        return `
                        <li class="mb-2">
                            <a href="${link}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline transition duration-150 ease-in-out">
                                ${link}
                            </a>
                        </li>`;
                    }).join('');

                    Swal.fire({
                        title: '📎 Daftar Tautan',
                        html: `
                            <ul class="text-left text-base text-gray-700 list-disc list-inside space-y-2">
                                ${htmlList}
                            </ul>
                        `,
                        confirmButtonText: 'Tutup',
                        width: 600,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }
            }
        }
    </script>
@endsection
