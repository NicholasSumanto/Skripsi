<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi Biro 4 | @yield(section: 'title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="{{ asset('js/tailwind.core.js') }}"></script>
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script src="{{ asset('js/jQuery.js') }}"></script>
    <script src="{{ asset('js/alphine.js') }}" defer></script>
    @yield('custom-header')
</head>

<body class="font-['Inter'] h-full flex flex-col min-h-screen">
    <!-- Header -->
    @include('template.staff.header-staff')

    <!-- Main Content -->
    <div class="flex-grow">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('template.footer')
</body>

<!-- script -->
<script src="{{ asset('js/swal.js') }}" defer></script>
<script src="{{ asset('js/notification.js') }}" defer></script>

<!-- destroy session -->
<script>
    $(document).ready(function() {
        $('.logout-btn').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Logout?',
                text: "Anda akan keluar dari akun ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('google.logout') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            localStorage.setItem('logout_message', res.message);
                            window.location.href = res.redirect_to;
                        },
                        error: function(err) {
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

        const userName = localStorage.getItem('user_name');
        const batal_publikasi = localStorage.getItem('batalkan_message');
        const terima_message = localStorage.getItem('terima_message');
        const diproses_message = localStorage.getItem('diproses_message');
        const selesai_message = localStorage.getItem('selesai_message');
        const message_info = localStorage.getItem('message_info');
        const ubahOutput_message = localStorage.getItem('ubahOutput_message');

        if (batal_publikasi) {
            alert.fire({
                icon: 'success',
                title: batal_publikasi,
            });
            localStorage.removeItem('batalkan_message');
        }

        if (userName) {
            alert.fire({
                icon: 'success',
                title: "Selamat datang, " + userName,
            });
            localStorage.removeItem('user_name');
        }

        if (terima_message) {
            alert.fire({
                icon: 'success',
                title: terima_message,
            });
            localStorage.removeItem('terima_message');
        }

        if (diproses_message) {
            alert.fire({
                icon: 'success',
                title: diproses_message,
            });
            localStorage.removeItem('diproses_message');
        }

        if (selesai_message && message_info) {
            alert.fire({
                icon: 'success',
                title: selesai_message,
                text: message_info,
            });
            localStorage.removeItem('selesai_message');
            localStorage.removeItem('message_info');
        }

        if (ubahOutput_message) {
            alert.fire({
                icon: 'success',
                title: ubahOutput_message,
            });
            localStorage.removeItem('ubahOutput_message');
        }
    });
</script>

@yield('script')

</html>
