<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
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
            }

            .transform-3d {
                transform-style: preserve-3d;
                perspective: 1000px;
            }

            .transform-3d > * {
                transform: translateZ(0);
            }

            .card-3d {
                transform: rotateY(10deg) rotateX(5deg);
                box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease;
                background-color: #333; /* Darker card background */
                border-radius: 10px;
                padding: 2rem;
                margin-bottom: 1.5rem;
            }

            .card-3d:hover {
                transform: rotateY(15deg) rotateX(10deg) scale(1.05);
                box-shadow: 15px 15px 30px rgba(0, 0, 0, 0.2);
                filter: brightness(1.1);
            }

            #background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                object-fit: cover;
                filter: brightness(0.3);
                z-index: -1;
            }

            header {
                padding: 2rem 0;
                text-align: center;
            }

            header img {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease;
                margin-bottom: 1rem;
            }

            header img:hover {
                transform: scale(1.1);
            }

            nav a {
                display: inline-block;
                padding: 12px 20px;
                margin: 0 10px;
                border-radius: 8px;
                background-color: #FF2D20;
                color: white;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            nav a:hover {
                background-color: #FF5722;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            main {
                flex-grow: 1;
                padding: 2rem;
            }

            main .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
            }

            .contact-info {
                text-align: center;
                background-color: rgba(0, 0, 0, 0.6);
                padding: 1.5rem;
                border-radius: 8px;
                box-shadow: 0px 12px 30px rgba(0, 0, 0, 0.1);
                margin-top: 2rem;
            }

            .contact-info h2 {
                color: #FF2D20;
            }

            .contact-info p {
                margin: 0.5rem 0;
            }

            .text-blue-500 {
                color: #60a5fa;
            }

            .text-blue-500:hover {
                text-decoration: underline;
            }

            .maintenance-alert {
                background-color: #FF2D20;
                color: white;
                padding: 10px;
                text-align: center;
                font-weight: bold;
                font-size: 1.1rem;
                animation: marquee 15s linear infinite;
                white-space: nowrap;
                overflow: hidden;
            }

        </style>
    @endif
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="maintenance-alert">
    <marquee behavior="scroll" direction="left" scrollamount="5">⚠️ Website sedang dalam perbaikan (maintenance). Beberapa fitur mungkin tidak berfungsi dengan baik. Mohon maaf atas ketidaknyamanannya. ⚠️</marquee>
</div>
    <img id="background" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
    <div class="transform-3d">
        <header>
            <img src="{{ asset('images/logo-smk.jpg') }}" alt="Logo Sekolah" class="card-3d" />
            @if (Route::has('login'))
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
            @endif
        </header>

        <main>
            <div class="grid">
                <div class="card-3d">
                    <h2>Tujuan Pembuatan E-lerning</h2>
                    <p>E-learning ujian ini dirancang untuk membantu Anda mempersiapkan diri menghadapi berbagai ujian. Dengan materi yang komprehensif dan latihan soal yang relevan, tingkatkan kepercayaan diri Anda dan raih hasil terbaik.</p>
                </div>
                <div class="card-3d">
                    <h2>Visi dan Misi Pembuatan E-lerning</h2>
                    <p><strong>Visi:</strong> Menjadi platform e-learning ujian terdepan yang menghasilkan lulusan berprestasi.<br><strong>Misi:</strong> Menyediakan materi ujian berkualitas, akses belajar yang fleksibel, dan dukungan yang berkelanjutan bagi peserta didik.</p>
                </div>
                <div class="card-3d">
                    <h2>Website Sekolah</h2>
                    <p>Website sekolah ini adalah jendela digital kami ke dunia. Dapatkan informasi terkini, akses sumber daya pembelajaran, lihat profil sekolah, dan nikmati kemudahan komunikasi. Kami berkomitmen untuk menyediakan platform yang informatif, interaktif, dan mudah digunakan bagi seluruh komunitas sekolah.<br><br><strong>Link: <a href="https://www.smkgandasari.sch.id/" class="text-blue-500">https://www.smkgandasari.sch.id/</a></strong></p>
                </div>
            </div>
        </main>

        <div class="contact-info">
            <h2>Kontak</h2>
            <p><strong>Alamat:</strong> Jl. Raya Gandasari No.10</p>
            <p><strong>Telepon:</strong> (021) 123-456</p>
            <p><strong>Email:</strong> info@smkgandasari.sch.id</p>
        </div>
    </div>
</body>
</html>
