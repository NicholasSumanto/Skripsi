@extends('template.staff.main-staff')
@section('title', 'Detail Permohonan Liputan')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    <style>
        .container {
            width: 500px;
        }

        .entry:not(:first-of-type) {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Detail Permohonan Liputan</h1>
        <div class="max-w-4xl mx-auto bg-[#006034] text-[#FFCC29] rounded-xl shadow-xl p-10">
            <form id="form-liputan" class="space-y-6">
                <section class="bg-primary rounded-lg pb-6">
                    <h2 class="text-lg font-semibold mb-6 text-white text-center md:text-left px-6 pt-2">
                        Status Permohonan Publikasi
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
                    @endphp

                    <div class="relative w-full max-w-4xl mx-auto px-4">
                        <div class="hidden sm:block absolute top-7 left-[100px] right-[100px] h-2 bg-white z-0">
                        </div>
                        <div class="sm:hidden block absolute left-[47px] top-[0px] bottom-[30px] w-1 bg-white z-0">
                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-between gap-6 sm:gap-0 relative z-10">
                            @foreach ($steps as $label => $date)
                                @php
                                    $isActive = $stepReached;
                                    if ($label === $activeStep) {
                                        $stepReached = false;
                                    }
                                @endphp
                                <div
                                    class="flex sm:flex-col flex-row sm:items-center items-start sm:w-1/4 w-full gap-4 sm:gap-0">
                                    <div
                                        class="w-16 h-16 mb-5 rounded-full flex items-center justify-center
                                        {{ $isActive ? 'bg-[#00FF6A] text-white border-4 border-white' : 'bg-yellow-400 text-white border-4 border-white' }}">
                                        <i class="{{ $isActive ? 'fas fa-check' : 'far fa-clock' }}"></i>
                                    </div>
                                    <div class="flex flex-col sm:items-center items-start text-white">
                                        <span
                                            class="text-lg font-semibold {{ $isActive ? 'text-white' : 'text-white/70' }}">
                                            {{ $label }}
                                        </span>
                                        @if ($date)
                                            <span class="text-sm text-white/70 mt-1 leading-tight text-left sm:text-center">
                                                {!! str_replace(' ', '<br>', \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y')) !!}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon * :</label>
                        <input type="text" name="nama_pemohon" value="{{ $publikasi->nama_pemohon }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone * :</label>
                        <input type="text" name="nomor_handphone" value="{{ $publikasi->nomor_handphone }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" value="{{ $publikasi->email }}" disabled
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul * :</label>
                        <input type="text" name="judul" value="{{ $publikasi->judul }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan * :</label>
                        <input type="text" name="tempat" value="{{ $publikasi->tempat }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara * :</label>
                        <input type="date" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($publikasi->tanggal)->format('Y-m-d') }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Waktu * :</label>
                        <input type="time" name="waktu"
                            value="{{ \Carbon\Carbon::parse($publikasi->waktu)->format('H:i') }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Rundown dan TOR * :</label>
                        <div class="mt-2">
                            @php
                                $file = json_decode($publikasi->file_liputan, true);
                            @endphp

                            @if ($file[0] && $publikasi->status !== 'Batal')
                                <a href="{{ route('staff.api.get.file-liputan', ['id' => $publikasi->id_verifikasi_publikasi, 'filename' => $file[0]]) }}"
                                    target="_blank"
                                    class="inline-block bg-yellow-500 text-[#006034] font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-300 mb-2 mr-2">
                                    Lihat File
                                </a>
                            @else
                                <p class="text-white">Tidak ada file.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit * :</label>
                        <input type="text" name="unit" value="{{ $publikasi->nama_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit * :</label>
                        <input type="text" name="sub_unit" value="{{ $publikasi->nama_sub_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media? *</label>
                    <div class="mt-2">
                        @if ($publikasi->wartawan == 'Ya')
                            <span class="inline-block bg-green-500 text-white font-semibold py-2 px-4 rounded-full">
                                Ya
                            </span>
                        @else
                            <span class="inline-block bg-red-500 text-white font-semibold py-2 px-4 rounded-full">
                                Tidak
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Output * :</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @php
                            $outputList = json_decode($publikasi->output, true);
                        @endphp
                        @if (is_array($outputList))
                            @foreach ($outputList as $output)
                                <span
                                    class="inline-block bg-yellow-500 text-[#006034] font-semibold py-1 px-3 rounded-full">
                                    {{ ucfirst(trim($output)) }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-white">{{ ucfirst($publikasi->output) }}</span>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white"
                        rows="6" disabled>{{ $publikasi->catatan }}</textarea>
                </div>

                @if ($publikasi->status === 'Diproses')
                    <div class="space-y-2">
                        <label class="font-semibold text-lg text-yellow-400">Link Output<span class="text-red-500">*</span>
                            :</label>
                        <div class="control-form space-y-2">
                            <div class="entry flex overflow-hidden rounded-lg border border-gray-300">
                                <input type="text" name="link_output[]" class="flex-1 p-3 outline-none text-black"
                                    placeholder="https://...">
                                <button type="button"
                                    class="btn btn-add w-12 bg-green-500 hover:bg-green-600 text-white flex items-center justify-center">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-between mt-6">
                    <a href="{{ route('staff.home') }}" id="btn-kembali"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Kembali
                    </a>
                    {{-- Tombol --}}
                    <div class="mt-auto flex flex-col sm:flex-row items-center md:justify-end justify-center space-x-2">
                        @if ($publikasi->status === 'Diajukan')
                            <a href="#"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 btn-extras"
                                data-terima="{{ $publikasi->id_proses_permohonan }}">Diterima</a>
                        @elseif ($publikasi->status === 'Diterima')
                            <a href="#"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 btn-extras"
                                data-diproses="{{ $publikasi->id_proses_permohonan }}">Diproses</a>
                        @elseif ($publikasi->status === 'Diproses')
                            <a href="{{ route('staff.home') }}" id="btn-selesai"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                                Selesai
                            </a>
                        @endif
                        @if ($publikasi->status === 'Diajukan' || $publikasi->status === 'Diterima')
                            <a id="btn-batal" href="#"
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300"
                                data-batal="{{ $publikasi->id_proses_permohonan }}">
                                Batal
                            </a>
                        @else
                            <span
                                class="bg-gray-400 text-white font-semibold py-3 px-8 rounded-lg cursor-not-allowed opacity-70">
                                Batal
                            </span>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('script')
    @if ($publikasi->status !== 'Diproses')
        <script>
            $(document).ready(function() {
                // Konfirmasi pembatalan
                $('[data-batal]').on('click', function(e) {
                    e.preventDefault();
                    const id_proses_permohonan = $(this).data('batal');

                    Swal.fire({
                        title: 'Batalkan Permohonan?',
                        html: `
                        <p><span class="text-red-500 font-bold">Tindakan ini tidak dapat dibatalkan.</span></p><br>
                        <p>Mohon jelaskan alasan Anda agar pemohon dapat memahami keputusan tersebut.</p>
                        <p class="font-semibold text-left text-lg mt-4">
                        Alasan Pembatalan <span class="text-red-500">*</span> :
                        </p>
                        <textarea id="alasanBatal" class="swal2-textarea m-0 w-full mt-2" placeholder="Contoh: Jadwal Publikasi berubah, publikasi tidak diperlukan lagi" required></textarea>
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
                                url: "{{ route('staff.api.delete.publikasi') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    keterangan: keterangan
                                },
                                beforeSend: function() {
                                    $('[data-batal]').text('Proses Batal Berlangsung').attr(
                                        'disabled', true);
                                    $(this).text('Membatalkan...').attr('disabled', true);

                                    $('#btn-kembali').text('Membatalkan...').attr(
                                        'disabled', true);
                                    $('.btn-extras').text('Membatalkan...').attr('disabled',
                                        true);

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
                                    window.location.href = "{{ route('staff.home') }}";
                                },
                                error: function(err) {
                                    $('#btn-batal').text('Batal').attr('disabled', false);
                                    $('btn-kembali').text('Kembali').attr('disabled',
                                        false);
                                    $('.btn-extras').text('Kembali').attr('disabled',
                                        false);

                                    Swal.fire({
                                        icon: 'error',
                                        title: err.responseJSON.error ?? err
                                            .responseJSON.message,
                                    });
                                }
                            });
                        }
                    });
                });

                // Konfirmasi terima
                $('[data-terima]').on('click', function(e) {
                    e.preventDefault();
                    const id_proses_permohonan = $(this).data('terima');
                    const $btn = $(this);

                    Swal.fire({
                        title: 'Terima Permohonan?',
                        html: `Anda menerima permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat diubah.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#088404',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Terima',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('staff.api.update.status-publikasi') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    jenis_proses: 'Diterima',
                                },
                                beforeSend: function() {
                                    $btn.text('Menerima...').attr('disabled', true);
                                    $('#btn-kembali').text('Menerima...').attr('disabled',
                                        true);
                                    $('#btn-batal').text('Menerima...').attr('disabled',
                                        true);

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
                                    Swal.close();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(err) {
                                    $btn.text('Terima').attr('disabled', false);
                                    $('#btn-kembali').text('Kembali').attr('disabled',
                                        false);
                                    $('#btn-batal').text('Batal').attr('disabled', false);

                                    Swal.fire({
                                        icon: 'error',
                                        title: err.responseJSON?.error ?? err
                                            .responseJSON?.message ??
                                            'Terjadi kesalahan',
                                    });
                                }
                            });
                        }
                    });
                });


                // Konfirmasi diproses
                $('[data-diproses]').on('click', function(e) {
                    e.preventDefault();
                    const id_proses_permohonan = $(this).data('diproses');
                    const $btn = $(this);

                    Swal.fire({
                        title: 'Proses Permohonan?',
                        html: `Anda memproses permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat diubah.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#088404',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Proses',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('staff.api.update.status-publikasi') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    jenis_proses: 'Diproses',
                                },
                                beforeSend: function() {
                                    $btn.text('Memproses...').attr('disabled', true);
                                    $('#btn-kembali').text('Memproses...').attr('disabled',
                                        true);
                                    $('#btn-batal').text('Memproses...').attr('disabled',
                                        true);

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
                                    Swal.close();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(err) {
                                    $btn.text('Diproses').attr('disabled', false);
                                    $('#btn-kembali').text('Kembali').attr('disabled',
                                        false);
                                    $('#btn-batal').text('Batal').attr('disabled', false);

                                    Swal.fire({
                                        icon: 'error',
                                        title: err.responseJSON?.error ?? err
                                            .responseJSON?.message ??
                                            'Terjadi kesalahan',
                                    });
                                }
                            });
                        }
                    });
                });

            });
        </script>
    @elseif ($publikasi->status === 'Diproses')
        <script>
            $(document).ready(function() {
                function updateButtonState() {
                    let entries = $('.control-form .entry');
                    let total = entries.length;

                    entries.find('button')
                        .removeClass('btn-add bg-green-500 hover:bg-green-600 text-white')
                        .removeClass('btn-remove bg-red-500 hover:bg-red-600 text-white')
                        .removeClass('bg-gray-400 cursor-not-allowed')
                        .prop('disabled', false)
                        .text('–');

                    entries.slice(0, -1).each(function() {
                        $(this).find('button')
                            .addClass('btn-remove bg-red-500 hover:bg-red-600 text-white');
                    });

                    let lastButton = entries.last().find('button');

                    if (total >= 5) {
                        lastButton
                            .removeClass('btn-remove bg-red-500 hover:bg-red-600')
                            .addClass('btn-add bg-gray-400 text-white cursor-not-allowed')
                            .prop('disabled', true)
                            .text('+');
                    } else {
                        lastButton
                            .removeClass('btn-remove bg-red-500 hover:bg-red-600')
                            .addClass('btn-add bg-green-500 hover:bg-green-600 text-white')
                            .prop('disabled', false)
                            .text('+');
                    }
                }

                $('.control-form').on('click', '.btn-add', function(e) {
                    e.preventDefault();

                    let controlForm = $(this).closest('.control-form');
                    let count = controlForm.find('.entry').length;

                    if (count >= 5) return;

                    let lastEntry = controlForm.find('.entry').last();
                    let newEntry = lastEntry.clone();
                    newEntry.find('input').val('');
                    controlForm.append(newEntry);

                    updateButtonState();
                });

                $('.control-form').on('click', '.btn-remove', function(e) {
                    e.preventDefault();
                    $(this).closest('.entry').remove();
                    updateButtonState();
                });

                updateButtonState();
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#btn-selesai').on('click', function(e) {
                    e.preventDefault();

                    const id_proses_permohonan = "{{ $publikasi->id_proses_permohonan }}";

                    let link_outputs = $('input[name="link_output[]"]').map(function() {
                        return $(this).val().trim();
                    }).get();

                    const filteredLinks = link_outputs.filter(val => val !== '');

                    if (filteredLinks.length === 0) {
                        alert.fire({
                            icon: 'error',
                            title: 'URL kosong',
                            text: 'Pastikan URL terisi paling tidak 1 sebelum menyelesaikan permohonan.'
                        });
                        return;
                    }

                    $('input[name="link_output[]"]').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).closest('.entry').remove();
                        }
                    });

                    Swal.fire({
                        title: 'Selesaikan Permohonan?',
                        html: `Anda akan menyelesaikan permohonan publikasi ini.<br><span class="text-red-500 font-bold">Tindakan ini tidak dapat diubah.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#088404',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Terima',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('staff.api.update.status-publikasi') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    jenis_proses: 'Selesai',
                                    link_output: filteredLinks
                                },
                                beforeSend: function() {
                                    $('#btn-selesai').text('Mengirim...').attr('disabled',
                                        true);
                                    $('#btn-kembali').text('Mengirim...').attr('disabled',
                                        true);
                                    $('#btn-batal').text('Mengirim...').attr('disabled',
                                        true);

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
                                    localStorage.setItem('selesai_message', res.message);
                                    localStorage.setItem('message_info', res.message_info);
                                    window.location.href = "{{ route('staff.home') }}";
                                },
                                error: function(err) {
                                    $('#btn-selesai').text('Selesai').attr('disabled',
                                        false);
                                    $('#btn-kembali').text('Kembali').attr('disabled',
                                        false);
                                    $('#btn-batal').text('Batal').attr('disabled', false);

                                    alert.fire({
                                        icon: 'error',
                                        title: err.responseJSON?.error ?? err
                                            .responseJSON
                                            ?.message ?? 'Terjadi kesalahan',
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
