@extends('template.pemohon.main-pemohon')

@section('title', 'Verification Test')

@section('content')
    <main class="container mx-auto px-4 sm:px-2 py-16 flex-grow">
        <div class="p-4 sm:p-2">

            <a href="#" id="verification-test-promosi"
                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-6 rounded-lg transition-colors">
                Kirim Verification Test Email (Promosi)!
            </a>

            <a href="#" id="verification-test-liputan"
                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-6 rounded-lg transition-colors">
                Kirim Verification Test Email (Liputan)!
            </a>

        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('js/swal.js') }}" defer></script>
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#verification-test-promosi').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('pemohon.email.verifikasi-publikasi') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        permohonan: 'Promosi',
                    },
                    success: function(success) {
                        alert.fire({
                            icon: 'success',
                            title: success.message,
                        });
                    },
                    error: function(xhr, status, error) {
                        alert.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message,
                        });
                    }
                });
            });

            $('#verification-test-liputan').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('pemohon.email.verifikasi-publikasi') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        permohonan: 'Liputan',
                    },
                    success: function(success) {
                        alert.fire({
                            icon: 'success',
                            title: success.message,
                        });
                    },
                    error: function(xhr, status, error) {
                        alert.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message,
                        });
                    }
                });
            });
        });
    </script>
@endsection
