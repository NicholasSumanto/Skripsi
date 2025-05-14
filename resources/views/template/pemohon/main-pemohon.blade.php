<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi Biro 4 | @yield(section: 'title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="{{ asset('js/tailwind.js') }}"></script>
    @yield('custom-header')
</head>

<body class="font-['Inter'] h-full flex flex-col min-h-screen">
    <!-- Header -->
    @include('template.pemohon.header-pemohon')

    <!-- Main Content -->
    <div class="flex-grow">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('template.footer')
</body>

<!-- script -->
<script src="{{ asset('js/jQuery.js') }}"></script>
<script src="{{ asset('js/alphine.js') }}" defer></script>
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
    });
</script>

<script>
    $(document).ready(function() {
        const userName = localStorage.getItem('user_name');
        const liputan = localStorage.getItem('liputan_message');
        const liputan_email = localStorage.getItem('liputan_email_message');
        const promosi = localStorage.getItem('promosi_message');
        const promosi_email = localStorage.getItem('promosi_email_message');
        const batal_publikasi = localStorage.getItem('batalkan_message');

        if (userName) {
            alert.fire({
                icon: 'success',
                title: "Selamat datang, " + userName,
            });
            localStorage.removeItem('user_name');
        }

        if (liputan && liputan_email) {
            alert.fire({
                icon: 'success',
                title: liputan,
                text: liputan_email,
            });
            localStorage.removeItem('liputan_message');
            localStorage.removeItem('liputan_email_message');
        }

        if (promosi && promosi_email) {
            alert.fire({
                icon: 'success',
                title: promosi,
                text: promosi_email,
            });
            localStorage.removeItem('promosi_message');
            localStorage.removeItem('promosi_email_message');
        }

        if (batal_publikasi) {
            alert.fire({
                icon: 'success',
                title: batal_publikasi,
            });
            localStorage.removeItem('batalkan_message');
        }
    });
</script>

<!-- script add-on -->
@yield('script')

</html>
