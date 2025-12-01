<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movie Login')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: url('https://png.pngtree.com/background/20211216/original/pngtree-real-shots-of-the-empty-and-spacious-theater-movie-theater-scenes-picture-image_1517322.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .auth-wrapper {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            color: #fff;
            backdrop-filter: blur(15px);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .auth-box input {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
        }

        .auth-box input::placeholder {
            color: #ccc;
        }

        .auth-box .btn {
            background-color: #e50914;
            border: none;
        }

        .auth-box a {
            color: #ccc;
            text-decoration: none;
        }

        .auth-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="auth-wrapper">
        <div class="auth-box">
            <h3 class="text-center mb-4">@yield('title')</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
