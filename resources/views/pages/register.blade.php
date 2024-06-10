@extends('components.layout')

@section('content')
    <div class="register-page">
        <div class="register-container">
            <h1>Sign Up</h1>
            <form class="register-form" action="{{ route('user.handleRegister') }}" method="POST">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <button type="submit" id="register-btn">REGISTER</button>
            </form>
        </div>
    </div>

    @if (Session::has('success_message'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Success!</h2>
                <p>{{ Session::get('success_message') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @elseif(Session::has('error'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Fail!</h2>
                <p>{{ Session::get('error') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @endif

    <script>
        document.getElementById('close-btn').onclick = function() {
            window.location.href = "{{ route('user.register') }}";
        };
    </script>
@endsection
