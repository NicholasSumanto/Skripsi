@extends('template.pemohon.main-pemohon')
@section('title', 'Form Liputan')
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
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Liputan</br></h1>
        <div class="max-w-4xl mx-auto bg-[#006034] text-[#FFCC29] rounded-xl shadow-xl p-10">
            <form id="form-liputan" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon<span class="text-red-500">*</span> : </label>
                        <input type="text" name="nama_pemohon" placeholder="Masukkan nama pemohon"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone <span class="text-red-500">*</span> :</label>
                        <input type="text" name="nomor_handphone" placeholder="Masukkan nomor handphone"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                            id="nomor_handphone">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" placeholder="Masukkan email"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-[#FFCC29]"
                            value="{{ Auth::user()->email }}" readonly disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul <span class="text-red-500">*</span> :</label>
                        <input type="text" name="judul" placeholder="Masukkan judul acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan <span class="text-red-500">*</span> :</label>
                        <input type="text" name="tempat" placeholder="Masukkan tempat pelaksanaan"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara <span class="text-red-500">*</span> :</label>
                        <input type="date" name="tanggal" placeholder="Pilih tanggal acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                            style="height: 50px;" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Waktu <span class="text-red-500">*</span> :</label>
                        <input type="time" name="waktu" placeholder="Pilih waktu acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit <span class="text-red-500">*</span> :</label>
                        <select id="unit" name="unit"
                            class="chosen-select w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-[#FFCC29]">
                            <option value="">Pilih Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit <span class="text-red-500">*</span> :</label>
                        <select id="id_sub_unit" name="id_sub_unit"
                            class="chosen-select w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-[#FFCC29]">
                            <option value="">Pilih Sub Unit</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Rundown dan TOR <span class="text-red-500">*</span> :</label>
                        <input type="file" name="file_liputan[]" multiple
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none bg-white text-black"
                            accept=".pdf">
                        <small class="text-white">Format file berupa .pdf (Max 2048 MB).</small>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media?<span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-6 mt-2 text-[#FFCC29]">
                        <label class="flex items-center"><input type="radio" name="wartawan" value="Ya"
                                class="mr-2"> Ya</label>
                        <label class="flex items-center"><input type="radio" name="wartawan" value="Tidak"
                                class="mr-2"> Tidak</label>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg block mb-1">Output <span class="text-red-500">*</span> :</label>
                    <p class="text-sm text-white mb-2 italic">*Bisa memilih lebih dari satu</p>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-[#FFCC29]">
                        <label class="flex items-center">
                            <input type="checkbox" name="output[]" value="artikel" class="mr-2"> Artikel
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="output[]" value="foto" class="mr-2"> Foto
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="output[]" value="video" class="mr-2"> Video
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="output[]" value="koran" class="mr-2"> Koran
                        </label>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan"
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                        rows="6"></textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" id="cancel-button"
                        onclick="document.getElementById('form-liputan').reset(); window.location.href='{{ route('pemohon.home') }}';"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-[#FFCC29] hover:bg-yellow-500 text-black font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
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
            $('input[name="file_liputan[]"]').on('change', function() {
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

            $('#form-liputan').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let requiredFields = [
                    'input[name="nama_pemohon"]',
                    'input[name="nomor_handphone"]',
                    'input[name="judul"]',
                    'input[name="tempat"]',
                    'input[name="tanggal"]',
                    'input[name="waktu"]',
                    'select[name="unit"]',
                    'select[name="id_sub_unit"]',
                    'input[name="file_liputan[]"]'
                ];

                requiredFields.forEach(function(selector) {
                    const $field = $(selector);

                    if ($field.attr('type') === 'file') {
                        if ($field[0].files.length === 0) {
                            isValid = false;
                            $field.addClass('border-red-500');
                            console.log('Field ' + selector + ' is empty');
                        } else {
                            $field.removeClass('border-red-500');
                        }
                    } else {
                        const value = $field.val();
                        if (typeof value === 'undefined' || value.trim() === '') {
                            isValid = false;
                            $field.addClass('border-red-500');
                            console.log('Field ' + selector + ' is empty');
                        } else {
                            $field.removeClass('border-red-500');
                        }
                    }
                });

                if (!isValid) {
                    alert.fire({
                        icon: 'error',
                        title: 'Formulir tidak lengkap',
                        text: 'Harap lengkapi semua kolom bertanda bintang (*).'
                    });
                    return;
                }

                if (!$('input[name="wartawan"]:checked').val()) {
                    isValid = false;
                    alert.fire({
                        icon: 'warning',
                        title: 'Pilih opsi wartawan',
                        text: 'Apakah memerlukan wartawan atau tidak wajib diisi.'
                    });
                    return;
                }

                if ($('input[name="output[]"]:checked').length === 0) {
                    isValid = false;
                    alert.fire({
                        icon: 'warning',
                        title: 'Output wajib dipilih',
                        text: 'Pilih minimal satu jenis output.'
                    });
                    return;
                }

                let form = $(this)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('pemohon.api.post.publikasi') }}",
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
                            title: 'Sedang mengirim...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        $('button[type="submit"]').text('Mengirim...').attr('disabled', true);
                        $('#form-liputan :input').prop('disabled', true);
                        $('#cancel-button').attr('disabled', true);

                    },
                    success: function(response) {
                        localStorage.setItem('liputan_message', response.message);
                        localStorage.setItem('liputan_email_message', response.email_message);
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').text('Kirim').attr('disabled', false);
                        $('#form-liputan :input').prop('disabled', false);
                        $('#cancel-button').attr('disabled', false);
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
        document.getElementById('nomor_handphone').addEventListener('input', function() {
            let value = this.value;

            if (value.startsWith('0')) {
                this.value = '+62' + value.substring(2);
            } else if (value.startsWith('0') || value.startsWith('+62')) {
                this.value = value.replace(/^0/, '+62');
            }
        });
    </script>
@endsection
