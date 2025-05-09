@extends('template.umum.main-umum')
@section('title', 'Home')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
    <style>
        .kode-lacak-container {
            background-color: #d5e4d9;
            border-left: 6px solid #28a745;
            padding: 10px;
            margin: 20px 0;
            font-size: 1.2em;
        }

        .kode-lacak-container:hover {
            text-decoration: underline;
        }

        .kode-lacak {
            color: #000000;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @if ($data['status'] == 'success')
        <main class="container mx-auto px-4 sm:px-2 py-4 flex-grow">
            <div class="flex items-center justify-center py-6 bg-white text-center px-4">
                <div class="max-w-md border-4 border-solid p-4 rounded-lg">
                    <h1 class="text-xl font-semibold text-black mb-6">
                        Permohonan Publikasi {{ $data['publikasi'] }} Anda Berhasil Diajukan !
                    </h1>

                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 rounded-full border-[6px] border-green-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <p class="text-black text-base">Kode lacak permohonan Anda adalah : </p>
                    <div class="kode-lacak-container">
                        <p class="kode-lacak" style="cursor: pointer;">{{ $data['id_proses_permohonan'] }}</p>
                    </div>
                    <p class="text-black text-base">
                        atau silahkan cek inbox atau folder spam email anda untuk mendapatkan kode permohonan.
                    </p>
                    <p class="text-black text-base">
                        Pantau proses publikasi Anda di menu
                        <a href="" class="underline font-medium text-black">Lacak</a>.
                    </p>
                </div>

            </div>
        </main>
    @elseif($data['status'] == 'error')
        <main class="container mx-auto px-4 sm:px-2 py-4 flex-grow">
            <div class="flex items-center justify-center py-6 bg-white text-center px-4">
                <div class="max-w-md border-4 border-solid border-red-500 p-4 rounded-lg">
                    <h1 class="text-xl font-semibold text-black mb-6">
                        Permohonan Publikasi Tidak Dapat Diverifikasi
                    </h1>

                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 rounded-full border-[6px] border-red-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>

                    <p class="text-black text-base mb-2">
                        Mohon maaf, Anda sudah melebihi batas waktu verifikasi permohonan atau permohonan sedang tidak dapat
                        diproses saat ini.
                    </p>
                    <p class="text-black text-base">
                        Silakan coba kembali atau hubungi staff Biro 4 jika masalah terus berlanjut.
                    </p>
                </div>
            </div>
        </main>
    @endif
@endsection

@section('script')
    @if ($data['status'] == 'success')
        <script src="{{ asset('js/swal.js') }}" defer></script>
        <script src="{{ asset('js/notification.js') }}" defer></script>
        <script>
            $(document).ready(function() {
                $('.kode-lacak').on('click', function() {
                    var text = $(this).text().trim();

                    // Buat elemen input temporer
                    var tempInput = $('<input>');
                    $('body').append(tempInput);
                    tempInput.val(text).select();
                    document.execCommand('copy');
                    tempInput.remove();

                    alert.fire({
                        icon: 'success',
                        title: 'Kode berhasil di salin ke clipboard',
                    });
                });
            });
        </script>
    @endif
@endsection
