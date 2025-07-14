<header class="bg-primary">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('umum.home') }}">
                <img src="{{ asset('img/Logo.png') }}" alt="UKDW Logo" class="h-12 mt-2 mb-3">
            </a>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('staff.dashboard') }}"
                class="text-white hover:text-gray-200 {{ request()->routeIs('staff.dashboard') ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400' : '' }}">
                DASHBOARD
            </a>
            <a href="{{ route('staff.home') }}"
                class="text-white hover:text-gray-200 {{ request()->routeIs('staff.home') ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400' : '' }}">
                PUBLIKASI
            </a>
            <a href="{{ route('staff.riwayat') }}"
                class="text-white hover:text-gray-200 {{ request()->routeIs('staff.riwayat') ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400' : '' }}">
                RIWAYAT
            </a>
            <a href="{{ route('staff.unit') }}"
                class="text-white hover:text-gray-200 {{ request()->routeIs('staff.unit*') ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400' : '' }}">
                UNIT
            </a>
            <a href="" class="text-white hover:text-gray-200 logout-btn">
                <img class="w-8 h-8" src="{{ asset('img/logout.png') }}" alt="Logout Icon">
            </a>
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
                class="absolute top-16 z-50 right-4 bg-primary rounded-md shadow-lg flex flex-col items-start py-2 w-40 p-2">

                <a href="{{ route('staff.dashboard') }}"
                    class="w-full px-4 py-2 rounded-md
          {{ request()->routeIs('staff.dashboard')
              ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400 bg-primary-dark text-white'
              : 'text-white hover:bg-primary-dark' }}">
                    Dashboard
                </a>

                <a href="{{ route('staff.home') }}"
                    class="w-full px-4 py-2 rounded-md
          {{ request()->routeIs('staff.home')
              ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400 bg-primary-dark text-white'
              : 'text-white hover:bg-primary-dark' }}">
                    Publikasi
                </a>

                <a href="{{ route('staff.riwayat') }}"
                    class="w-full px-4 py-2 rounded-md
          {{ request()->routeIs('staff.riwayat')
              ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400 bg-primary-dark text-white'
              : 'text-white hover:bg-primary-dark' }}">
                    Riwayat
                </a>
                <a href="{{ route('staff.unit') }}"
                    class="w-full px-4 py-2 rounded-md
          {{ request()->routeIs('staff.unit')
              ? 'font-bold underline underline-offset-4 decoration-2 decoration-yellow-400 bg-primary-dark text-white'
              : 'text-white hover:bg-primary-dark' }}">
                    Unit
                </a>

                <a href="#"
                    class="w-full text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md mt-2 logout-btn text-center">
                    Logout
                </a>

            </div>

        </div>

    </div>
</header>
