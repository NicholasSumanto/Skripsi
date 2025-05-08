@extends('template.pemohon.main-pemohon')
@section('title', 'Home')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-calendar.css') }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="flex flex-col max-w-7xl mx-auto w-full items-center bg-white p-8 sm:p-2">

            <h1 class="text-3xl font-bold text-center mb-6 text-[#1a237e]">Agenda Publikasi</h1>

            <div id="calendar" class="w-full min-h-[400px] p-0"></div>

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
            };

            const calendar = new VanillaCalendar('#calendar', options);
            calendar.init();
        });
    </script>
@endsection

