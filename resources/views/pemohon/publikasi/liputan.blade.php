@extends('template.pemohon.main-pemohon')
@section('title', 'Form Liputan')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
    {{--
    <style>
        .chosen-container-single .chosen-single {
            height: 44px;
            border-radius: 0.5rem;
            padding: 10px 12px;
            background-color: white;
            border: 1px solid #d1d5db;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }
    </style> --}}
@endsection

@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Liputan</br></h1>
        <div class="max-w-4xl mx-auto bg-[#006034] text-[#FFCC29] rounded-xl shadow-xl p-10">
            <form id="form-liputan" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon * :</label>
                        <input type="text" name="nama_pemohon" placeholder="Masukkan nama pemohon"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone * :</label>
                        <input type="text" name="nomor_handphone" placeholder="Masukkan nomor handphone"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email :</label>
                        <input type="email" name="email" placeholder="Masukkan email"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-white"
                            value="{{ Auth::user()->email }}" readonly disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul * :</label>
                        <input type="text" name="judul" placeholder="Masukkan judul acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan * :</label>
                        <input type="text" name="tempat" placeholder="Masukkan tempat pelaksanaan"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara * :</label>
                        <input type="date" name="tanggal" placeholder="Pilih tanggal acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                            style="height: 50px;"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Waktu * :</label>
                        <input type="time" name="waktu" placeholder="Pilih waktu acara"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit * :</label>
                        <select id="unit" name="unit"
                            class=" w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                            <option value="">Pilih Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit * :</label>
                        <select id="id_sub_unit" name="id_sub_unit"
                            class=" w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black">
                            <option value="">Pilih Sub Unit</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Rundown dan TOR * :</label>
                        <input type="file" name="file_liputan[]" multiple
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none bg-white text-black"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.7z">
                        <small class="text-white-500">Ukuran total tidak lebih dari 2048 MB.</small>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Apakah memerlukan wartawan atau media? *</label>
                    <div class="flex items-center space-x-6 mt-2 text-[#FFCC29]">
                        <label class="flex items-center"><input type="radio" name="wartawan" value="Ya"
                                class="mr-2"> Ya</label>
                        <label class="flex items-center"><input type="radio" name="wartawan" value="Tidak"
                                class="mr-2"> Tidak</label>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Output * :</label>
                    <div class="flex flex-col space-y-2 mt-2 text-[#FFCC29]">
                        <label class="flex items-center"><input type="checkbox" name="output[]" value="artikel"
                                class="mr-2"> Artikel</label>
                        <label class="flex items-center"><input type="checkbox" name="output[]" value="foto"
                                class="mr-2"> Foto</label>
                        <label class="flex items-center"><input type="checkbox" name="output[]" value="video"
                                class="mr-2"> Video</label>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan"
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#FFCC29] focus:outline-none text-black"
                        rows="6"></textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="submit"
                        class="bg-[#FFCC29] hover:bg-yellow-500 text-black font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
                    <button type="button" id="cancel-button"
                        onclick="document.getElementById('form-liputan').reset(); window.location.href='{{ route('pemohon.home') }}';"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/chosen.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('.chosen-select').chosen({
                width: "100%"
            });

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
                'text-black'
            ];

            function applyChosenStylesById(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.add(...chosenClasses);
                    return true;
                }
                return false;
            }

            // Observer untuk elemen yang dimunculkan chosen
            const observer = new MutationObserver(function() {
                const ready1 = applyChosenStylesById('id_sub_unit_chosen');
                const ready2 = applyChosenStylesById('unit_chosen');
                if (ready1 && ready2) {
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

                            // Tambahkan styling ulang
                            setTimeout(() => {
                                applyChosenStylesById('id_sub_unit_chosen');
                            }, 100);
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
                        $(this).val(''); // reset input
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

                if (!isValid) {
                    alert.fire({
                        icon: 'error',
                        title: 'Formulir tidak lengkap',
                        text: 'Harap lengkapi semua kolom bertanda bintang (*).'
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
@endsection
