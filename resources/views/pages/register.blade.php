@extends('components.layout')

@section('content')
    <div class="register-page">
        <div class="register-container">
            <h1>Register</h1>
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

    <!-- Popup message modal -->
    <div id="popup-message" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>{{ Session::get('verification_message') }}</p>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('popup-message');

        // Get the close button
        var closeBtn = document.getElementsByClassName('close')[0];

        // When the page loads, check if the message is present and show the modal
        window.onload = function() {
            if ("{{ Session::has('verification_message') }}") {
                modal.style.display = 'block';
            }
        };

        // When the user clicks on the close button, hide the modal
        closeBtn.onclick = function() {
            modal.style.display = 'none';
            window.location.href = "{{ route('user.login') }}";
        };
    </script>
@endsection
