<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Learning Ujian - SMK Gandasari</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
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
                align-items: center; /* Center content horizontally */
            }

            .transform-3d {
                transform-style: preserve-3d;
                perspective: 1000px;
                width: 90%; /* Adjust width for better responsiveness */
                max-width: 1200px; /* Maximum width of the content area */
            }

            .transform-3d > * {
                transform: translateZ(0);
            }

            .card-3d {
                transform: rotateY(3deg) rotateX(2deg); /* Lebih sedikit rotasi */
                box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.1); /* Lebih halus shadow */
                transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease;
                background-color: #2d3748; /* Warna latar belakang sedikit lebih terang */
                border-radius: 6px; /* Sudut lebih kecil */
                padding: 1rem; /* Padding lebih kecil */
                margin-bottom: 0.75rem; /* Margin bawah lebih kecil */
                display: inline-block; /* Untuk tata letak header */
            }

            .card-3d:hover {
                transform: rotateY(5deg) rotateX(3deg) scale(1.01); /* Efek hover lebih halus */
                box-shadow: 8px 8px 18px rgba(0, 0, 0, 0.2);
                filter: brightness(1.03);
            }

            #background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                object-fit: cover;
                filter: brightness(0.4);
                z-index: -1;
            }

            header {
                padding: 1rem 0;
                width: 100%;
                display: flex;
                justify-content: space-between; /* Logo kiri, login kanan */
                align-items: center;
                margin-bottom: 1rem;
            }

            header .logo-container {
                padding-left: 1.5rem;
            }

            header .login-container {
                padding-right: 1.5rem;
            }

            header img {
                width: 50px; /* Ukuran logo lebih kecil */
                height: 50px;
                border-radius: 50%;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease;
            }

            header img:hover {
                transform: scale(1.05);
            }

            nav {
                text-align: right; /* Teks navigasi rata kanan */
            }

            nav a {
                display: inline-block;
                padding: 8px 14px; /* Padding tautan lebih kecil */
                margin-left: 6px; /* Margin kiri antar tautan */
                border-radius: 4px; /* Sudut tautan lebih kecil */
                background-color: #e53e3e;
                color: white;
                font-weight: 400; /* Font weight lebih ringan */
                text-decoration: none;
                font-size: 0.9rem; /* Ukuran font lebih kecil */
            }

            nav a:hover {
                background-color: #fc8181;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            main {
                flex-grow: 1;
                padding: 1.5rem;
                width: 100%;
            }

            main .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Ukuran kartu lebih kecil */
                gap: 0.75rem; /* Jarak antar kartu lebih kecil */
            }

            .contact-info {
                text-align: center;
                background-color: rgba(0, 0, 0, 0.4); /* Lebih transparan */
                padding: 0.75rem; /* Padding info kontak lebih kecil */
                border-radius: 4px; /* Sudut info kontak lebih kecil */
                box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
                margin-top: 1rem;
                width: 90%;
                max-width: 1200px;
                font-size: 0.85rem; /* Ukuran font info kontak lebih kecil */
            }

            .contact-info h2 {
                color: #e53e3e;
                margin-bottom: 0.3rem; /* Margin bawah judul kontak lebih kecil */
                font-size: 1.1rem; /* Ukuran font judul kontak lebih kecil */
            }

            .contact-info p {
                margin: 0.2rem 0;
            }

            .text-blue-500 {
                color: #60a5fa;
                text-decoration: underline;
            }

            .maintenance-alert {
                background-color: #e53e3e;
                color: white;
                padding: 6px; /* Padding alert lebih kecil */
                text-align: center;
                font-weight: bold;
                font-size: 0.9rem; /* Ukuran font alert lebih kecil */
                animation: marquee 15s linear infinite;
                white-space: nowrap;
                overflow: hidden;
                width: 100%;
            }

            @keyframes marquee {
                0% { transform: translateX(100%); }
                100% { transform: translateX(-100%); }
            }
        </style>
    @endif
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="maintenance-alert">
        ⚠️ Website sedang dalam perbaikan (maintenance). Beberapa fitur mungkin tidak berfungsi dengan baik. Mohon maaf atas ketidaknyamanannya. ⚠️
    </div>
    <img id="background" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
    <div class="transform-3d">
        <header>
            <div class="logo-container">
                <img src="{{ asset('images/logo-smk.jpg') }}" alt="Logo SMK Gandasari" class="card-3d" />
            </div>
            @if (Route::has('login'))
                <div class="login-container">
                    <nav>
                        @auth
                            <a href="{{ url('/admin') }}" class="card-3d">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="card-3d">Login Guru & Staff</a>
                            <a href="{{ route('siswa.login') }}" class="card-3d">Login Siswa</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="card-3d">Register</a>
                            @endif
                        @endauth
                    </nav>
                </div>
            @endif
        </header>

        <main>
            <div class="grid">
                <div class="card-3d">
                    <h2>Tujuan Pembuatan E-learning Ujian</h2>
                    <p>E-learning ujian ini dirancang untuk membantu Anda mempersiapkan diri menghadapi berbagai ujian. Dengan materi yang komprehensif dan latihan soal yang relevan, tingkatkan kepercayaan diri Anda dan raih hasil terbaik.</p>
                </div>
                <div class="card-3d">
                    <h2>Visi dan Misi Pembuatan E-learning</h2>
                    <p><strong>Visi:</strong> Menjadi platform e-learning ujian terdepan yang menghasilkan lulusan berprestasi.<br><strong>Misi:</strong> Menyediakan materi ujian berkualitas, akses belajar yang fleksibel, dan dukungan yang berkelanjutan bagi peserta didik.</p>
                </div>
                <div class="card-3d">
                    <h2>Website Sekolah</h2>
                    <p>Website sekolah ini adalah jendela digital kami ke dunia. Dapatkan informasi terkini, akses sumber daya pembelajaran, lihat profil sekolah, dan nikmati kemudahan komunikasi. Kami berkomitmen untuk menyediakan platform yang informatif, interaktif, dan mudah digunakan bagi seluruh komunitas sekolah.<br><br><strong>Link: <a href="https://www.smkgandasari.sch.id/" class="text-blue-500" target="_blank">https://www.smkgandasari.sch.id/</a></strong></p>
                </div>
            </div>
        </main>

        <div class="contact-info">
            <h2>Kontak Kami</h2>
            <p><strong>Alamat:</strong> Jl. Raya Gandasari No.10</p>
            <p><strong>Telepon:</strong> (021) 123-456</p>
            <p><strong>Email:</strong> info@smkgandasari.sch.id</p>
        </div>
    </div>
</body>
</html>