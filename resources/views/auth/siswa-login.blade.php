<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 bg-white rounded shadow">
            <!-- Logo dan Nama Sekolah -->
            <div class="text-center mb-6">
            <img src="{{ asset('images/logo-smk.jpg') }}" alt="Logo Sekolah" class="mx-auto mb-2 w-24 h-24">
            <h1 class="text-xl font-bold text-gray-800">SMK GANDASARI</h1>
            </div>

            <h2 class="mb-6 text-lg font-medium text-center text-gray-700">Login Siswa dengan NISN & OTP</h2>
            
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('siswa.login.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="nisn" class="block mb-2 text-sm text-gray-600">Masukkan NISN</label>
                    <input type="text" name="nisn" id="nisn" 
                           class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Masukkan NISN" required>
                </div>
                <div class="mb-4">
                    <label for="otp" class="block mb-2 text-sm text-gray-600">Masukkan OTP</label>
                    <input type="text" name="otp" id="otp" 
                           class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Masukkan OTP" required>
                </div>
                <button type="submit" 
                        class="w-full p-3 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
