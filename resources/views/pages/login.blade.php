@extends('components.layout')

@section('content')
    <div class="login-page">
        <div class="login-container">
            @if (auth()->check())
                <h1>Logged In</h1>
                <p>Welcome , {{ auth()->user()->name }} ! You are already logged in.</p>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            @else
                <h1>Login</h1>
                <p>Doesn’t have an account yet? <a href="{{ route('user.register') }}">Sign Up</a></p>
                <form class="login-form" action="{{ route('user.handleLogin') }}" method="POST">
                    @csrf
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <a href="{{ route('user.resetPassword') }}" class="forgot-password">Forgot password?</a>

                    <button type="submit">LOGIN</button>
                </form>
            @endif
        </div>
    </div>
    @if (session('success'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Success!</h2>
                <p>{{ Session::get('success') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @elseif (session('error'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Fail to add!</h2>
                <p>{{ Session::get('error') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @endif
    <script>
        document.getElementById('close-btn').onclick = function() {
            window.location.href = "{{ route('user.login') }}";
        };
    </script>
@endsection
