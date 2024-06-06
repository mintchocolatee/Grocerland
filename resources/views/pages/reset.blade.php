@extends('components.layout')

@section('content')
    <div class="reset-password-page">
        <div class="reset-password-container">
            <h1>Reset Password</h1>
            <form class="reset-password-form" action="{{ route('user.handleResetPassword') }}" method="POST">
                @csrf
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required>

                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>

                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <button type="submit">RESET PASSWORD</button>
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
    @endif

    <script>
        document.getElementById('close-btn').onclick = function() {
            window.location.href = "{{ route('user.login') }}";
        };
    </script>
@endsection
