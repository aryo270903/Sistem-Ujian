<!DOCTYPE html>
<html>
<head>
    <title>Kartu Ujian Masal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
            margin: 0;
            padding: 20px;
        }

        .page {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            width: 650px;
            border: 1px solid #03a9f4;
            padding: 30px;
            background-color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            margin-bottom: 20px;
            position: relative;
            text-align: center;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
            color: #0288d1;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        .info-table td:first-child {
            font-weight: 600;
            width: 200px;
            color: #0288d1;
        }

        .logo {
            width: 90px;
            position: absolute;
            top: 25px;
            left: 25px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            color: #0288d1;
            font-weight: 600;
        }

        .footer p {
            margin: 6px 0;
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach ($users as $user)
            <div class="card">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo-smk.jpg'))) }}" alt="Logo Sekolah" class="logo">
                <div class="header">
                    <h2>KARTU PESERTA UJIAN SEKOLAH</h2>
                    <p>DEMO E-LEARNING</p>
                    <p>TAHUN PELAJARAN 2025/2026</p>
                </div>
                <table class="info-table">
                    <tr>
                        <td>Nomor Induk</td>
                        <td>: {{ $user->nomor_induk }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: {{ $user->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $user->nik }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>: {{ $user->nisn }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir</td>
                        <td>: {{ $user->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>: {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $user->alamat }}</td>
                    </tr>
                    <tr>
                        <td>URL Login</td>
                        <td>: http://sistemujian.web.id/</td>
                    </tr>
                </table>
                <div class="footer">
                    <p>Banten, 08 April 2025</p>
                    <p>Kepala Sekolah,</p>
                    <br><br>
                    <p><strong>Kepala Sekolah</strong></p>
                    <p>NIP - </p>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
