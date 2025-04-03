<!DOCTYPE html>
<html>
<head>
    <title>Kartu Peserta Ujian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #b2ebf2); /* Gradien lembut */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            width: 650px;
            border: 1px solid #03a9f4; /* Border lebih tipis */
            padding: 30px;
            background-color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Bayangan lebih halus */
            border-radius: 12px;
            position: relative;
            text-align: center;
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

        .photo, .photo-icon {
            width: 130px;
            height: 160px;
            background-color: #f0f0f0;
            display: block;
            margin: 25px auto;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #03a9f4;
        }

        .logo {
            width: 90px;
            position: absolute;
            top: 25px;
            left: 25px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 35px;
        }

        .signature {
            text-align: right;
            color: #0288d1;
            font-weight: 600;
        }

        .signature p {
            margin: 6px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo-smk.jpg'))) }}" alt="Logo Sekolah" class="logo">
        <div class="header">
            <h2>KARTU PESERTA UJIAN SEKOLAH</h2>
            <p>DEMO E-LERNING</p>
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
                <td>NISN</td>
                <td>: {{ $user->nisn }}</td>
            </tr>
            <tr>
                <td>URL Login</td>
                <td>: http://sistemujian.web.id/</td>
            </tr>
        </table>
        <div class="footer">
            <div class="signature">
                <p>Banten, 08 April 2025</p>
                <p>Kepala Sekolah,</p>
                <br><br>
                <p><strong>Kepala Sekolah</strong></p>
                <p>NIP - </p>
            </div>
        </div>
    </div>
</body>
</html>