@extends('template.pemohon.main-pemohon')
@section('title', 'Form Promosi')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">
@endsection


@section('content')
    <main class="flex-grow bg-gray-50 py-16 px-6">
        <h1 class="text-5xl font-bold mb-12 text-center" style="color: #1E285F;">Permohonan Publikasi<br>Promosi Acara</h1>

        <div class="max-w-4xl mx-auto bg-gray-100 text-[#006034] rounded-xl shadow-xl p-10">
            <form id="form-promosi" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-lg">Nama Pemohon * :</label>
                        <input type="text" name="nama_pemohon" placeholder="Nama Pemohon"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Nomor Handphone * :</label>
                        <input type="text" name="nomor_handphone" placeholder="+62"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white"
                            id="nomor_handphone">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Email * :</label>
                        <input type="email" name="email" placeholder="email@gmail.com"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034]"
                            value="{{ Auth::user()->email }}" readonly disabled>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Judul Event * :</label>
                        <input type="text" name="judul" placeholder="Judul Event"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tempat Pelaksanaan * :</label>
                        <input type="text" name="tempat" placeholder="Tempat Pelaksanaan"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Tanggal Acara * :</label>
                        <input type="date" name="tanggal"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white"
                            style="height: 50px;"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Unit * :</label>
                        <select id="unit" name="unit"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <option value="">Pilih Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id_unit }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-lg">Sub Unit * :</label>
                        <select id="id_sub_unit" name="id_sub_unit"
                            class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                            <option value="">Pilih Sub Unit</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg block mb-2">Materi Promosi * :</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Instagram Stories</label>
                            <input type="file" name="file_stories[]" multiple accept=".jpg,.jpeg,.png,.mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                        </div>
                        <div>
                            <label class="block mb-1">Instagram Post</label>
                            <input type="file" name="file_poster[]" multiple accept=".jpg,.jpeg,.png,.mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                        </div>
                        <div>
                            <label class="block mb-1">Videotron</label>
                            <input type="file" name="file_video[]" multiple accept=".mp4"
                                class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white">
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-lg">Catatan :</label>
                    <textarea name="catatan" rows="6"
                        class="w-full rounded-lg p-3 border border-gray-300 shadow-sm focus:ring-2 focus:ring-[#006034] focus:outline-none text-[#006034] bg-white"></textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="submit"
                        class="bg-[#006034] hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full transition duration-300">Kirim</button>
                    <button type="button"
                        onclick="document.getElementById('form-promosi').reset(); window.location.href='{{ route('pemohon.home') }}';"
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

                if (!hasAtLeastOneFile) {
                    alert("Minimal satu file harus diunggah.");
                    event.preventDefault();
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formulir tidak lengkap',
                        text: 'Harap lengkapi semua kolom bertanda bintang (*).'
                    });
                    return;
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
                        $('button[type="submit"]').text('Mengirim...').attr('disabled', true);
                        $('#form-promosi :input').prop('disabled', true);
                    },
                    success: function(response) {
                        localStorage.setItem('promosi_message', response.message);
                        localStorage.setItem('promosi_email_message', response.email_message);
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').text('Kirim').attr('disabled', false);
                        $('#form-promosi :input').prop('disabled', false);

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

        if (value.startsWith('08')) {
            this.value = '+62' + value.substring(2);
        } else if (value.startsWith('08') || value.startsWith('+62')) {
            this.value = value.replace(/^08/, '+62'); 
        }
    });
</script>
@endsection
