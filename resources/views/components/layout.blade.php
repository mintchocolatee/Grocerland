<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/imageSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerAddProduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productDetail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
    <link rel="stylesheet" href="{{ asset('css/addFaq.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
</head>

<body>
    <header class="main-header">
        <span class="logo-container">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo-img">
        </span>
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search for products..." class="search-input">
            <button type="submit" class="search-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="search-icon" fill="#FFFFFF">
                    <path
                        d="M16.5 15h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L16.5 15zm-5 0C8.01 15 6 12.99 6 10.5S8.01 6 10.5 6 15 8.01 15 10.5 12.99 15 10.5 15z" />
                    <path fill="none" d="M0 0h24v24H0V0z" />
                </svg>
            </button>
        </form>
        <nav class="main-nav">
            <ul>
                <li><a href="{{ route('products.index') }}"
                        class="{{ Request::routeIs('products.index') ? 'active' : '' }}">Home</a></li>
                {{-- seller no cart page --}}
                <li><a href="../pages/cart.php">Cart</a></li>
                <li><a href="../pages/cart.php">Order</a></li>
                <li><a href="{{ route('faq.index') }}"
                        class="{{ Request::routeIs('faq.index') ? 'active' : '' }}">FAQ</a></li>
                <li><a href="{{ route('user.register') }}"
                        class="{{ Request::routeIs('user.register') ? 'active' : '' }}">Sign Up</a></li>
                <li><a href="{{ route('user.login') }}"
                        class="{{ Request::routeIs('user.login') ? 'active' : '' }}">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="contact-us">
                <h3>Contact Us</h3>
                <p><strong>Address:</strong> 775 Jalan 17/29 </p>
                <p><strong>Phone:</strong> +1 234 567 890</p>
                <p><strong>Email:</strong> <a href="shumin-shuhui@happy.com">shumin-shuhui@happy.com</a></p>
                <div class="social-media">
                    <a href="#"><img src="{{ asset('assets/images/fblogo.jpg') }}" alt="Facebook"></a>
                    <a href="#"><img src="{{ asset('assets/images/twitterlogo.jpg') }}" alt="Twitter"></a>
                    <a href="#"><img src="{{ asset('assets/images/iglogo.jpg') }}" alt="Instagram"></a>
                    <a href="#"><img src="{{ asset('assets/images/linkedinlogo.jpg') }}" alt="LinkedIn"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Grocerland. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/imageSlider.js') }}"></script>
</body>

</html>
