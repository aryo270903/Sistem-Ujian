<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Ujian - SMK Gandasari</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
    body {
        font-family: 'Figtree', sans-serif;
        background-color: #1a202c;
        color: #fff;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        align-items: center;
        overflow-x: hidden;
    }

    .container {
        width: 100%;
        max-width: 1200px; /* Sesuaikan dengan lebar maksimum yang Anda inginkan */
        padding: 1rem;
        box-sizing: border-box;
    }

    header {
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #2d3748;
        margin-bottom: 1.5rem; /* Tambah margin bawah untuk memberi ruang */
    }

    header img {
        width: 60px; /* Ukuran logo sedikit lebih besar */
        height: 60px;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Tambah shadow tipis */
    }

    nav a {
        margin: 0 0.75rem;
        color: #cbd5e0; /* Warna teks navigasi yang lebih lembut */
        text-decoration: none;
        transition: color 0.2s ease-in-out; /* Efek transisi hover */
    }

    nav a:hover {
        color: #f6ad55; /* Warna hover yang berbeda */
    }

    .content {
        flex-grow: 1;
        width: 100%;
        padding: 1.5rem;
        display: flex;
        flex-direction: column; /* Atur card menjadi kolom */
        align-items: stretch; /* Stretch card agar selebar container */
        gap: 1rem; /* Jarak antar card */
    }

    .card {
        background-color: #2d3748;
        border-radius: 8px;
        padding: 1.5rem; /* Padding sedikit lebih besar */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Tambah shadow tipis */
        transition: transform 0.1s ease-in-out; /* Efek transisi hover */
    }

    .card:hover {
        transform: translateY(-2px); /* Efek sedikit terangkat saat hover */
    }

    .card h2 {
        color: #f6ad55; /* Warna judul card yang berbeda */
        margin-top: 0;
        margin-bottom: 0.75rem;
        border-bottom: 1px solid #4a5568; /* Garis bawah judul */
        padding-bottom: 0.5rem;
    }

    .card p {
        line-height: 1.6; /* Jarak antar baris teks */
        color: #cbd5e0;
    }

    .card a.text-blue-500 {
        color: #66d6ff; /* Warna link yang berbeda */
        text-decoration: underline;
    }

    .card a.text-blue-500:hover {
        color: #a0e7ff;
    }

    footer {
        background-color: #2d3748;
        color: #a0aec0;
        padding: 1rem;
        text-align: center;
        width: 100%;
        margin-top: 2rem; /* Tambah margin atas untuk memisahkan dari konten */
    }

    .maintenance-alert {
        background-color: #e53e3e;
        color: white;
        padding: 0.75rem; /* Padding sedikit lebih besar */
        text-align: center;
        width: 100%;
        font-weight: bold; /* Teks alert lebih tebal */
    }
</style>
</head>
<body>
    <div class="maintenance-alert">
        ⚠️ Website sedang dalam perbaikan. Mohon maaf atas ketidaknyamanannya. ⚠️
    </div>
    <header class="container">
        <div>
            <img src="{{ asset('images/logo-smk.jpg') }}" alt="Logo SMK Gandasari">
        </div>
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/admin') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login Guru & Staff</a>
                    <a href="{{ route('siswa.login') }}">Login Siswa</a>
                @endauth
            </nav>
        @endif
    </header>
    <main class="content container">
        <div class="card">
            <h2>Tujuan Pembuatan E-learning Ujian</h2>
            <p>E-learning ujian ini dirancang untuk membantu Anda mempersiapkan diri menghadapi berbagai ujian. Dengan materi yang komprehensif dan latihan soal yang relevan, tingkatkan kepercayaan diri Anda dan raih hasil terbaik.</p>
        </div>
        <div class="card">
            <h2>Visi dan Misi Pembuatan E-learning</h2>
            <p><strong>Visi:</strong> Menjadi platform e-learning ujian terdepan yang menghasilkan lulusan berprestasi.<br><strong>Misi:</strong> Menyediakan materi ujian berkualitas, akses belajar yang fleksibel, dan dukungan yang berkelanjutan bagi peserta didik.</p>
        </div>
        <div class="card">
            <h2>Website Sekolah</h2>
            <p>Website sekolah ini adalah jendela digital kami ke dunia. Dapatkan informasi terkini, akses sumber daya pembelajaran, lihat profil sekolah, dan nikmati kemudahan komunikasi. Kami berkomitmen untuk menyediakan platform yang informatif, interaktif, dan mudah digunakan bagi seluruh komunitas sekolah.<br><br><strong>Link: <a href="https://www.smkgandasari.sch.id/" class="text-blue-500" target="_blank">https://www.smkgandasari.sch.id/</a></strong></p>
        </div>
        <div class="card">
            <h2>Kontak Kami</h2>
            <p><strong>Alamat:</strong> Jl. Raya Gandasari No.10</p>
            <p><strong>Telepon:</strong> (021) 123-456</p>
            <p><strong>Email:</strong> info@smkgandasari.sch.id</p>
        </div>
    </main>
</body>
</html>
