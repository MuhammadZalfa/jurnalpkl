<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Jurnal PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar-item {
            transition: all 0.2s;
        }
        .sidebar-item:hover {
            transform: translateX(5px);
        }
        .hamburger-line {
            transition: all 0.3s;
        }
        .hamburger-active > span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .hamburger-active > span:nth-child(2) {
            opacity: 0;
        }
        .hamburger-active > span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -8px);
        }
    </style>
    {{ $head ?? '' }}
</head>
<body class="bg-gray-50 min-h-screen flex">
    {{ $slot }}
    
    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
    
    <script>
        // Toggle mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileOverlay = document.getElementById('mobile-overlay');
        
        if (mobileMenuButton && mobileOverlay) {
            mobileMenuButton.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('hidden');
                document.querySelector('.sidebar').classList.toggle('fixed');
                document.querySelector('.sidebar').classList.toggle('z-50');
                mobileOverlay.classList.toggle('hidden');
                mobileMenuButton.classList.toggle('hamburger-active');
            });
            
            mobileOverlay.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.add('hidden');
                document.querySelector('.sidebar').classList.remove('fixed');
                document.querySelector('.sidebar').classList.remove('z-50');
                mobileOverlay.classList.add('hidden');
                mobileMenuButton.classList.remove('hamburger-active');
            });
        }
    </script>
</body>
</html>