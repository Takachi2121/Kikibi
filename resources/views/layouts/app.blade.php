<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KIKIBI - Solusi Hadiah Terbaik</title>
    <link rel="icon" href="{{ asset('assets/img/icon-tab.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        <header>
            {{-- Navbar --}}
            @include('components.navbar')
        </header>

        {{-- Content --}}
        <main style="margin-top: 79px">
            @yield('content')
        </main>

        <footer class="footer-wrap" style="background-color: #101828">
            @include('components.footer')
        </footer>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        AOS.init();
    </script>
</body>
</html>
