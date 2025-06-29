<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jurnal PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-green-500 text-white p-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-white/20 p-4 rounded-full">
                    <i class="fas fa-book-open text-3xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold">SISTEM JURNAL PKL</h1>
            <p class="mt-2 opacity-90">Masuk ke akun Anda</p>
        </div>
        
        <!-- Form -->
        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Nomor Induk/Nomor Pokok -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium" for="nl">
                        <i class="fas fa-id-card mr-2 text-blue-500"></i>NISN/NIPD/NI
                    </label>
                    <input id="ni" type="text" name="ni" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan NISN/NIPD/NI Anda">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2 font-medium" for="password">
                        <i class="fas fa-lock mr-2 text-blue-500"></i>Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Ingat saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-green-500 hover:from-blue-700 hover:to-green-600 text-white font-bold py-3 rounded-lg shadow-md transition duration-300">
                    Masuk
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 p-4 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} Sistem Jurnal PKL - SMK Bina Nusantara
        </div>
    </div>
</body>
</html>