@extends('template.pemohon.main-pemohon')
@section('title', 'Form Promosi')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    <style>
        .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
            position: absolute !important;
            right: 10px !important;
        }
    </style>
@endsection


@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Promosi Acara</h1>

        <div class="max-w-4xl mx-auto bg-gray-300 text-[#006034] rounded-xl shadow-xl p-10">
            <form id="form-promosi" class="space-y-6" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon <span class="text-red-500">*</span> :</label>
                        <input type="text" name="nama_pemohon" placeholder="Nama Pemohon"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">
                            Nomor Handphone <span class="text-red-500">*</span> :
                        </label>
                        <input type="text" name="nomor_handphone" id="nomor_handphone"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                            placeholder="contoh: 081234567890" maxlength="14" required>
                        <p id="hp-error" class="text-red-600 text-sm mt-1 hidden"></p>
                    </div>


                    <div>
                        <label class="font-semibold text-lg">Email <span class="text-red-500">*</span> :</label>
                        <input type="email" name="email" placeholder="email@gmail.com"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034]"
                            value="{{ Auth::user()->email }}" readonly disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul Event <span class="text-red-500">*</span> :</label>
                        <input type="text" name="judul" placeholder="Judul Event"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan <span class="text-red-500">*</span>
                            :</label>
                        <input type="text" name="tempat" placeholder="Tempat Pelaksanaan"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara <span class="text-red-500">*</span> :</label>
                        <input type="date" name="tanggal" placeholder="Pilih tanggal acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                            style="height: 50px;" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            onfocus="this.showPicker()">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit <span class="text-red-500">*</span> :</label>
                        <select id="unit" name="unit"
                            class="chosen-select w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <option value="">Pilih Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit <span class="text-red-500">*</span> :</label>
                        <select id="id_sub_unit" name="id_sub_unit"
                            class="chosen-select w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <option value="">Pilih Sub Unit</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg block mb-2">Materi Promosi <span class="text-red-500">*</span>
                        :</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Instagram Stories</label>
                            <input type="file" name="file_stories[]" multiple accept=".jpg,.jpeg,.png,.mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <small class="text-blue-500 block">Format : .jpg, .jpeg, .png, .mp4 <br>Bisa lebih dari 1 file
                                <b>Max : 15MB</b></small>
                        </div>
                        <div>
                            <label class="block mb-1">Instagram Post</label>
                            <input type="file" name="file_poster[]" multiple accept=".jpg,.jpeg,.png,.mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <small class="text-blue-500 block">Format : .jpg, .jpeg, .png, .mp4 <br>Bisa lebih dari 1 file
                                <b>Max : 15MB</b> </small>
                        </div>
                        <div>
                            <label class="block mb-1">Videotron</label>
                            <input type="file" name="file_video[]" multiple accept=".mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <small class="text-blue-500 block">Format : .mp4 <br>Bisa lebih dari 1 file <b>Max
                                    :15MB</b><br>Durasi maksimal 15 detik*</small>
                        </div>
                    </div>
                </div>


                <div class="mt-6">
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" rows="6"
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white"></textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" id="btn-batal"
                        onclick="document.getElementById('form-promosi').reset(); window.location.href='{{ route('pemohon.home') }}';"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-[#006034] hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/chosen.js') }}"></script>
    <script>
        $('.chosen-select').select2();

        const chosenClasses = [
            'w-full',
            'rounded-lg',
            'p-3',
            'border',
            'border-gray-300',
            'shadow-sm',
            'focus:ring-2',
            'focus:ring-[#FFCC29]',
            'focus:outline-none',
            'text-black',
            'bg-white',
        ];

        function applyChosenStylesByClass(className) {
            const elements = document.getElementsByClassName(className);
            if (elements.length > 0) {
                Array.from(elements).forEach(el => el.classList.add(...chosenClasses));
                return true;
            }
            return false;
        }

        function hideElementsByClass(className) {
            const elements = document.getElementsByClassName(className);
            Array.from(elements).forEach(el => {
                el.style.setProperty('background', 'transparent', 'important');
                el.style.setProperty('border', 'none', 'important');
            });
        }

        function changeTextColorByClass(className) {
            const elements = document.getElementsByClassName(className);
            Array.from(elements).forEach(el => {
                el.style.setProperty('color', '#006034', 'important');
                el.style.setProperty('white-space', 'nowrap', 'important');
                el.style.setProperty('overflow', 'hidden', 'important');
                el.style.setProperty('text-overflow', 'ellipsis', 'important');
            });
        }

        function removeWidthByClass(className) {
            const elements = document.getElementsByClassName(className);
            Array.from(elements).forEach(el => {
                el.style.removeProperty('width');
            });
        }


        // Observer untuk elemen yang dimunculkan chosen
        const observer = new MutationObserver(function() {
            const ready1 = applyChosenStylesByClass('select2');
            const ready2 = hideElementsByClass('select2-selection');
            const ready3 = changeTextColorByClass('select2-selection__rendered');
            const ready4 = changeTextColorByClass('select2-selection__arrow');
            const ready5 = removeWidthByClass('select2');
            if (ready1 && ready2 && ready3 && ready4) {
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });

        $('#unit').on('change', function() {
            var unitID = $(this).val();
            $('#id_sub_unit').empty().append('<option value="">Loading...</option>').trigger(
                "chosen:updated");

            if (unitID) {
                $.ajax({
                    url: '{{ route('pemohon.api.get.sub-units') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: 'POST',
                    data: {
                        id_unit: unitID
                    },
                    success: function(data) {
                        $('#id_sub_unit').empty().append(
                            '<option value="">Pilih Sub Unit</option>');
                        $.each(data, function(index, sub) {
                            $('#id_sub_unit').append(
                                '<option value="' + sub.id_sub_unit + '">' + sub
                                .nama_sub_unit + '</option>'
                            );
                        });
                        $('#id_sub_unit').trigger("chosen:updated");
                    },
                    error: function() {
                        $('#id_sub_unit').empty().append(
                            '<option value="">Gagal memuat Sub Unit</option>'
                        ).trigger("chosen:updated");
                    }
                });
            } else {
                $('#id_sub_unit').empty().append('<option value="">Pilih Sub Unit</option>').trigger(
                    "chosen:updated");
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Validasi ukuran file maksimal 15MB
            $('input[type="file"]').on('change', function() {
                const maxSizeMB = 15;
                for (let i = 0; i < this.files.length; i++) {
                    if (this.files[i].size > maxSizeMB * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File terlalu besar',
                            text: `File "${this.files[i].name}" melebihi batas 15MB.`,
                        });
                        $(this).val('');
                        break;
                    }
                }
            });

            $('#form-promosi').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let requiredFields = [
                    'input[name="nama_pemohon"]',
                    'input[name="nomor_handphone"]',
                    'input[name="judul"]',
                    'input[name="tempat"]',
                    'input[name="tanggal"]',
                    'select[name="unit"]',
                    'select[name="id_sub_unit"]'
                ];

                requiredFields.forEach(function(selector) {
                    const $field = $(selector);
                    const value = $field.val();

                    if (typeof value === 'undefined' || value.trim() === '') {
                        isValid = false;
                        $field.addClass('border-red-500');
                    } else {
                        $field.removeClass('border-red-500');
                    }
                });

                // Validasi minimal satu file diupload
                const fileInputs = document.querySelectorAll('input[type="file"]');
                const hasAtLeastOneFile = Array.from(fileInputs).some(input => input.files && input.files
                    .length > 0);

                if (!isValid) {
                    alert.fire({
                        icon: 'error',
                        title: 'Formulir tidak lengkap',
                        text: 'Harap lengkapi semua kolom bertanda bintang (*).'
                    });
                    return;
                }

                if (!hasAtLeastOneFile) {
                    alert.fire({
                        icon: 'error',
                        title: 'File tidak ditemukan',
                        text: 'Harap unggah minimal satu file untuk promosi.'
                    });
                    event.preventDefault();
                }

                let form = $(this)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('pemohon.api.post.promosi') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        Swal.fire({
                            icon: 'info',
                            title: 'Mohon Menunggu',
                            html: `
                               Permintaan publikasi sedang diproses.<br><b>Proses ini dapat memakan waktu beberapa menit</b><br><br>tergantung pada ukuran file dan kecepatan koneksi internet Anda.<br><br>.<br>Mohon <b>jangan tutup, reload, atau menekan tombol kembali</b> selama proses berlangsung.
                            `,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $('button[type="submit"]').text('Mengirim...').attr('disabled',
                            true);
                        $('#form-promosi :input').prop('disabled', true);
                        $('#btn-batal').attr('disabled', true);
                    },
                    success: function(response) {
                        localStorage.setItem('promosi_message', response.message);
                        localStorage.setItem('promosi_email_message', response.email_message);
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').text('Kirim').attr('disabled', false);
                        $('#form-promosi :input').prop('disabled', false);
                        $('#btn-batal').attr('disabled', false);

                        let message = 'Terjadi kesalahan. Silakan coba lagi.';
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
        });
    </script>

    <script>
        const input = document.getElementById('nomor_handphone');
        const errorText = document.getElementById('hp-error');

        // Hanya format lokal: 0 + 9-14 digit angka
        const phoneRegex = /^0[0-9]{8,13}$/;

        input.addEventListener('input', function() {
            // Hanya izinkan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Maksimal 14 karakter (0 + 13 digit)
            if (this.value.length > 14) {
                this.value = this.value.slice(0, 14);
            }

            // Cek validasi regex
            if (!phoneRegex.test(this.value)) {
                errorText.classList.remove('hidden');
                errorText.textContent = 'Nomor HP harus diawali 0 dan memiliki total 9-14 digit angka.';
            } else {
                errorText.classList.add('hidden');
            }
        });
    </script>
@endsection
