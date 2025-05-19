@extends('template.staff.main-staff')
@section('title', 'Riwayat Publikasi')

@section('content')
<div x-data="riwayatPublikasi()" class="p-6 bg-white rounded shadow relative">
    <h2 class="text-2xl font-bold text-center mb-4 text-blue-900">Riwayat Publikasi</h2>

    <!-- Filter Form -->
    <form class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <!-- Left side: Search and Filters -->
    <div class="flex flex-wrap items-center gap-2 md:justify-start justify-center">
        <label class="text-lg font-semibold text-green-700">Urutan:</label>
        <select x-model="sortOrder" class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
            <option value="">-- Semua Urutan --</option>
            <option value="asc">Tanggal Terdekat</option>
            <option value="desc">Tanggal Terjauh</option>
        </select>

        <select x-model="selectedJenis" class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
            <option value="">-- Semua Jenis --</option>
            <option value="Liputan">Liputan</option>
            <option value="Promosi">Promosi</option>
        </select>

        <input type="text" x-model="search" placeholder="Cari nama publikasi..." class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">

        <button type="button" @click="resetFilter" class="px-4 py-2 bg-yellow-400 text-black text-sm rounded-md">Reset</button>
    </div>

    <!-- Right side: Period Filter and Export Button -->
    <div class="flex items-center gap-4">
        <!-- Period Filter -->
        <select x-model="selectedPeriod" class="form-select bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900">
            <option value="">-- Semua Periode --</option>
            <option value="1">1 Bulan Terakhir</option>
            <option value="2">2 Bulan Terakhir</option>
            <option value="3">3 Bulan Terakhir</option>
        </select>

        <!-- Export Button -->
        <button type="button" @click="exportData" class="px-4 py-2 bg-green-700 text-white text-sm rounded-md">Export to CSV</button>
    </div>
