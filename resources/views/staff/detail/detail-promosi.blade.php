@extends('template.staff.main-staff')
@section('title', 'Detail Permohonan Publikasi')

@section('custom-header')
    <link href="{{ asset('css/nanoGallery/nanogallery2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nanoGallery/nanogallery2.woff.min.css') }}" rel="stylesheet">
@endsection


@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Detail Permohonan Publikasi<br>Promosi Acara
        </h1>

        <div class="max-w-4xl mx-auto bg-gray-100 text-[#006034] rounded-xl shadow-xl p-10">
            <form id="form-promosi-view" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon :</label>
                        <input type="text" name="nama_pemohon" value="{{ $publikasi->nama_pemohon }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone :</label>
                        <input type="text" name="nomor_handphone" value="{{ $publikasi->nomor_handphone }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" value="{{ $publikasi->email }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul Event :</label>
                        <input type="text" name="judul" value="{{ $publikasi->judul }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan :</label>
                        <input type="text" name="tempat" value="{{ $publikasi->tempat }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara :</label>
                        <input type="date" name="tanggal" value="{{ $publikasi->tanggal }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white"
                            style="height: 50px;">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit :</label>
                        <input type="text" name="unit" value="{{ $publikasi->nama_unit }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit :</label>
                        <input type="text" name="sub_unit" value="{{ $publikasi->nama_sub_unit }}" readonly
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg block mb-2">Materi Promosi :</label>
                    <div class="space-y-8">

                        @php
                            function getThumbUrl($publikasi, $type, $file)
                            {
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                return $ext === 'mp4'
                                    ? route('staff.api.get.video-thumbnail-temp', [
                                        'id' => $publikasi->id_verifikasi_publikasi,
                                        'type' => $type,
                                        'filename' => $file,
                                    ])
                                    : route('staff.api.get.file-promosi', [
                                        'id' => $publikasi->id_verifikasi_publikasi,
                                        'type' => $type,
                                        'filename' => $file,
                                    ]);
                            }

                            function getFileUrl($publikasi, $type, $file)
                            {
                                return route('staff.api.get.file-promosi', [
                                    'id' => $publikasi->id_verifikasi_publikasi,
                                    'type' => $type,
                                    'filename' => $file,
                                ]);
                            }
                        @endphp

                        @if ($publikasi->file_stories)
                            <div>
                                <label class="block font-semibold text-green-700 mb-2">Instagram Stories</label>
                                <div id="nanoGallery-stories">
                                    @foreach (json_decode($publikasi->file_stories) as $file)
                                        @if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'mp4')
                                            <a href="{{ getFileUrl($publikasi, 'file_stories', $file) }}"
                                                data-ngdesc="Instagram Story (Video)"
                                                data-downloadurl="video/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_stories', $file) }}"
                                                data-ngthumb="{{ getThumbUrl($publikasi, 'file_stories', $file) }}"></a>
                                        @else
                                            <a href="{{ getFileUrl($publikasi, 'file_stories', $file) }}"
                                                data-ngdesc="Instagram Story"
                                                data-downloadurl="image/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_stories', $file) }}"></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- file_poster --}}
                        @if ($publikasi->file_poster)
                            <div>
                                <label class="block font-semibold text-green-700 mb-2">Instagram Post</label>
                                <div id="nanoGallery-poster">
                                    @foreach (json_decode($publikasi->file_poster) as $file)
                                        @if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'mp4')
                                            <a href="{{ getFileUrl($publikasi, 'file_poster', $file) }}"
                                                data-ngdesc="Instagram Post (Video)"
                                                data-downloadurl="video/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_poster', $file) }}"
                                                data-ngthumb="{{ getThumbUrl($publikasi, 'file_poster', $file) }}"></a>
                                        @else
                                            <a href="{{ getFileUrl($publikasi, 'file_poster', $file) }}"
                                                data-ngdesc="Instagram Post"
                                                data-downloadurl="image/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_poster', $file) }}"></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- file_video --}}
                        @if ($publikasi->file_video)
                            <div>
                                <label class="block font-semibold text-green-700 mb-2">Videotron</label>
                                <div id="nanoGallery-videotron">
                                    @foreach (json_decode($publikasi->file_video) as $file)
                                        @if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'mp4')
                                            <a href="{{ getFileUrl($publikasi, 'file_video', $file) }}"
                                                data-ngdesc="Videotron (Video)"
                                                data-ngthumb="{{ getThumbUrl($publikasi, 'file_video', $file) }}"
                                                data-downloadurl="image/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_video', $file) }}"></a>
                                        @else
                                            <a href="{{ getFileUrl($publikasi, 'file_video', $file) }}"
                                                data-ngdesc="Videotron"
                                                data-downloadurl="image/{{ basename($file) }}:{{ getFileUrl($publikasi, 'file_video', $file) }}"></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>

                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" rows="6" readonly
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm text-[#006034] bg-white">{{ $publikasi->catatan }}</textarea>
                </div>

                @if ($publikasi->status === 'Diproses')
                    <div class="space-y-2">
                        <label class="font-semibold text-lg text-yellow-400">Link Output * :</label>
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
                    @if ($publikasi->status === 'Diproses')
                        <a id="btn-selesai"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                            Selesai
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/nanoGallery/jquery.nanogallery2.core.min.js') }}"></script>
    <script src="{{ asset('js/nanoGallery/nanogallery2.min.js') }}"></script>
    <script src="{{ asset('js/nanoGallery/jquery.nanogallery2.data_flickr.min.js') }}"></script>
    <script src="{{ asset('js/nanoGallery/jquery.nanogallery2.data_nano_photos_provider2.min.js') }}"></script>\
    <script src="{{ asset('js/nanoGallery/jquery.nanogallery2.data_google3.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nanoGallery-stories').nanogallery2({
                thumbnailHeight: 300,
                thumbnailWidth: 'auto',
                thumbnailBorderVertical: 0,
                thumbnailBorderHorizontal: 0,
                galleryDisplayMode: 'moreButton',
                thumbnailHoverEffect2: 'scale120',
                galleryTheme: {
                    navigationDots: false
                },
                viewerTools: {
                    topRight: 'download, rotateLeft, rotateRight, fullscreen, close'
                }
            });

            $('#nanoGallery-poster').nanogallery2({
                thumbnailHeight: 300,
                thumbnailWidth: 'auto',
                thumbnailBorderVertical: 0,
                thumbnailBorderHorizontal: 0,
                galleryDisplayMode: 'moreButton',
                thumbnailHoverEffect2: 'scale120',
                galleryTheme: {
                    navigationDots: false
                },
                viewerTools: {
                    topRight: 'download, rotateLeft, rotateRight, fullscreen, close'
                }
            });

            $('#nanoGallery-videotron').nanogallery2({
                thumbnailHeight: 300,
                thumbnailWidth: 'auto',
                thumbnailBorderVertical: 0,
                thumbnailBorderHorizontal: 0,
                galleryDisplayMode: 'rows',
                thumbnailHoverEffect2: 'scale120',
                galleryTheme: {
                    navigationDots: false
                },
                viewerTools: {
                    topRight: 'download, rotateLeft, rotateRight, fullscreen, close'
                }
            });
        });
    </script>

    @if ($publikasi->status === 'Diproses')
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    $('.control-form').on('click', '.btn-add', function(e) {
                        e.preventDefault();
                        let controlForm = $(this).closest('.control-form');
                        let lastEntry = controlForm.find('.entry').last();
                        let newEntry = lastEntry.clone();

                        newEntry.find('input').val('');

                        lastEntry.find('button')
                            .removeClass('btn-add bg-green-500 hover:bg-green-600')
                            .addClass('btn-remove bg-red-500 hover:bg-red-600')
                            .text('–');

                        controlForm.append(newEntry);
                    });

                    $('.control-form').on('click', '.btn-remove', function(e) {
                        e.preventDefault();
                        $(this).closest('.entry').remove();

                        let entries = $('.control-form .entry');
                        if (entries.length === 1) {
                            entries.find('button')
                                .removeClass('btn-remove bg-red-500 hover:bg-red-600')
                                .addClass('btn-add bg-green-500 hover:bg-green-600')
                                .text('+');
                        } else {
                            entries.find('button').removeClass('btn-add').addClass('btn-remove').text(
                                '–');
                            entries.last().find('button')
                                .removeClass('btn-remove bg-red-500 hover:bg-red-600')
                                .addClass('btn-add bg-green-500 hover:bg-green-600')
                                .text('+');
                        }
                    });
                });
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
                                    link_output: link_outputs
                                },
                                beforeSend: function() {
                                    $('#btn-selesai').text('Mengirim...').attr('disabled',
                                        true);
                                    $('btn-kembali').text('Mengirim...').attr('disabled',
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
