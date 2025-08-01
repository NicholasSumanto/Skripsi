@extends('template.staff.main-staff')
@section('title', 'Riwayat Publikasi')


@section('content')
    <div x-data="riwayatPublikasi()" class="p-6 bg-white rounded shadow relative">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Riwayat Publikasi</h2>

            <form class="mb-4 flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-col md:flex-row md:flex-wrap md:items-center gap-2 flex-1 min-w-[300px]">
                    <label class="text-lg font-semibold text-green-700 md:mr-2">Sortir:</label>

                    <select x-model="sortOrder"
                        class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
                        <option value="">-- Semua Urutan --</option>
                        <option value="asc">Tanggal Terdekat</option>
                        <option value="desc">Tanggal Terjauh</option>
                    </select>

                    <!-- Jenis -->
                    <select x-model="selectedJenis"
                        class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
                        <option value="">-- Semua Jenis --</option>
                        <option value="Liputan">Liputan</option>
                        <option value="Promosi">Promosi</option>
                    </select>

                    <select x-model="selectedStatus"
                        class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Batal">Batal</option>
                    </select>

                    <!-- Search -->
                    <input type="text" x-model="search" placeholder="Cari judul publikasi..."
                        class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900 w-full md:w-auto">

                    <!-- Tombol Reset -->
                    <button type="button" @click="resetFilter"
                        class="px-4 py-2 bg-yellow-400 text-black text-sm rounded-md whitespace-nowrap hover:bg-blue-800 hover:text-white transition">Reset</button>
                </div>



                <!-- Bagian range tanggal dan export -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto min-w-[280px] justify-end">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">

                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-700 whitespace-nowrap w-[70px] text-right">Dari:</label>
                            <input type="date" x-model="startDate" :max="computedMaxStartDate"
                                @change="adjustEndDateRange"
                                class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm w-full sm:w-auto">
                        </div>

                        <div class="flex items-center gap-2 mt-3 sm:mt-0">
                            <label class="text-sm text-gray-700 whitespace-nowrap w-[70px] text-right">Sampai:</label>
                            <input type="date" x-model="endDate" :min="computedMinEndDate" @change="adjustStartDateRange"
                                class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm w-full sm:w-auto">
                        </div>
                    </div>

                    <button type="button" @click="exportData"
                        class="px-4 py-2 bg-green-700 text-white text-sm rounded-md whitespace-nowrap w-full sm:w-auto">
                        Export
                    </button>
                </div>
            </form>



            <div class="overflow-x-auto">
                <table class="w-full border-separate border-spacing-y-1 text-base text-left">
                    <thead class="bg-gray-200 text-green-700 text-center">
                        <tr>
                            <th class="border border-gray-300 py-2 px-2">Kode</th>
                            <th class="border border-gray-300 py-2 px-2">Jenis</th>
                            <th class="border border-gray-300 py-2 px-2">Tanggal Pelaksanaan</th>
                            <th class="border border-gray-300 py-2 px-2">Judul Publikasi</th>
                            <th class="border border-gray-300 py-2 px-2">Sub Unit</th>
                            <th class="border border-gray-300 py-2 px-2">Status</th>
                            <th class="border border-gray-300 py-2 px-2">Tautan</th>
                            <th class="border border-gray-300 py-2 px-2">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in paginatedData" :key="item.id">
                            <tr class="bg-gray-50 shadow-sm">
                                <td class="border border-gray-300 py-2 px-2" x-text="item.kode"></td>
                                <td class="border border-gray-300 py-2 px-2" x-text="item.jenis"></td>
                                <td class="border border-gray-300 py-2 px-2" x-text="item.tanggal"></td>
                                <td class="border border-gray-300 py-2 px-2" x-text="item.judul"></td>
                                <td class="border border-gray-300 py-2 px-2" x-text="item.subUnit"></td>
                                <td class="border border-gray-300 py-2 px-2 text-center">
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
                                <td class="border border-gray-300 py-2 px-2 text-center">
                                    <template x-if="item.status !== 'Batal'">
                                        <button @click="openLinkModal(item.tautan)"
                                            class="underline text-blue-500">Lihat</button>
                                    </template>
                                    <template x-if="item.status === 'Batal'">
                                        <span class="text-gray-400">-</span>
                                    </template>
                                </td>
                                <td class="border border-gray-300 py-2 px-2 text-center">
                                    <a :href="`{{ route('staff.detail-riwayat', ':id') }}`.replace(':id', item.kode)"
                                        class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        </template>

                        <template x-if="paginatedData.length === 0">
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-500 border border-gray-300">Data tidak
                                    ditemukan.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-2 text-sm sm:text-base border-none">
                <button :disabled="currentPage === 1" @click="currentPage = 1"
                    :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">&laquo;</button>

                <button :disabled="currentPage === 1" @click="currentPage--"
                    :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">Prev</button>

                <template x-for="page in totalPages" :key="page">
                    <button @click="currentPage = page"
                        :class="currentPage === page ? 'bg-blue-100 text-yellow-700 hover:bg-blue-200' :
                            'bg-green-700 text-white'"
                        class="px-3 py-1 rounded" x-text="page"></button>
                </template>

                <button :disabled="currentPage === totalPages" @click="currentPage++"
                    :class="currentPage === totalPages ? 'bg-gray-300 text-gray-600' :
                        'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">Next</button>

                <button :disabled="currentPage === totalPages" @click="currentPage = totalPages"
                    :class="currentPage === totalPages ? 'bg-gray-300 text-gray-600' :
                        'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">&raquo;</button>
            </div>
    </div>
