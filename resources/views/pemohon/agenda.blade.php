@extends('template.pemohon.main-pemohon')

@section('title', 'Home')

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

        #calendar {
            padding: 24px;
            margin: 24px 0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col max-w-7xl mx-auto w-full items-center bg-white p-8 sm:p-2">

            <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Agenda Publikasi</h1>

            <div id="calendar" class="border border-gray-300  w-full min-h-[600px] p-0 mb-6"></div>
            <hr class="h-px my-3 bg-gray-800 border-0 dark:bg-gray-700 w-full">
            <p class="text-sm text-gray-600 w-full">
                <span class="font-semibold mb-2 block">Keterangan :</span>
                <span class="bg-hijau text-white px-2 py-1 rounded-md mb-2 inline-block">Liputan</span> : Hari
                Pelaksanaan Kegiatan Publikasi Liputan. <br>
                <span class="bg-kuning text-white px-2 py-1 rounded-md mb-2 inline-block">Promosi</span> : Hari
                Pelaksanaan Kegiatan Publikasi Promosi. <br>
                <span class="bg-ungu text-white px-2 py-1 rounded-md mb-2 inline-block">Liputan & Promosi</span> : Hari
                Pelaksanaan Kegiatan Publikasi Liputan dan Promosi.
            </p>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/calendar_v2.core.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            const today = '{{ \Carbon\Carbon::now()->format('Y-m-d') }}';

            $.ajax({
                url: "{{ route('api.get.tanggal-jadwal') }}",
                method: 'GET',
                dataType: 'json',
                success: function(tanggalList) {
                    // Grupkan tanggal dan jenis
                    const groupedByTanggal = {};
                    tanggalList.forEach(item => {
                        groupedByTanggal[item.tanggal] = groupedByTanggal[item.tanggal] || [];
                        groupedByTanggal[item.tanggal].push(item.jenis);
                    });

                    // Tentukan warna kalender
                    const popups = {};
                    Object.entries(groupedByTanggal).forEach(([tanggal, jenisList]) => {
                        const jenisUnik = [...new Set(jenisList)];
                        let modifier = jenisUnik.length > 1 ?
                            'bg-ungu' :
                            (jenisUnik[0] === 'Liputan' ? 'bg-hijau' : 'bg-kuning');
                        popups[tanggal] = {
                            modifier
                        };
                    });

                    // Inisialisasi kalender
                    const calendar = new VanillaCalendar('#calendar', {
                        settings: {
                            selection: {
                                day: 'single'
                            },
                            visibility: {
                                daysOutside: false
                            }
                        },
                        popups,
                        actions: {
                            clickDay(event, self) {
                                const selectedDate = self.selectedDates[0];
                                if (!selectedDate) return;

                                const [year, month, day] = selectedDate.split('-');
                                const formattedForCompare = `${day}-${month}-${year}`;
                                const formattedForDisplay = `${day}-${month}-${year}`;

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
                                    beforeSend() {
                                        Swal.fire({
                                            title: 'Loading',
                                            text: 'Memuat Jadwal...',
                                            allowOutsideClick: false,
                                            didOpen: () => Swal.showLoading()
                                        });
                                    },
                                    success(data) {
                                        const filteredData = data.filter(item => item
                                            .tanggal === formattedForCompare);

                                        if (filteredData.length === 0) {
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Tidak ada jadwal',
                                                text: `Tidak ada kegiatan pada tanggal ${formattedForDisplay}.`
                                            });
                                            return;
                                        }

                                        const liputanList = filteredData.filter(i => i
                                            .jenis === 'Liputan');
                                        const promosiList = filteredData.filter(i => i
                                            .jenis === 'Promosi');

                                        function renderSection(judul, list) {
                                            if (!list.length) return '';
                                            const bg = judul === 'Liputan' ? '#d0f0c0' :
                                                '#fff9c4';
                                            const color = judul === 'Liputan' ?
                                                '#256029' : '#8a6d00';

                                            let html = `
                                        <h3 style="
                                            font-size: 20px;
                                            font-weight: 700;
                                            margin: 20px 0 15px;
                                            color: ${color};
                                            text-align: center;
                                            background-color: ${bg};
                                            padding: 8px 0;
                                            border-radius: 6px;
                                            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
                                        ">${judul}</h3>
                                    `;
                                            list.forEach(item => {
                                                const statusClass = item
                                                    .status === 'Diproses' ?
                                                    'text-yellow-600' :
                                                    'text-red-600';
                                                html += `
                                            <div style="
                                                border: 1px solid #e0e0e0;
                                                border-radius: 8px;
                                                padding: 12px 16px;
                                                margin-bottom: 12px;
                                                background-color: #f8f9fa;
                                                box-shadow: 1px 1px 5px rgba(0,0,0,0.05);
                                            ">
                                                <div class="font-bold text-2xl">${item.nama}</div>
                                                <div class="${statusClass} text-sm mt-1 font-semibold text-xl">${item.status}</div>
                                                <div style="margin-top: 6px;">
                                                    <strong>Tempat:</strong> ${item.tempat}<br>
                                                    <strong>Tanggal:</strong> ${item.tanggal}
                                                    ${item.jam ? ` - ${item.jam}` : ''}
                                                </div>
                                            </div>
                                        `;
                                            });
                                            return html;
                                        }

                                        Swal.fire({
                                            title: `Jadwal Tanggal ${formattedForDisplay}`,
                                            html: `
                                        <div style="text-align:left; max-height:400px; overflow-y:auto;">
                                            ${renderSection('Liputan', liputanList)}
                                            ${renderSection('Promosi', promosiList)}
                                        </div>
                                    `,
                                            width: 700,
                                            confirmButtonText: 'Tutup',
                                            confirmButtonColor: '#6c757d',
                                        });
                                    },
                                    error(xhr) {
                                        let message =
                                            'Terjadi kesalahan. Silakan coba lagi.';
                                        if (xhr.responseJSON?.error) message = xhr
                                            .responseJSON.error;
                                        else if (xhr.responseJSON?.errors) message =
                                            Object.values(xhr.responseJSON.errors)
                                            .flat().join('\n');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: message,
                                            timer: 7000
                                        });
                                    }
                                });
                            }
                        }
                    });

                    calendar.init();
                },
                error(xhr) {
                    let message = 'Gagal mengambil daftar tanggal. Silakan coba lagi.';
                    if (xhr.responseJSON?.error) message = xhr.responseJSON.error;
                    else if (xhr.responseJSON?.errors) message = Object.values(xhr.responseJSON.errors)
                        .flat().join('\n');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: message,
                        timer: 7000
                    });
                }
            });
        });
    </script>
@endsection
