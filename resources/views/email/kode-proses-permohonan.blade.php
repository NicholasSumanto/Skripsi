<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Proses Permohonan</title>
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
            <p>Permohonan <strong>{{ $jenisPermohonan }}</strong> Anda sudah terverifikasi.</p>
            <p>Anda dapat melakukan pelacakan permohonan dengan kode lacak permohonan :</p>
            <div class="link-verifikasi-container">
                <p class="link-verifikasi">{{ $id_proses_permohonan }}</p>
            </div>
            <p>Pantau proses publikasi Anda di menu
                <a href="{{ $urlLacak }}" class="link-verifikasi">Lacak</a>.
            </p>
        </div>
    </div>
    <div class="footer">
        <p>&copy; Biro 4 UKDW - Kerja Sama dan Relasi Publik {{ date('Y') }}. Semua hak dilindungi.</p>
    </div>
</body>

</html>
