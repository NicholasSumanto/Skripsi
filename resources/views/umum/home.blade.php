@extends('template.umum.main-umum')
@section('title', 'Home')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col md:flex-row gap-12 max-w-10xl mx-auto w-full items-stretch">

            <!-- Bagian Kiri -->
            <div class="basis-1/3 bg-white p-8 sm:p-2 flex">
                <div class="flex flex-col justify-center h-full w-full">
                    <h2 class="text-3xl font-bold text-[#1a237e] mb-6 text-center md:text-left">Ada Kegiatan apa kali ini ?</h2>
                    <button id="custom-google-button"
                        class="flex items-center space-x-2 border rounded-lg px-6 py-3 my-20 hover:bg-gray-50 shadow-sm w-full justify-center bg-white transition-colors">
                        <img src="{{ asset('img/g-logo.png') }}" alt="Google" class="h-5 w-5">
                        <span class="text-gray-700 font-medium">Sign in with Google</span>
                    </button>

                    <p class="mt-6 text-sm text-gray-600">
                        Untuk permohonan liputan atau promosi event di UKDW silahkan login menggunakan akun Gmail dengan
                        domain <span class="font-semibold">ukdw.ac.id</span>.
                    </p>
                </div>
            </div>

            <!-- Bagian Calendar -->
            <div class="basis-2/3 bg-white p-8 sm:p-2 flex flex-col justify-center">
                <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e] text-center md:text-center">Agenda
                    Publikasi</h1>
                <div id="calendar" class="w-full min-h-[400px] p-0 mb-12"></div>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Catatan :</span> Untuk pengajuan permohonan liputan atau promosi event
                    silahkan membuat surat permohonan publikasi terlebih dahulu. Form permohonan publikasi terdapat di
                    <a href="{{ route('umum.unduhan') }}" class="text-primary hover:underline font-medium">Unduhan</a>
                </p>
            </div>
        </div>
        @if (isset($success) && $success)
            {{ $success }}
        @endif
    </main>
@endsection

@section('script')
    <!-- JS Addon -->
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script src="{{ asset('js/swal.js') }}" defer></script>
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const options = {
                settings: {
                    selection: {
                        day: 'single',
                    },
                    visibility: {
                        daysOutside: false,
                    },
                },
            };

            const calendar = new VanillaCalendar('#calendar', options);
            calendar.init();
        });
    </script>

    <!-- Google Sign-In -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        let tokenClient;

        function initGoogle() {
            if (typeof google === 'undefined' || !google.accounts) {
                setTimeout(initGoogle, 100);
                return;
            }

            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: '1075024781552-t0m1uel41jr9h4tq4r5tg7ps6e0j0i8v.apps.googleusercontent.com',
                scope: 'email profile openid',
                callback: handleCredentialResponse,
            });

            $('#custom-google-button').on('click', function() {
                tokenClient.requestAccessToken();
                console.log('Requesting access token...');
            });
        }

        $(document).ready(function() {
            initGoogle();
        });

        function handleCredentialResponse(response) {
            const googleToken = response.access_token;

            $.ajax({
                url: "{{ route('google.callback') }}",
                method: "POST",
                headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                data: {
                    credential: googleToken,
                },
                success: function(res) {
                    localStorage.setItem('user_name', res.name);
                    window.location.href = res.redirect_to;
                },
                error: function(err) {
                    alert.fire({
                        icon: 'error',
                        title: err.responseJSON.error ?? err.responseJSON.message,
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            const logout_message = localStorage.getItem('logout_message');
            if (logout_message) {
                alert.fire({
                    icon: 'success',
                    title: logout_message,
                });
                localStorage.removeItem('logout_message');
            }
        });
    </script>

@endsection
