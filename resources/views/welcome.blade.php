<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->
    <style>
        /* Additional custom styles for enhanced appearance */
        .heading {
            color: #4a5568;
        }

        .description {
            color: #6b7280;
        }
    </style>
</head>
<body class="antialiased">
<div class="container-fluid bg-light min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <h1 class="display-3 heading mb-4">Welcome to Our Chat Site</h1>
            <p class="lead description mb-5">This site is dedicated to providing a platform for engaging and meaningful chats. Log in or register to join the conversation!</p>
            @if (Route::has('login'))
                <div class="pb-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
