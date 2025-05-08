<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Permohonan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .text-container {
            padding: 0 20px 20px 20px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .link-verifikasi-container {
            background-color: #d5e4d9;
            border-left: 6px solid #28a745;
            padding: 10px;
            margin: 20px 0;
            font-size: 1.2em;
        }

        .alert-container {
            background-color: #eecccc;
            border-left: 6px solid #ca0000;
            padding: 10px;
            margin: 20px 0;
            font-size: 0.8em;
        }

        .alert-text {
            font-weight: bold;
            color: #700202;
        }

        .alert-text-bolder {
            font-weight: bolder;
            color: #700202;
        }

        .link-verifikasi {
            color: #000000;
            text-decoration: none;
        }

        .link-verifikasi-container:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }

        .logo-container {
            background-color: #28a745;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .logo {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ $urlLogo }}" alt="Logo" class="logo">
        </div>
        <div class="text-container">
            <h2>Halo, {{ $namaPemohon }}</h2>
            <p>Permohonan <strong>{{ $jenisPermohonan }}</strong> anda dalam masa verifikasi.</p>
            <p>Untuk melakukan verifikasi, buka tautan berikut :</p>
            <div class="link-verifikasi-container">
                <a class="link-verifikasi" href="{{ $urlVerifikasi }}">{{ $urlVerifikasi }}</a>
            </div>
            <p>Silakan buka halaman verifikasi ini untuk proses selanjutnya.</p>
            <div class="alert-container">
                <p class="alert-text">Jika permohonan publikasi tidak diverifikasi dalam 15 menit terhitung dari <span class="alert-text-bolder">{{$waktu}} WIB</span> maka permohonan publikasi
                    dianggap tidak sah dan akan dihapus!</p>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; Biro 4 UKDW - Kerja Sama dan Relasi Publik {{ date('Y') }}. Semua hak dilindungi.</p>
    </div>
</body>

</html>
