<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EcoKnights – Empowering Sustainable Living</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/ecoknights-grayscale-icon.ico') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <nav>
            <div class="nav-container">
                <img src="{{ asset('images/hamburger-button.png') }}" alt="hamburger-button" class="nav-hamburger" id="navHamburger">
                <img src="{{ asset('images/ecoknights-grayscale.png') }}" alt="ecoknights-grayscale" class="nav-logo-left">

                <div class="nav-links nav-links-left">
                    <a href="{{ url('/ecoknights/home') }}">Home</a>
                    <a href="{{ route('get-update-profile') }}">Profile</a>
                    <a href="{{ route('get-create-volunteer') }}">Volunteer</a>
                    <a href="{{ route('get-create-feedback') }}">Feedback</a>
                </div>

                <div class="nav-links nav-links-right">
                    @if(session('user_id'))
                        <form method="POST" action="{{ route('post-log-out') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: white; font-family: inherit; font-size: inherit; font-weight: inherit; text-decoration: none; cursor: pointer; padding: 0; margin: 0;">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('get-log-in') }}">Log in</a>
                        <a href="{{ route('get-sign-up') }}">Sign up</a>
                    @endif
                </div>

                <img src="{{ asset('images/ecoknights-square-color.png') }}" alt="ecoknights-square-color" class="nav-logo-right">
            </div>
        </nav>

        <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

        <aside id="sidebar" class="sidebar">
            <button type="button" class="sidebar-close" aria-label="Close menu">&times;</button>
            <nav class="sidebar-links">
                <a href="{{ url('/ecoknights/home') }}">Home</a>
                <a href="{{ route('get-update-profile') }}">Profile</a>
                <a href="{{ route('get-create-volunteer') }}">Volunteer</a>
                <a href="{{ route('get-create-feedback') }}">Feedback</a>
                @if(session('user_id'))
                    <form method="POST" action="{{ route('post-log-out') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; font-family: inherit; font-size: inherit; font-weight: inherit; text-decoration: none; cursor: pointer; padding: 0; margin: 0;">Log out</button>
                    </form>
                @else
                    <a href="{{ route('get-log-in') }}">Log in</a>
                    <a href="{{ route('get-sign-up') }}">Sign up</a>
                @endif
            </nav>
        </aside>

        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>

        <footer>
            <div class="container">
                <p><strong>Contact us</strong> (+60) 012 345 6789</p>
                <p>© 2025 EcoKnights. All rights reserved.</p>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                const hamburger = document.getElementById('navHamburger');
                const closeBtn = sidebar.querySelector('.sidebar-close');

                const toggleSidebar = (show) => {
                    sidebar.classList.toggle('is-open', show);
                    backdrop.classList.toggle('is-active', show);
                    document.body.classList.toggle('no-scroll', show);
                };

                hamburger.addEventListener('click', () => toggleSidebar(true));
                closeBtn.addEventListener('click', () => toggleSidebar(false));
                backdrop.addEventListener('click', () => toggleSidebar(false));
                window.addEventListener('keydown', (evt) => {
                    if (evt.key === 'Escape') toggleSidebar(false);
                });
            });
        </script>
    </body>
</html>