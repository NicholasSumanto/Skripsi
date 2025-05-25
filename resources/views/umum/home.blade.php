@extends('template.umum.main-umum')
@section('title', 'Home')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar_v2.core.css') }}">
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
        <div class="flex flex-col md:flex-row gap-12 max-w-10xl mx-auto w-full items-stretch">

            <!-- Bagian Kiri -->
            <div class="basis-1/3 bg-white p-8 sm:p-2 flex">
                <div class="flex flex-col justify-center h-full w-full">
                    <h2 class="text-3xl font-bold text-[#1a237e] mb-6 text-center md:text-left">Ada Kegiatan apa kali ini ?
                    </h2>
                    <button id="custom-google-button"
                        class="flex items-center space-x-2 border rounded-lg px-6 py-3 my-20 hover:bg-gray-50 shadow-sm w-full justify-center bg-white transition-colors">
                        <img src="{{ asset('img/g-logo.png') }}" alt="Google" class="h-5 w-5">
                        <span class="text-gray-700 font-medium">Sign in with Google</span>
                    </button>

                    <p class="mt-6 text-sm text-gray-600">
                        Untuk permohonan liputan atau promosi event di UKDW silahkan login menggunakan akun Gmail dengan
                        domain <span class="font-semibold">ukdw.ac.id</span>.
                    </p>
                </div>
            </div>

            <!-- Bagian Calendar -->
            <div class="basis-2/3 bg-white p-8 sm:p-2 flex flex-col justify-center">
                <h1 class="text-3xl font-bold mb-6 text-[#1a237e] text-center md:text-center">Agenda
                    Publikasi</h1>
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
                <hr class="h-px my-3 bg-gray-800 border-0 dark:bg-gray-700">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Catatan :</span> Untuk pengajuan permohonan liputan silahkan membuat surat
                    permohonan publikasi terlebih dahulu. Form permohonan publikasi terdapat di
                    <a href="{{ route('umum.unduhan') }}" class="text-primary hover:underline font-medium">Unduhan</a>
                </p>
            </div>
        </div>
        @if (isset($success) && $success)
            {{ $success }}
        @endif
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/calendar_v2.core.js') }}" defer></script>
    <!-- JS Addon -->
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

    <!-- Google Sign-In -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        let tokenClient;

        function initGoogle() {
            if (typeof google === 'undefined' || !google.accounts) {
                setTimeout(initGoogle, 100);
                return;
            }

            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: '1075024781552-t0m1uel41jr9h4tq4r5tg7ps6e0j0i8v.apps.googleusercontent.com',
                scope: 'email profile openid',
                callback: handleCredentialResponse,
            });

            $('#custom-google-button').on('click', function() {
                tokenClient.requestAccessToken();
            });
        }

        $(document).ready(function() {
            initGoogle();
        });

        function handleCredentialResponse(response) {
            const googleToken = response.access_token;

            $.ajax({
                url: "{{ route('google.callback') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    credential: googleToken,
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading',
                        text: 'Memproses login...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(res) {
                    localStorage.setItem('user_name', res.name);
                    window.location.href = res.redirect_to;
                },
                error: function(err) {
                    alert.fire({
                        icon: 'error',
                        title: err.responseJSON.error ?? err.responseJSON.message,
                    });
                }
            });
        }
    </script>
@endsection
