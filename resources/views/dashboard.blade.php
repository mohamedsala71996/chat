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
    <x-app-layout>


        <div class="py-12">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h1 class="display-3 heading mb-4">Welcome to Our Chat Site</h1>
                        <p class="lead description mb-5">This site is dedicated to providing a platform for engaging and
                            meaningful chats. Log in or register to join the conversation!</p>
                        @if (Route::has('login'))
                        <div class="pb-4">
                            @auth
                            {{-- <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Dashboard</a> --}}
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Log in</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                            @endif
                            @endauth
                        </div>
                        @endif
                        <!-- Routes for global chat -->
                        <h2 class="h4 mb-3">Global Chat:</h2>
                        <div class="pb-4">
                            <a href="{{ route('globalChat.index') }}" target="_blank" class="btn btn-info btn-lg">Join Global Chat</a>
                        </div>
                        @php
                        $users=\App\Models\User::where('id','!=',auth()->user()->id)->get();
                        @endphp
                        <!-- Routes for private chat -->
                        <h2 class="h4 mb-3">Private Chat with:</h2>
                        <div class="pb-4">
                            @foreach ($users as $user)
                            <a href="{{ route('chat.index', ['user_id' => $user->id]) }}" target="_blank" class="btn btn-success btn-lg">{{ $user->name }} </a>
                            <br>
                            <br>
                            @endforeach
                        </div>
                        <h2 class="h4 mb-3">Groups chat:</h2>
                        @if (auth()->user()->adminOfGroup()->count() < 1)
                        <form action="{{ route('groups.store') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">Create own group chat</button>
                            <br>
                            <br>
                        </form>
                        @endif
                        @php
                        $groups=\App\Models\Group::get();
                        @endphp
                        <div class="pb-4">
                            @foreach ($groups as $group)
                            <a href="{{ url("group/$group->id") }}" target="_blank" class="btn btn-success btn-lg">{{ $group->name }} </a>
                            <br>
                            <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
