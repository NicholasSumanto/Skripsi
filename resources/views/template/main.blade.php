<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biro 4</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
    <script src="{{ asset('js/tailwind.js') }}"></script>
</head>

<body class="font-['Inter'] h-full">
    <!-- Header -->
    <header class="bg-primary">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('img/Duta_Wacana.png') }}" alt="UKDW Logo" class="h-12 mt-2 mb-3">
            </div>
            <nav class="flex items-center space-x-6">
                <a href="#" class="text-white hover:text-gray-200">Beranda</a>
                <a href="#" class="text-white hover:text-gray-200">Unduhan</a>
                <a href="#" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600">Lacak</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col md:flex-row gap-12 max-w-10xl mx-auto w-full items-stretch">

            <!-- Left Section -->
            <div class="basis-1/3 bg-white p-8 sm:p-2 flex">
                <div class="flex flex-col justify-center h-full w-full">
                    <h2 class="text-3xl font-bold text-[#1a237e] mb-6 text-center md:text-left">Ada Kegiatan apa kali
                        ini ?</h2>
                    <button
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


    <!-- Footer -->
    <footer class="bg-primary text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Logo Section -->
                <div>
                    <img src="{{ asset('img/Duta_Wacana.png') }}" alt="UKDW Logo" class="h-10 mb-4">
                    <p class="text-sm">Jl. dr. Wahidin Sudirohusodo no. 5-25</p>
                    <p class="text-sm">Yogyakarta, Indonesia - 55224</p>
                    <p class="text-sm">Telp: +62274563929, Fax: +62274513235</p>
                    <p class="text-sm">email: humas@ukdw.ac.id</p>
                </div>

                <!-- Product Section -->
                <div>
                    <h3 class="font-bold mb-4">Product</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:underline">Features</a></li>
                        <li><a href="#" class="hover:underline">Pricing</a></li>
                        <li><a href="#" class="hover:underline">Case studies</a></li>
                        <li><a href="#" class="hover:underline">Reviews</a></li>
                        <li><a href="#" class="hover:underline">Updates</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div>
                    <h3 class="font-bold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:underline">About</a></li>
                        <li><a href="#" class="hover:underline">Contact us</a></li>
                        <li><a href="#" class="hover:underline">Careers</a></li>
                        <li><a href="#" class="hover:underline">Culture</a></li>
                        <li><a href="#" class="hover:underline">Blog</a></li>
                    </ul>
                </div>

                <!-- Support Section -->
                <div>
                    <h3 class="font-bold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:underline">Getting started</a></li>
                        <li><a href="#" class="hover:underline">Help center</a></li>
                        <li><a href="#" class="hover:underline">Server status</a></li>
                        <li><a href="#" class="hover:underline">Report a bug</a></li>
                        <li><a href="#" class="hover:underline">Chat support</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-white/20 text-center">
                <p>&copy; Biro 4 UKDW - Kerja Sama dan Relasi Publik 2025</p>
            </div>
        </div>
    </footer>
</body>

<!-- Perbaikan script -->
<script src="{{ asset('js/jQuery.js') }}"></script>
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



</html>
