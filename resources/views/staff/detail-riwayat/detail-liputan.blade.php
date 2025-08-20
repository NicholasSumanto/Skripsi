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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon :</label>
                        <input type="text" name="nama_pemohon" value="{{ $publikasi->nama_pemohon }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone :</label>
                        <input type="text" name="nomor_handphone" value="{{ $publikasi->nomor_handphone }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" value="{{ $publikasi->email }}" disabled
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul :</label>
                        <input type="text" name="judul" value="{{ $publikasi->judul }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan :</label>
                        <input type="text" name="tempat" value="{{ $publikasi->tempat }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara :</label>
                        <input type="text" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($publikasi->tanggal)->format('d-m-Y') }}" disabled
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Waktu :</label>
                        <input type="time" name="waktu"
                            value="{{ \Carbon\Carbon::parse($publikasi->waktu)->format('H:i') }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Rundown dan TOR :</label>
                        <div class="mt-2">
                            @if ($publikasi->file_liputan && $publikasi->status !== 'Batal')
                                @php
                                    $file = json_decode($publikasi->file_liputan, true);
                                @endphp

                                @if ($file[0])
                                    <a href="{{ route('staff.api.get.file-liputan', ['id' => $publikasi->id_verifikasi_publikasi, 'filename' => $file[0]]) }}"
                                        target="_blank"
                                        class="inline-block bg-yellow-500 text-[#006034] font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-300 mb-2 mr-2">
                                        Lihat File
                                    </a>
                                @else
                                    <p class="text-white">Tidak ada file.</p>
                                @endif
                            @else
                                <p class="text-white">Permohonan Telah Dibatalkan oleh
                                    {{ $publikasi->batal_is_pemohon ? 'Pemohon' : 'Staff Biro 4' }}.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit :</label>
                        <input type="text" name="unit" value="{{ $publikasi->nama_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit :</label>
                        <input type="text" name="sub_unit" value="{{ $publikasi->nama_sub_unit }}"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" disabled>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media?</label>
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
                    <label class="font-semibold text-lg">Output :</label>
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
                    <textarea name="catatan" class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-black bg-white" rows="6"
                        disabled>{{ $publikasi->catatan }}</textarea>
                </div>

                @if ($publikasi->status === 'Selesai')
                    <div class="space-y-2" id="output-form">
                        <label class="font-semibold text-lg text-yellow-400">Link Output<span class="text-red-500">*</span> :</label>
                        <div class="control-form space-y-2">
                            @php
                                $linkOutput = json_decode($publikasi->link_output, true);
                            @endphp
                            @foreach ($linkOutput as $link)
                                <div class="entry flex overflow-hidden rounded-lg border border-gray-300">
                                    <input type="text" name="link_output[]" class="flex-1 p-3 outline-none text-black bg-white"
                                        placeholder="https://..." value="{{ $link }}" disabled>
                                    @if (!$loop->last)
                                        <button type="button" disabled
                                            class="btn btn-remove bg-red-500 hover:bg-red-600 w-12 text-white flex items-center justify-center opacity-50 cursor-not-allowed">
                                            -
                                        </button>
                                    @else
                                        <button type="button" disabled
                                            class="btn btn-add w-12 bg-green-500 hover:bg-green-600 text-white flex items-center justify-center opacity-50 cursor-not-allowed">
                                            +
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-6">
                        <label class="font-semibold text-lg">Keterangan Pembatalan Publikasi :</label>
                        <textarea name="keterangan" rows="6" disabled
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-red-700 bg-white">{{ $publikasi->keterangan }}</textarea>
                    </div>
                @endif

                <div class="flex justify-between mt-6">
                    <a href="{{ route('staff.riwayat') }}" id="btn-kembali"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Kembali
                    </a>
                    @if ($publikasi->status === 'Selesai')
                        <div class="flex gap-2">
                            <button type="button"
                                class="font-semibold bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded"
                                id="btn-edit">Edit Link</button>
                            <button type="button" class="font-semibold bg-green-500 text-white px-4 py-2 rounded hidden"
                                id="btn-save">Simpan</button>
                            <button type="button" class="font-semibold bg-red-500 text-white px-4 py-2 rounded hidden"
                                id="btn-cancel">Batal</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </main>
@endsection

