@extends('template.staff.main-staff')
@section('title', 'Daftar Sub Unit')

@section('content')
    <div x-data="subUnitPage()" class="p-4 bg-white rounded shadow">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Daftar Sub Unit {{ $unit->nama_unit }}</h2>

            <div class="flex flex-col items-start gap-2 mb-4">
                <a href="" @click.prevent="addSubUnit()"
                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                    + Tambah
                </a>

                <input type="text" x-model="search" placeholder="Cari nama sub unit..."
                    class="form-input bg-gray-100 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-900 w-full sm:w-1/2 md:w-1/3">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto border text-sm text-center">
                    <thead class="bg-gray-100 text-green-700 font-semibold">
                        <tr>
                            <th class="border px-2 py-2 cursor-pointer text-left"
                                @click="sortAsc = sortKey === 'nama_sub_unit' ? !sortAsc : true; sortKey = 'nama_sub_unit'">
                                Nama Sub Unit
                                <template x-if="sortKey === 'nama_sub_unit'">
                                    <span x-text="sortAsc ? '↑' : '↓'" class="ml-1 text-xs"></span>
                                </template>
                            </th>

                            <th class="border px-2 py-2">Deskripsi</th>
                            <th class="border px-2 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="sub in paginatedData" :key="sub.id_sub_unit">
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="border px-2 py-2 text-left" x-text="sub.nama_sub_unit"></td>
                                <td class="border px-2 py-2 text-left" x-text="sub.deskripsi"></td>
                                <td class="border px-2 py-2">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1">
                                        <a href="" @click.prevent="editSubUnit(sub)"
                                            class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 w-full sm:w-auto text-center">Edit</a>
                                        <a href="" @click.prevent="deleteSubUnit(sub)"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-full sm:w-auto text-center">Delete</a>
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
        function subUnitPage() {
            return {
                search: '',
                currentPage: 1,
                pageSize: 20,
                sortKey: 'nama_sub_unit',
                sortAsc: true,
                subunits: @json($subUnits),
                selectedData: {},
                originalData: [],

                init() {
                    this.originalData = [...this.subunits];
                },

                get sortedData() {
                    let data = [...this.subunits];

                    if (this.search) {
                        data = data.filter(sub =>
                            sub.nama_sub_unit.toLowerCase().includes(this.search.toLowerCase())
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
                addSubUnit() {
                    Swal.fire({
                        title: 'Tambah Sub Unit',
                        html: `
                            <div style="text-align: left;">
                                <label for="nama_sub_unit" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Sub Unit *</label>
                                <input id="nama_sub_unit" class="swal2-input m-0 p-0 w-full" placeholder="Nama Sub Unit">
                                <label for="deskripsi" style="display: block; margin-top: 10px; font-weight: bold;">Deskripsi</label>
                                <textarea id="deskripsi" class="swal2-textarea m-0 p-0 w-full" placeholder="Deskripsi"></textarea>
                            </div>
                        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Simpan',
                        preConfirm: () => {
                            const nama = $('#nama_sub_unit').val().trim();
                            const desk = $('#deskripsi').val().trim();
                            if (!nama) {
                                Swal.showValidationMessage('Nama Sub Unit tidak boleh kosong');
                                return false;
                            }
                            return {
                                nama_sub_unit: nama,
                                deskripsi: desk
                            };
                        }
                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('staff.api.post.sub-unit') }}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id_unit: '{{ $unit->id_unit }}',
                                    ...result.value
                                },
                                beforeSend: () => {
                                    Swal.fire({
                                        title: 'Menyimpan...',
                                        allowOutsideClick: false,
                                        didOpen: () => Swal.showLoading()
                                    });
                                },
                                success: response => {
                                    localStorage.setItem('subunit_message', response.message);
                                    window.location.reload();
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

                editSubUnit(sub) {
                    Swal.fire({
                        title: 'Edit Sub Unit',
                        html: `
                            <div style="text-align: left;">
                                <label for="nama_sub_unit" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Sub Unit *</label>
                                <input id="nama_sub_unit" class="swal2-input m-0 p-0 w-full" value="${sub.nama_sub_unit}" placeholder="Nama Sub Unit">
                                <label for="deskripsi" style="display: block; margin-top: 10px; font-weight: bold;">Deskripsi</label>
                                <textarea id="deskripsi" class="swal2-textarea m-0 p-0 w-full" placeholder="Deskripsi">${sub.deskripsi}</textarea>
                            </div>
                        `,
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Update',
                        preConfirm: () => {
                            const nama = $('#nama_sub_unit').val().trim();
                            const desk = $('#deskripsi').val().trim();
                            if (!nama) {
                                Swal.showValidationMessage('Nama Sub Unit tidak boleh kosong');
                                return false;
                            }
                            return {
                                nama_sub_unit: nama,
                                deskripsi: desk
                            };
                        }
                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('staff.api.update.sub-unit') }}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id_sub_unit: sub.id_sub_unit,
                                    ...result.value
                                },
                                beforeSend: () => {
                                    Swal.fire({
                                        title: 'Mengupdate...',
                                        allowOutsideClick: false,
                                        didOpen: () => Swal.showLoading()
                                    });
                                },
                                success: response => {
                                    localStorage.setItem('subunit_message', response.message);
                                    window.location.reload();
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

                deleteSubUnit(sub) {
                    Swal.fire({
                        title: 'Hapus Sub Unit?',
                        text: `Yakin ingin menghapus sub unit "${sub.nama_sub_unit}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('staff.api.delete.sub-unit') }}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    id_sub_unit: sub.id_sub_unit
                                },
                                beforeSend: () => {
                                    Swal.fire({
                                        title: 'Menghapus...',
                                        allowOutsideClick: false,
                                        didOpen: () => Swal.showLoading()
                                    });
                                },
                                success: response => {
                                    localStorage.setItem('subunit_message', response.message);
                                    window.location.reload();
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
                }

            }
        }
    </script>
@endsection
