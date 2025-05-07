<header class="bg-primary">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('img/Duta_Wacana.png') }}" alt="UKDW Logo" class="h-12 mt-2 mb-3">
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="#" class="text-white hover:text-gray-200">Publikasi</a>
            <a href="#" class="text-white hover:text-gray-200">Agenda</a>
            <a href="#" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600">Lacak</a>
            <a href="#" class="text-white hover:text-gray-200"><img class="w-8 h-8" src="{{ asset('img/logout.png') }}"
                    alt="Logout Icon"></a>
        </nav>

        <!-- Mobile Button -->
        <div class="md:hidden flex items-center" x-data="{ open: false }">
            <button @click="open = !open" class="text-white focus:outline-none">
                <!-- Icon hamburger -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Mobile Menu Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute top-16 right-4 bg-primary rounded-md shadow-lg flex flex-col items-start py-2 w-40 p-2">
                <a href="#" class="w-full text-white hover:bg-primary-dark px-4 py-2">Publikasi</a>
                <a href="#" class="w-full text-white hover:bg-primary-dark px-4 py-2">Agenda</a>
                <a href="#"
                    class="w-full bg-yellow-500 text-black hover:bg-yellow-600 px-4 py-2 rounded-md">Lacak</a>
            </div>
        </div>

    </div>
</header>