</form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border text-sm text-center">
            <thead class="bg-gray-200 text-green-700">
                <tr>
                    <th class="border py-2">Kode</th>
                    <th class="border py-2">Jenis</th>
                    <th class="border py-2">Tanggal</th>
                    <th class="border py-2">Nama Publikasi</th>
                    <th class="border py-2">Unit</th>
                    <th class="border py-2">Sub Unit</th>
                    <th class="border py-2">Tautan</th>
                    <th class="border py-2">Detail</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in paginatedData" :key="item.id">
                    <tr class="bg-gray-100">
                        <td class="border py-2" x-text="item.kode"></td>
                        <td class="border py-2" x-text="item.jenis"></td>
                        <td class="border py-2" x-text="item.tanggal"></td>
                        <td class="border py-2" x-text="item.nama"></td>
                        <td class="border py-2" x-text="item.unit"></td>
                        <td class="border py-2" x-text="item.subUnit"></td>
                        <td class="border py-2 text-blue-500 underline">
                            <a :href="item.tautan" target="_blank">Lihat</a>
                        </td>
                        <td class="border py-2">
                            <a href="#" class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-900">
                                Detail
                            </a>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex flex-wrap justify-center gap-2 text-sm sm:text-base border-none">
        <button :disabled="currentPage === 1" @click="currentPage = 1"
            :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
            class="px-3 py-1 rounded">&laquo;</button>

        <button :disabled="currentPage === 1" @click="currentPage--"
            :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
            class="px-3 py-1 rounded">Prev</button>

        <template x-for="page in totalPages" :key="page">
            <button @click="currentPage = page"
                :class="currentPage === page ? 'bg-green-700 text-white' : 'bg-blue-100 text-yellow-700 hover:bg-blue-200'"
                class="px-3 py-1 rounded" x-text="page"></button>
        </template>

        <button :disabled="currentPage === totalPages" @click="currentPage++"
            :class="currentPage === totalPages ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
            class="px-3 py-1 rounded">Next</button>

        <button :disabled="currentPage === totalPages" @click="currentPage = totalPages"
            :class="currentPage === totalPages ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
            class="px-3 py-1 rounded">&raquo;</button>
    </div>

    <!-- Modal -->
    <div x-show="modalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-cloak>
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Detail Publikasi</h2>
            <p><strong>Kode:</strong> <span x-text="selectedData.kode"></span></p>
            <p><strong>Tanggal:</strong> <span x-text="selectedData.tanggal"></span></p>
            <p><strong>Nama:</strong> <span x-text="selectedData.nama"></span></p>
            <p><strong>Jenis:</strong> <span x-text="selectedData.jenis"></span></p>
            <p><strong>Unit:</strong> <span x-text="selectedData.unit"></span></p>
            <p><strong>Sub Unit:</strong> <span x-text="selectedData.subUnit"></span></p> 
            <p><strong>Tautan:</strong> <a class="text-blue-500 underline" :href="selectedData.tautan" target="_blank" x-text="selectedData.tautan"></a></p>
            <div class="mt-4 text-right">
                <button class="bg-red-500 text-white px-4 py-2 rounded" @click="modalOpen = false">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function riwayatPublikasi() {
    return {
        search: '',
        selectedJenis: '',
        sortOrder: '',
        modalOpen: false,
        selectedData: {},
        currentPage: 1,
        pageSize: 10,
        selectedPeriod: '',
        originalData: [
            { id: 1, kode: 'PUB001', tanggal: '2025-04-01', nama: 'Bakti Sosial', unit: 'Humas', subUnit: 'Media', jenis: 'Liputan', tautan: 'https://example.com/1' },
            { id: 2, kode: 'PUB002', tanggal: '2025-04-03', nama: 'Hari Pendidikan', unit: 'Akademik', subUnit: 'Kurikulum', jenis: 'Promosi', tautan: 'https://example.com/2' },
            { id: 3, kode: 'PUB003', tanggal: '2025-04-05', nama: 'Seminar Teknologi', unit: 'IT', subUnit: 'DevOps', jenis: 'Liputan', tautan: 'https://example.com/3' },
            { id: 4, kode: 'PUB004', tanggal: '2025-04-07', nama: 'Pelatihan Kepemimpinan', unit: 'Kemahasiswaan', subUnit: 'BEM', jenis: 'Promosi', tautan: 'https://example.com/4' },
            { id: 5, kode: 'PUB005', tanggal: '2025-04-10', nama: 'Lomba Desain', unit: 'IT', subUnit: 'Design', jenis: 'Promosi', tautan: 'https://example.com/5' },
            { id: 6, kode: 'PUB006', tanggal: '2025-04-12', nama: 'Workshop UI/UX', unit: 'IT', subUnit: 'Design', jenis: 'Liputan', tautan: 'https://example.com/6' },
            { id: 7, kode: 'PUB007', tanggal: '2025-04-14', nama: 'Pameran Kampus', unit: 'Humas', subUnit: 'Publikasi', jenis: 'Promosi', tautan: 'https://example.com/7' },
            { id: 8, kode: 'PUB008', tanggal: '2025-04-16', nama: 'Buka Puasa Bersama', unit: 'Kemahasiswaan', subUnit: 'Rohani', jenis: 'Liputan', tautan: 'https://example.com/8' },
            { id: 9, kode: 'PUB009', tanggal: '2025-04-18', nama: 'Pelatihan Jurnalistik', unit: 'Humas', subUnit: 'Media', jenis: 'Liputan', tautan: 'https://example.com/9' },
            { id: 10, kode: 'PUB010', tanggal: '2025-04-20', nama: 'Webinar AI', unit: 'IT', subUnit: 'AI Lab', jenis: 'Promosi', tautan: 'https://example.com/10' },
            { id: 11, kode: 'PUB011', tanggal: '2025-03-01', nama: 'Seminar Kewirausahaan', unit: 'Akademik', subUnit: 'Entrepreneurship', jenis: 'Promosi', tautan: 'https://example.com/11' },
            { id: 12, kode: 'PUB012', tanggal: '2025-03-03', nama: 'Diskusi Teknologi', unit: 'IT', subUnit: 'AI Lab', jenis: 'Liputan', tautan: 'https://example.com/12' },
            { id: 13, kode: 'PUB013', tanggal: '2025-03-05', nama: 'Pelatihan Leadership', unit: 'Kemahasiswaan', subUnit: 'BEM', jenis: 'Promosi', tautan: 'https://example.com/13' },
            { id: 14, kode: 'PUB014', tanggal: '2025-03-07', nama: 'Hackathon Nasional', unit: 'IT', subUnit: 'Innovation', jenis: 'Liputan', tautan: 'https://example.com/14' },
            { id: 15, kode: 'PUB015', tanggal: '2025-03-09', nama: 'Pameran Teknologi', unit: 'Humas', subUnit: 'Media', jenis: 'Liputan', tautan: 'https://example.com/15' },
            { id: 16, kode: 'PUB016', tanggal: '2025-03-11', nama: 'Webinar Kewirausahaan', unit: 'Akademik', subUnit: 'Entrepreneurship', jenis: 'Promosi', tautan: 'https://example.com/16' },
        ],
        get filteredData() {
            let filtered = this.originalData.filter(item => {
                return (
                    (this.search === '' || item.nama.toLowerCase().includes(this.search.toLowerCase())) &&
                    (this.selectedJenis === '' || item.jenis === this.selectedJenis) &&
                    (this.selectedPeriod === '' || this.isInPeriod(item.tanggal))
                );
            });

            if (this.sortOrder) {
                filtered = filtered.sort((a, b) => {
                    return this.sortOrder === 'asc'
                        ? new Date(a.tanggal) - new Date(b.tanggal)
                        : new Date(b.tanggal) - new Date(a.tanggal);
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
        isInPeriod(date) {
            const currentDate = new Date();
            const publicationDate = new Date(date);
            const diffInMonths = (currentDate.getFullYear() - publicationDate.getFullYear()) * 12 + currentDate.getMonth() - publicationDate.getMonth();

            if (this.selectedPeriod === '1' && diffInMonths <= 1) return true;
            if (this.selectedPeriod === '2' && diffInMonths <= 2) return true;
            if (this.selectedPeriod === '3' && diffInMonths <= 3) return true;

            return false;
        },
        resetFilter() {
            this.search = '';
            this.selectedJenis = '';
            this.sortOrder = '';
            this.selectedPeriod = '';
        },
        exportData() {
            const filtered = this.filteredData;
            const csvData = this.convertToCSV(filtered);
            this.downloadCSV(csvData);
        },

        convertToCSV(data) {
            const header = ['Kode', 'Jenis', 'Tanggal', 'Nama', 'Unit', 'Sub Unit', 'Tautan'];
            const rows = data.map(item => [
                item.kode, item.jenis, item.tanggal, item.nama, item.unit, item.subUnit, item.tautan
            ]);

            const csvContent = [header, ...rows]
                .map(row => row.join(','))
                .join('\n');

            return csvContent;
        },

        downloadCSV(content) {
            const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'riwayat_publikasi.csv');
                link.click();
            }
        }
    }
}
</script>
@endsection
