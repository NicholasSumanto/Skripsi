@extends('template.pemohon.main-pemohon')

@section('title', 'Home')

@section('custom-header')
    <link rel="stylesheet"href="{{ asset('css/calendar.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
    <style>
        .bg-hijau {
            background-color: #28a745 !important;
        }

        .bg-kuning {
            background-color: #ffc107 !important;
        }

        .bg-ungu {
            background-color: #6f42c1 !important;
        }
    </style>
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col max-w-7xl mx-auto w-full items-center bg-white p-8 sm:p-2">

            <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Agenda Publikasi</h1>

            <div id="calendar" class="w-full min-h-[400px] p-0 mb-12"></div>
        </div>
    </main>
@endsection

@section('script')
    <!-- JS Addon -->
    <script src="{{ asset('js/calendar.core.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            const {
                Calendar
            } = window.VanillaCalendarPro;
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

                    const calendar = new Calendar('#calendar', {
                        settings: {
                            selection: {
                                day: 'single',
                            },
                            visibility: {
                                daysOutside: false,
                            },
                            range: {
                                min: today,
                            },
                        },
                        popups: popups,
                        onClickDate(self) {
                            const selectedDate = self.context.selectedDates[0];
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

                                        const liputanList = data.filter(item => item
                                            .jenis === 'Liputan');
                                        const promosiList = data.filter(item => item
                                            .jenis === 'Promosi');

                                        function renderSection(judul, list) {
                                            if (list.length === 0) return '';

                                            let sectionHTML =
                                                `<h3 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #444;">${judul}</h3>`;

                                            list.forEach((item, index) => {
                                                const statusClass = item
                                                    .status === 'Diproses' ?
                                                    'text-yellow-600' :
                                                    'text-red-600';

                                                const hariPelaksanaan = item
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
@endsection