@endsection

@section('script')
    <script>
        function riwayatPublikasi() {
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
                            pub: this.selectedJenis.toLowerCase(),
                            sort: this.sortOrder,
                            tanggal_mulai: this.startDate,
                            tanggal_selesai: this.endDate,
                            status: this.selectedStatus
                        });

                        const response = await fetch(`{{ route('staff.api.get.riwayat') }}?${params.toString()}`);
                        const data = await response.json();
                        this.originalData = data.map(item => ({
                            id: item.id,
                            kode: item.id_proses_permohonan,
                            tanggal: item.tanggal,
                            judul: item.judul,
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
                            (this.search === '' || item.judul.toLowerCase().includes(this.search
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

                resetFilter() {
                    this.search = '';
                    this.selectedJenis = '';
                    this.selectedStatus = '';
                    this.sortOrder = '';
                    this.startDate = '';
                    this.endDate = '';
                },

                computedMinEndDate() {
                    if (!this.startDate) return '';
                    const start = new Date(this.startDate);
                    return this.formatDate(start);
                },
                computedMaxStartDate() {
                    if (!this.endDate) return '';
                    const end = new Date(this.endDate);
                    return this.formatDate(end);
                },

                adjustEndDateRange() {
                    if (!this.startDate) return;
                    const start = new Date(this.startDate);
                    const maxEnd = new Date(start);
                    maxEnd.setMonth(maxEnd.getMonth() + 3);

                    if (this.endDate) {
                        const end = new Date(this.endDate);
                        if (end < start) {
                            alert.fire({
                                icon: 'warning',
                                title: 'Tanggal tidak valid',
                                text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
                            });
                            this.endDate = '';
                        } else if (end > maxEnd) {
                            alert.fire({
                                icon: 'warning',
                                title: 'Melebihi batas 3 bulan',
                                text: 'Tanggal selesai tidak boleh lebih dari 3 bulan setelah tanggal mulai.',
                            });
                            this.endDate = '';
                        }
                    }
                },

                adjustStartDateRange() {
                    if (!this.endDate) return;
                    const end = new Date(this.endDate);
                    const minStart = new Date(end);
                    minStart.setMonth(minStart.getMonth() - 3);

                    if (this.startDate) {
                        const start = new Date(this.startDate);
                        if (start > end) {
                            alert.fire({
                                icon: 'warning',
                                title: 'Tanggal tidak valid',
                                text: 'Tanggal mulai tidak boleh lebih akhir dari tanggal selesai.',
                            });
                            this.startDate = '';
                        } else if (start < minStart) {
                            alert.fire({
                                icon: 'warning',
                                title: 'Melebihi batas 3 bulan',
                                text: 'Tanggal mulai tidak boleh lebih dari 3 bulan sebelum tanggal selesai.',
                            });
                            this.startDate = '';
                        }
                    }
                },

                formatDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                },


                exportData() {
                    const params = new URLSearchParams({
                        pub: this.selectedJenis.toLowerCase(),
                        sort: this.sortOrder,
                        tanggal_mulai: this.startDate,
                        tanggal_selesai: this.endDate,
                        status: this.selectedStatus
                    });

                    const url = `{{ route('staff.riwayat.export') }}?${params.toString()}`;

                    window.open(url, '_blank');
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
                        title: 'Daftar Tautan',
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
