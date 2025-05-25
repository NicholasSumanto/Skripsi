@extends('template.pemohon.main-pemohon')

@section('title', 'Lacak')

@section('content')
    <main class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center text-[#1E285F] mb-10 leading-tight">
            Lacak Status<br>Publikasi Kegiatan
        </h1>
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg">

            {{-- Form Input Kode Kegiatan --}}
            <section class="bg-[#C4C4C4] rounded-t-lg pt-6">
                <h2 class="text-xl font-semibold text-black text-center mb-4">Kode Lacak Publikasi</h2>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6 mx-2" method="GET"
                    action="{{ route('pemohon.lacak') }}">
                    <input id="kode_proses" name="kode_proses" type="text" placeholder="Masukkan kode"
                        class="rounded-full w-full max-w-[280px] py-2 px-6 text-sm placeholder:text-[#999] focus:outline-none"
                        value="{{ isset($id_proses_permohonan) ? $id_proses_permohonan : (isset($publikasi->id_proses_permohonan) ? $publikasi->id_proses_permohonan : '') }}" />
                    <button type="submit"
                        class="bg-[#FFC107] text-black rounded-full px-6 py-2 text-sm font-semibold hover:bg-yellow-400 transition">
                        Cari
                    </button>
                </form>

                {{-- Tabel Informasi Kegiatan --}}
                <div class="overflow-x-auto">
                    <table class="w-full bg-[#0B4D1E] text-sm text-center">
                        <thead>
                            <tr class="font-semibold text-[#FFC107]">
                                <th class="py-4 px-3">Kode Publikasi</th>
                                <th class="py-4 px-3">Nama Pemohon</th>
                                <th class="py-4 px-3">Nama Publikasi</th>
                                <th class="py-4 px-3">Tanggal/Waktu</th>
                                <th class="py-4 px-3">Unit</th>
                                <th class="py-4 px-3">Sub Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="font-semibold  border-[#0B4D1E] text-[#D9D9D9]">
                                <td class="pb-4 px-3">{{ $publikasi->id_proses_permohonan }}</td>
                                <td class="pb-4 px-3">{{ $publikasi->nama_pemohon }}</td>
                                <td class="pb-4 px-3">{{ $publikasi->judul }}</td>
                                <td class="pb-4 px-3">
                                    {{ \Carbon\Carbon::parse($publikasi->tanggal)->format('d/m/Y') }}
                                    {!! isset($publikasi->waktu) ? '<br>' . \Carbon\Carbon::parse($publikasi->waktu)->Format('H:i') : '' !!}
                                </td>
                                <td class="pb-4 px-3">{{ $publikasi->nama_unit }}</td>
                                <td class="pb-4 px-3">{{ $publikasi->nama_sub_unit }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Status Proses --}}
            <section class="bg-primary rounded-b-lg px-6 pb-10 pt-4 relative overflow-hidden">
                <h2 class="text-lg font-semibold mb-6 text-white text-center md:text-left">Status Permohonan Publikasi <span
                        class="text-sm px-3 py-1 rounded-full sm:mt-2 mt-0 sm:ms-2 ms-0 {{ $publikasi->jenis_publikasi == 'Liputan' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                        {{ $publikasi->jenis_publikasi }}
                    </span>
                </h2>
                @php
                    $steps = [
                        'Diajukan' => $publikasi->tanggal_diajukan,
                        'Diterima' => $publikasi->tanggal_diterima,
                        'Diproses' => $publikasi->tanggal_diproses,
                        'Selesai' => $publikasi->tanggal_selesai,
                    ];

                    $activeStep = $publikasi->status;
                    $stepReached = true;

                    // Dapatkan label langkah terakhir yang memiliki tanggal
                    $firstEmptyStepLabel = collect($steps)->filter(fn($v) => !$v)->keys()->first();

                    $afterCancelledStep = false;
                @endphp


                <div class="relative w-full max-w-4xl mx-auto px-4">
                    <!-- Garis -->
                    <div class="hidden sm:block absolute top-7 left-[100px] right-[100px] h-2 bg-white z-0"></div>
                    <div class="sm:hidden block absolute left-[47px] top-[0px] bottom-[30px] w-1 bg-white z-0">
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between gap-6 sm:gap-0 relative z-10">
                        @foreach ($steps as $label => $date)
                            {{-- Jika status Batal dan langkah ini adalah langkah yang dibatalkan, tampilkan ikon silang merah --}}
                            @if ($publikasi->status === 'Batal' && $label === $firstEmptyStepLabel)
                                @php $afterCancelledStep = true; @endphp
                                <div
                                    class="flex sm:flex-col flex-row sm:items-center items-start sm:w-1/4 w-full gap-4 sm:gap-0">
                                    <div
                                        class="w-16 h-16 mb-5 rounded-full flex items-center justify-center bg-red-600 text-white border-4 border-white">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="flex flex-col sm:items-center items-start text-white">
                                        <span class="text-lg font-semibold text-white">
                                            Dibatalkan
                                        </span>
                                        <span class="text-sm text-white/70 mt-1 leading-tight text-left sm:text-center">
                                            {!! str_replace(' ', '<br>', \Carbon\Carbon::parse($publikasi->tanggal_batal)->translatedFormat('l, d/m/Y')) !!}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @php
                                // Jika sudah lewat titik batal, semua langkah selanjutnya dianggap tidak dijalankan
                                $isAfterCancelled = $publikasi->status === 'Batal' && $afterCancelledStep;
                                $isActive = !$isAfterCancelled && $stepReached;
                                if ($label === $activeStep) {
                                    $stepReached = false;
                                }
                            @endphp

                            <div
                                class="flex sm:flex-col flex-row sm:items-center items-start sm:w-1/4 w-full gap-4 sm:gap-0">
                                <div
                                    class="w-16 h-16 mb-5 rounded-full flex items-center justify-center border-4 border-white
                                    @if ($isAfterCancelled) bg-gray-400 text-white
                                    @elseif ($isActive)
                                        bg-[#00FF6A] text-white
                                    @else
                                        bg-yellow-400 text-white @endif">
                                    <i
                                        class="@if ($isAfterCancelled) fas fa-times @elseif($isActive) fas fa-check @else far fa-clock @endif"></i>
                                </div>
                                <div class="flex flex-col sm:items-center items-start text-white">
                                    <span
                                        class="text-lg font-semibold {{ $isAfterCancelled ? 'text-white/60' : ($isActive ? 'text-white' : 'text-white/70') }}">
                                        {{ $label }}
                                    </span>
                                    @if ($date)
                                        <span class="text-sm text-white/70 mt-1 leading-tight text-left sm:text-center">
                                            {!! str_replace(' ', '<br>', \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y')) !!}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @php
                                // Kalau sudah tampilkan titik dibatalkan, maka semua langkah berikutnya harus dianggap tidak dikerjakan
                                if ($label === $firstEmptyStepLabel) {
                                    $afterCancelledStep = true;
                                }
                            @endphp
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Batalkan --}}
                @if ($isPemohon && $publikasi->status != 'Batal')
                    <div class="mt-8 text-right">
                        <button type="button"
                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-full px-6 py-2 shadow"
                            id="btn-batalkan" data-id_proses_permohonan="{{ $publikasi->id_proses_permohonan }}">
                            Batalkan Publikasi
                        </button>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection

@section('script')
    @if ($isPemohon && $publikasi->status != 'Batal')
        <script>
            $(document).ready(function() {
                $('#btn-batalkan').on('click', function() {
                    const id_proses_permohonan = $(this).data('id_proses_permohonan');

                    Swal.fire({
                        title: 'Batalkan Permohonan?',
                        html: `
                        <p>Anda membatalkan permohonan publikasi ini.</p>
                        <p><span class="text-red-500 font-bold">Tindakan ini tidak dapat dibatalkan.</span></p>
                        <textarea id="alasanBatal" class="swal2-textarea m-0 w-full mt-5" placeholder="Tuliskan alasan pembatalan" required></textarea>
                    `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Batalkan',
                        cancelButtonText: 'Tidak',
                        preConfirm: () => {
                            const keterangan = document.getElementById('alasanBatal').value.trim();
                            if (!keterangan) {
                                Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                            }
                            return keterangan;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const keterangan = result.value;

                            $.ajax({
                                type: "POST",
                                url: "{{ route('pemohon.api.delete.publikasi') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    keterangan: keterangan
                                },
                                beforeSend: function() {
                                    $('#btn-batalkan').text('Membatalkan...').attr(
                                        'disabled', true);

                                    Swal.fire({
                                        title: 'Loading',
                                        text: 'Permintaan Anda sedang diproses...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                },
                                success: function(res) {
                                    localStorage.setItem('batalkan_message', res.message);
                                    location.reload();
                                },
                                error: function(err) {
                                    $('#btn-batalkan').text('Batalkan Publikasi').attr(
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
    @endif
@endsection
