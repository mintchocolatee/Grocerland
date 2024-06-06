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
@endsection
