@extends('template.staff.main-staff')
@section('title', 'Daftar Unit')

@section('content')
    <div x-data="unitPage()" class="p-6 bg-white rounded shadow">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Daftar Unit</h2>

            <div class="flex flex-col items-start gap-2 mb-4">
                <a href="" @click.prevent="addUnit"
                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                    + Tambah
                </a>

                <input type="text" x-model="search" placeholder="Cari nama unit..."
                    class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900 w-full sm:w-1/2 md:w-1/3">
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-separate border-spacing-y-1 text-md text-center">
                    <thead class="bg-gray-100 text-green-700 font-semibold">
                        <tr>
                            <th class="border border-gray-300 py-2 px-2 cursor-pointer text-center"
                                @click="sortAsc = sortKey === 'nama_unit' ? !sortAsc : true; sortKey = 'nama_unit'">
                                Nama Unit
                                <template x-if="sortKey === 'nama_unit'">
                                    <span x-text="sortAsc ? '↑' : '↓'" class="ml-1 text-xs"></span>
                                </template>
                            </th>

                            <th class="border border-gray-300 py-2 px-2">Deskripsi</th>
                            <th class="border border-gray-300 py-2 px-2">Sub Unit</th>
                            <th class="border border-gray-300 py-2 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="unit in paginatedData" :key="unit.id_unit">
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="border border-gray-300 py-2 px-2 text-left" x-text="unit.nama_unit"></td>
                                <td class="border border-gray-300 py-2 px-2 text-left" x-text="unit.deskripsi"></td>
                                <td class="border border-gray-300 py-2 px-2">
                                    <a :href="unit.detail_url"
                                        class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-900">
                                        Detail
                                    </a>

                                </td>
                                <td class="border px-2 py-2">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1">
                                        <a href="" @click.prevent="editUnit(unit)"
                                            class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500 w-full sm:w-auto text-center">Edit</a>
                                        <a href="" @click.prevent="deleteUnit(unit)"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-full sm:w-auto text-center">Hapus</a>

                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="paginatedData.length === 0">
                            <tr>
                                <td colspan="4" class="text-gray-500 py-4">Data tidak ditemukan.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            <div class="mt-8 flex flex-wrap justify-center gap-2 text-sm sm:text-base">
                <button :disabled="currentPage === 1" @click="currentPage = 1"
                    :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">&laquo;</button>

                <button :disabled="currentPage === 1" @click="currentPage--"
                    :class="currentPage === 1 ? 'bg-gray-300 text-gray-600' : 'bg-green-700 text-white hover:bg-blue-700'"
                    class="px-3 py-1 rounded">Prev</button>

                <template x-for="page in totalPages" :key="page">
                    <button @click="currentPage = page"
                        :class="currentPage === page ? 'bg-blue-100 text-yellow-700 hover:bg-blue-200' :
                            'bg-green-700 text-white hover:bg-blue-700'"
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
        function unitPage() {
            return {
                search: '',
                selectedData: {},
                currentPage: 1,
                pageSize: 20,
                originalData: [],
                sortKey: 'nama_unit',
                sortAsc: true,

                async init() {
                    try {
                        const response = await fetch(' {{ route('staff.api.get.unit') }}');
                        const data = await response.json();
                        this.originalData = data.map(unit => ({
                            detail_url: unit.detail_url,
                            id_unit: unit.id_unit,
                            nama_unit: unit.nama_unit,
                            deskripsi: unit.deskripsi,
                        }));
                    } catch (error) {
                        console.error('Error fetching units:', error);
                    }
                },

                get filteredData() {
                    if (!this.search) return this.units;
                    return this.units.filter(unit =>
                        unit.nama_unit.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                get sortedData() {
                    let data = [...this.originalData];

                    if (this.search) {
                        data = data.filter(unit =>
                            unit.nama_unit.toLowerCase().includes(this.search.toLowerCase())
                        );
                    }

                    data.sort((a, b) => {
                        const valA = a[this.sortKey]?.toLowerCase?.() || '';
                        const valB = b[this.sortKey]?.toLowerCase?.() || '';
                        if (valA < valB) return this.sortAsc ? -1 : 1;
                        if (valA > valB) return this.sortAsc ? 1 : -1;
                        return 0;
                    });

                    return data;
                },

                get totalPages() {
                    return Math.ceil(this.sortedData.length / this.pageSize) || 1;
                },

                get paginatedData() {
                    const start = (this.currentPage - 1) * this.pageSize;
                    const end = start + this.pageSize;
                    return this.sortedData.slice(start, end);
                },

                resetFilter() {
                    this.search = '';
                    this.currentPage = 1;
                },

                addUnit() {
                    Swal.fire({
                        title: 'Tambah Unit Baru',
                        html: `
                        <div style="text-align: left;">
                            <label for="nama_unit" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Unit *</label>
                            <input id="nama_unit" class="swal2-input m-0 p-0 w-full" placeholder="Nama Unit">
                            <label for="deskripsi" class="pt-2" style="display: block; margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Deskripsi</label>
                            <textarea id="deskripsi" class="swal2-textarea m-0 p-0 w-full" placeholder="Deskripsi"></textarea>
                        </div>
                        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Simpan',
                        preConfirm: () => {
                            const nama_unit = $('#nama_unit').val().trim();
                            const deskripsi = $('#deskripsi').val().trim();

                            if (!nama_unit) {
                                Swal.showValidationMessage('Nama Unit tidak boleh kosong');
                                return false;
                            }

                            return {
                                nama_unit,
                                deskripsi
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('staff.api.post.unit') }}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    nama_unit: result.value.nama_unit,
                                    deskripsi: result.value.deskripsi
                                },
                                beforeSend: function() {
                                    Swal.fire({
                                        title: 'Loading',
                                        text: 'Permintaan Anda sedang diproses...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                },
                                success: (response) => {
                                    localStorage.setItem('unit_message', response.message);
                                    window.location.href = "{{ route('staff.unit') }}";
                                },
                                error: function(xhr) {
                                    let message =
                                        'Terjadi kesalahan. Silakan coba lagi.';
                                    if (xhr.responseJSON
                                        ?.error) {
                                        message = xhr
                                            .responseJSON
                                            .error;
                                    } else if (xhr
                                        .responseJSON
                                        ?.errors) {
                                        message = Object
                                            .values(xhr
                                                .responseJSON
                                                .errors)
                                            .flat()
                                            .join('\n');
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
                    });
                },

                editUnit(unit) {
                    Swal.fire({
                        title: 'Edit Unit',
                        html: `
                        <div style="text-align: left;">
                            <label for="nama_unit" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Unit *</label>
                            <input id="nama_unit" class="swal2-input m-0 p-0 w-full" value="${unit.nama_unit}" placeholder="Nama Unit">
                            <label for="deskripsi" class="pt-2" style="display: block; margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Deskripsi</label>
                            <textarea id="deskripsi" class="swal2-textarea m-0 p-0 w-full" placeholder="Deskripsi">${unit.deskripsi}</textarea>
                        </div>
                        `,
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            const nama_unit = $('#nama_unit').val().trim();
                            const deskripsi = $('#deskripsi').val().trim();

                            if (!nama_unit) {
                                Swal.showValidationMessage('Nama Unit tidak boleh kosong');
                                return false;
                            }

                            return {
                                nama_unit,
                                deskripsi
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `{{ route('staff.api.update.unit') }}`,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id_unit: unit.id_unit,
                                    nama_unit: result.value.nama_unit,
                                    deskripsi: result.value.deskripsi
                                },
                                beforeSend: function() {
                                    Swal.fire({
                                        title: 'Loading',
                                        text: 'Permintaan Anda sedang diproses...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                },
                                success: (response) => {
                                    localStorage.setItem('unit_message', response.message);
                                    window.location.href = "{{ route('staff.unit') }}";
                                },
                                error: function(xhr) {
                                    let message =
                                        'Terjadi kesalahan. Silakan coba lagi.';
                                    if (xhr.responseJSON
                                        ?.error) {
                                        message = xhr
                                            .responseJSON
                                            .error;
                                    } else if (xhr
                                        .responseJSON
                                        ?.errors) {
                                        message = Object
                                            .values(xhr
                                                .responseJSON
                                                .errors)
                                            .flat()
                                            .join('\n');
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
                    });
                },

                deleteUnit(unit) {
                    Swal.fire({
                        title: 'Hapus Unit?',
                        text: `Yakin ingin menghapus unit "${unit.nama_unit}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `{{ route('staff.api.delete.unit') }}`,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id_unit: unit.id_unit
                                },
                                beforeSend: function() {
                                    Swal.fire({
                                        title: 'Loading',
                                        text: 'Permintaan Anda sedang diproses...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                },
                                success: (response) => {
                                    localStorage.setItem('unit_message', response.message);
                                    window.location.href = "{{ route('staff.unit') }}";
                                },
                                error: function(xhr) {
                                    let message =
                                        'Terjadi kesalahan. Silakan coba lagi.';
                                    if (xhr.responseJSON
                                        ?.error) {
                                        message = xhr
                                            .responseJSON
                                            .error;
                                    } else if (xhr
                                        .responseJSON
                                        ?.errors) {
                                        message = Object
                                            .values(xhr
                                                .responseJSON
                                                .errors)
                                            .flat()
                                            .join('\n');
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
                    });
                },
            }
        }
    </script>
@endsection
