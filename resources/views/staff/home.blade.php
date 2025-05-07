@extends('template.staff.main-staff')
@section('title', 'Home')
@section('script')
    <script src="{{ asset('js/swal.js') }}" defer></script>
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            const userName = localStorage.getItem('user_name');
            if (userName) {
                alert.fire({
                    icon: 'success',
                    title: "Selamat datang, " + userName,
                });
                localStorage.removeItem('user_name');
            }
        });
    </script>
@endsection
