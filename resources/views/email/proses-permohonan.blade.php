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
            <img src="{{ $urlLogo ?? asset('img/Duta_Wacana.png') }}" alt="Logo" class="logo">
        </div>
        <div class="text-container">
            <h2>Halo, {{ $publikasi->nama_pemohon }}</h2>
            <p>Terdapat pembaruan dalam progres pengerjaan peromohonan publikasi Anda.</p>
            </p>

            <h2 style="color: #0B4D1E;">Informasi Permohonan Publikasi</h2>
            <table width="100%" border="1" cellpadding="8" cellspacing="0"
                style="border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #0B4D1E; color: #FFC107;">
                    <tr>
                        <th>Nama Pemohon</th>
                        <th>Nama Publikasi</th>
                        <th>Tanggal/Waktu</th>
                        <th>Unit</th>
                        <th>Sub Unit</th>
                    </tr>
                </thead>
                <tbody style="color: #333; text-align: center;">
                    <tr>
                        <td>{{ $publikasi->nama_pemohon }}</td>
                        <td>{{ $publikasi->judul }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($publikasi->tanggal)->format('d/m/Y') }}
                            @if ($publikasi->jenis_publikasi === 'Liputan' && isset($publikasi->waktu))
                                <br> {{  \Carbon\Carbon::parse($publikasi->waktu)->Format('H:i')}}
                            @endif
                        </td>
                        <td>{{ $publikasi->nama_unit }}</td>
                        <td>{{ $publikasi->nama_sub_unit }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            <h3 style="color: #0B4D1E; margin-top: 0; margin-bottom: 0;">Jenis Publikasi:
                {{ $publikasi->jenis_publikasi }}</h3>
            <h4 style="color: #0B4D1E; margin-top: 0.5rem; margin-bottom: 1rem;">Kode Publikasi:
                {{ $publikasi->id_proses_permohonan }}</h4>

            @php
                $steps = [
                    'Diajukan' => $publikasi->tanggal_diajukan,
                    'Diterima' => $publikasi->tanggal_diterima,
                    'Diproses' => $publikasi->tanggal_diproses,
                    'Selesai' => $publikasi->tanggal_selesai,
                ];

                $activeStep = $publikasi->status;
                $stepReached = true;
                $firstEmptyStepLabel = collect($steps)->filter(fn($v) => !$v)->keys()->first();
                $afterCancelledStep = false;
            @endphp

            <table width="100%" cellpadding="8" cellspacing="0" style="font-size: 14px;">
                @foreach ($steps as $label => $date)
                    @if ($label === $firstEmptyStepLabel && $publikasi->status === 'Batal')
                        @php $afterCancelledStep = true; @endphp
                        <tr>
                            <td><strong>❌</strong></td>
                            <td>
                                <strong>Dibatalkan oleh
                                    {{ $publikasi->batal_is_pemohon == true ? 'Pemohon' : 'Staff Biro 4' }}</strong><br>
                                <small>{{ \Carbon\Carbon::parse($publikasi->tanggal_batal)->translatedFormat('l, d/m/Y') }}</small>
                            </td>
                        </tr>
                    @endif
                    @php
                        $isAfterCancelled = $publikasi->status === 'Batal' && $afterCancelledStep;
                        $isActive = !$isAfterCancelled && $stepReached;
                        if ($label === $activeStep) {
                            $stepReached = false;
                        }

                        $icon = $isAfterCancelled ? '❌' : ($isActive ? '✔️' : '⏳');
                        $dateText = $date ? \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y') : '-';
                    @endphp
                    <tr>
                        <td width="30"><strong>{{ $icon }}</strong></td>
                        <td>
                            <strong>{{ $label }}</strong><br>
                            <small>{{ $dateText }}</small>
                        </td>
                    </tr>
                @endforeach
            </table>
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
