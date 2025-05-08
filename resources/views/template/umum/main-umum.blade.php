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
    @include('template.umum.header-umum')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('template.footer')

</body>

<!-- script -->
<script src="{{ asset('js/jQuery.js') }}"></script>
<script src="{{ asset('js/alphine.js') }}" defer></script>
@yield('script')

</html>