@section('script')
    @if ($publikasi->status === 'Selesai')
        <script>
            $(document).ready(function() {
                let formIsDisabled = true;

                function updateButtonState(isDisabled = formIsDisabled) {
                    let entries = $('.control-form .entry');
                    let total = entries.length;

                    entries.find('button')
                        .removeClass('btn-add bg-green-500 hover:bg-green-600 text-white')
                        .removeClass('btn-remove bg-red-500 hover:bg-red-600 text-white')
                        .removeClass('bg-gray-400 cursor-not-allowed opacity-50')
                        .prop('disabled', false)
                        .text('–');

                    if (isDisabled) {
                        entries.find('button')
                            .addClass('bg-gray-400 text-white opacity-50 cursor-not-allowed')
                            .prop('disabled', true)
                            .text('–');
                        return;
                    }

                    entries.slice(0, -1).each(function() {
                        $(this).find('button')
                            .addClass('btn-remove bg-red-500 hover:bg-red-600 text-white')
                            .prop('disabled', false)
                            .text('–');
                    });

                    let lastButton = entries.last().find('button');

                    if (total >= 5) {
                        lastButton
                            .addClass('btn-add bg-gray-400 text-white cursor-not-allowed opacity-50')
                            .prop('disabled', true)
                            .text('+');
                    } else {
                        lastButton
                            .addClass('btn-add bg-green-500 hover:bg-green-600 text-white')
                            .prop('disabled', false)
                            .text('+');
                    }
                }

                $('.control-form').on('click', '.btn-add', function(e) {
                    e.preventDefault();
                    if (formIsDisabled) return;

                    let controlForm = $(this).closest('.control-form');
                    let count = controlForm.find('.entry').length;

                    if (count >= 5) return;

                    let lastEntry = controlForm.find('.entry').last();
                    let newEntry = lastEntry.clone();
                    newEntry.find('input').val('');
                    controlForm.append(newEntry);

                    updateButtonState(false);
                });

                $('.control-form').on('click', '.btn-remove', function(e) {
                    e.preventDefault();
                    if (formIsDisabled) return;

                    $(this).closest('.entry').remove();
                    updateButtonState(false);
                });

                // Inisialisasi kondisi awal
                updateButtonState(true);

                // Edit, Cancel, dan Save logika
                const originalLinks = Array.isArray(@json(json_decode($publikasi->link_output, true))) ?
                    @json(json_decode($publikasi->link_output, true)) : [];

                const originalHTML = $('.control-form').html();

                function setDisabled(state) {
                    $('#output-form input[name="link_output[]"]').prop('disabled', state);
                    $('#output-form input[name="link_output[]"]').toggleClass('bg-gray-100', state);
                }

                $('#btn-edit').on('click', function(e) {
                    e.preventDefault();
                    formIsDisabled = false;
                    setDisabled(false);
                    updateButtonState(false);
                    $('#btn-edit').addClass('hidden');
                    $('#btn-save, #btn-cancel').removeClass('hidden');
                });

                $('#btn-cancel').on('click', function(e) {
                    e.preventDefault();
                    formIsDisabled = true;
                    $('.control-form').html(originalHTML);

                    $('#output-form input[name="link_output[]"]').each(function(i) {
                        $(this).val(originalLinks[i]);
                    });

                    setDisabled(true);
                    updateButtonState(true);
                    $('#btn-edit').removeClass('hidden');
                    $('#btn-save, #btn-cancel').addClass('hidden');
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                const originalLinks = Array.isArray(@json(json_decode($publikasi->link_output, true))) ?
                    @json(json_decode($publikasi->link_output, true)) : [];
                3
                const originalHTML = $('.control-form').html();

                function setDisabled(state) {
                    $('#output-form input[name="link_output[]"]').prop('disabled', state);
                    $('#output-form input[name="link_output[]"]').toggleClass('bg-gray-100', state);
                    $('#output-form button').prop('disabled', state);
                    $('#output-form button').toggleClass('opacity-50 cursor-not-allowed', state);
                }

                $('#btn-edit').on('click', function(e) {
                    e.preventDefault(e);

                    setDisabled(false);
                    $('#btn-edit').addClass('hidden');
                    $('#btn-save, #btn-cancel').removeClass('hidden');

                });

                $('#btn-cancel').on('click', function(e) {
                    e.preventDefault(e);

                    $('.control-form').html(originalHTML);

                    $('#output-form input[name="link_output[]"]').each(function(i) {
                        $(this).val(originalLinks[i]);
                    });

                    setDisabled(true);
                    $('#btn-edit').removeClass('hidden');
                    $('#btn-save, #btn-cancel').addClass('hidden');
                });

                $('#btn-save').on('click', function(e) {
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

                    const isSameAsOriginal = JSON.stringify(filteredLinks) === JSON.stringify(originalLinks);

                    if (isSameAsOriginal) {
                        alert.fire({
                            icon: 'info',
                            title: 'Tidak ada perubahan',
                            text: 'Tidak ada perubahan pada link output.'
                        });
                        return;
                    }

                    $('input[name="link_output[]"]').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).closest('.entry').remove();
                        }
                    });

                    Swal.fire({
                        title: 'Ubah Link Output?',
                        html: `Anda akan mengubah link output permohonan publikasi.<br><span class="text-red-500 font-bold">Pemohon akan mendapatkan notifikasi melalui email.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#088404',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Ubah',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('staff.api.update.link-output') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: {
                                    id_proses_permohonan: id_proses_permohonan,
                                    link_output: filteredLinks
                                },
                                beforeSend: function() {
                                    $('#btn-selesai').text('Mengirim...').attr('disabled',
                                        true);
                                    $('btn-kembali').text('Mengirim...').attr('disabled',
                                        true);
                                    $('btn-edit').text('Mengirim...').attr('disabled',
                                        true);
                                    $('btn-save').text('Mengirim...').attr('disabled',
                                        true);
                                    $('btn-cancel').text('Mengirim...').attr('disabled',
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
                                    localStorage.setItem('ubahOutput_message', res.message);
                                    window.location.href = "{{ route('staff.riwayat') }}";
                                },
                                error: function(err) {
                                    $('#btn-selesai').text('Selesai').attr('disabled',
                                        false);
                                    $('#btn-kembali').text('Kembali').attr('disabled',
                                        false);
                                    $('btn-edit').text('Edit Link').attr('disabled',
                                        false);
                                    $('btn-save').text('Simpan').attr('disabled',
                                        false);
                                    $('btn-cancel').text('Batal').attr('disabled',
                                        false);
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
