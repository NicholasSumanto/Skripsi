@extends('template.main')
@section('title', 'Home')
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col md:flex-row gap-12 max-w-10xl mx-auto w-full items-stretch">

            <!-- Left Section -->
            <div class="basis-1/3 bg-white p-8 sm:p-2 flex">
                <div class="flex flex-col justify-center h-full w-full">
                    <h2 class="text-3xl font-bold text-[#1a237e] mb-6 text-center md:text-left">Ada Kegiatan apa kali
                        ini ?</h2>
                    <button id="g-signin"
                        class="flex items-center space-x-2 border rounded-lg px-6 py-3 my-20 hover:bg-gray-50 shadow-sm w-full justify-center bg-white transition-colors">
                        <img src="{{ asset('img/g-logo.png') }}" alt="Google" class="h-5 w-5" data-onsuccess="onSignIn">
                        <span class="text-gray-700 font-medium">Sign in with Google</span>
                    </button>

                    <p class="mt-6 text-sm text-gray-600">
                        Untuk permohonan liputan atau promosi event di UKDW silahkan login menggunakan akun Gmail dengan
                        domain <span class="font-semibold">ukdw.ac.id</span>.
                    </p>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="basis-2/3 bg-white p-8 sm:p-2 flex flex-col justify-center">
                <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e] text-center md:text-right">Agenda
                    Publikasi</h1>
                <div id="calendar" class="w-full min-h-[400px] p-0 mb-12"></div>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Catatan :</span> Untuk pengajuan permohonan liputan atau promosi event
                    silahkan membuat surat permohonan publikasi terlebih dahulu. Form permohonan publikasi terdapat di
                    <a href="#" class="text-primary hover:underline font-medium">Unduhan</a>
                </p>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <!-- JS Addon -->
    <script src="{{ asset('js/calendar.js') }}"></script>
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
                styles: {
                    arrowPrev: 'arrow-smile',
                    arrowNext: 'arrow-smile-next',
                },
            };

            const calendar = new VanillaCalendar('#calendar', options);
            calendar.init();
        });
    </script>

    <!-- Google Sign-In -->
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script>
        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function() {
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: '
                    1075024781552 - t0m1uel41jr9h4tq4r5tg7ps6e0j0i8v.apps.googleusercontent.com ',
                    cookiepolicy: 'single_host_origin',
                    // scope: 'additional_scope'
                });
                attachSignin(document.getElementById('g-signin'));
            });
        };

        function attachSignin(element) {
            console.log(element.id);
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    document.getElementById('name').innerText = "Signed in: " +
                        googleUser.getBasicProfile().getName();
                },
                function(error) {
                    alert(JSON.stringify(error, undefined, 2));
                });
        }
    </script>
    <script>
        startApp();
    </script>
@endsection
