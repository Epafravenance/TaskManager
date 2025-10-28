<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Organize Your Tasks</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
            color: #1b1b18;
            background: #FDFDFC;
            overflow-x: hidden;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #0a0a0a;
                color: #EDEDEC;
            }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(253, 253, 252, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(25, 20, 0, 0.06);
            z-index: 1000;
        }

        @media (prefers-color-scheme: dark) {
            nav {
                background: rgba(10, 10, 10, 0.95);
                border-bottom: 1px solid #3E3E3A;
            }
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1b1b18;
            letter-spacing: -0.02em;
        }

        @media (prefers-color-scheme: dark) {
            .logo {
                color: #EDEDEC;
            }
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 0.25rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s;
            display: inline-block;
            border: 1px solid transparent;
        }

        .nav-btn-secondary {
            color: #1b1b18;
            border-color: transparent;
        }

        .nav-btn-secondary:hover {
            border-color: rgba(25, 20, 0, 0.13);
        }

        .nav-btn-primary {
            color: #1b1b18;
            border-color: rgba(25, 20, 0, 0.13);
        }

        .nav-btn-primary:hover {
            border-color: rgba(25, 20, 0, 0.29);
        }

        @media (prefers-color-scheme: dark) {
            .nav-btn-secondary {
                color: #EDEDEC;
            }

            .nav-btn-secondary:hover {
                border-color: #3E3E3A;
            }

            .nav-btn-primary {
                color: #EDEDEC;
                border-color: #3E3E3A;
            }

            .nav-btn-primary:hover {
                border-color: #62605b;
            }
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 5% 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(245, 48, 3, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        @media (prefers-color-scheme: dark) {
            .hero::before {
                background: radial-gradient(circle, rgba(255, 117, 15, 0.12) 0%, transparent 70%);
            }
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(248, 184, 3, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero p {
            font-size: clamp(1.125rem, 2vw, 1.375rem);
            color: #706f6c;
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 0.8s ease-out 0.2s backwards;
        }

        @media (prefers-color-scheme: dark) {
            .hero p {
                color: #A1A09A;
            }
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.4s backwards;
        }

        .hero-btn {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.2s;
            display: inline-block;
            border: 1px solid;
        }

        .hero-btn-primary {
            background: #1b1b18;
            color: white;
            border-color: #1b1b18;
        }

        .hero-btn-primary:hover {
            background: black;
            border-color: black;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        @media (prefers-color-scheme: dark) {
            .hero-btn-primary {
                background: #eeeeec;
                color: #1C1C1A;
                border-color: #eeeeec;
            }

            .hero-btn-primary:hover {
                background: white;
                border-color: white;
            }
        }

        .hero-btn-secondary {
            background: transparent;
            color: #1b1b18;
            border-color: rgba(25, 20, 0, 0.13);
        }

        .hero-btn-secondary:hover {
            border-color: rgba(25, 20, 0, 0.29);
            transform: translateY(-2px);
        }

        @media (prefers-color-scheme: dark) {
            .hero-btn-secondary {
                color: #EDEDEC;
                border-color: #3E3E3A;
            }

            .hero-btn-secondary:hover {
                border-color: #62605b;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Features Section */
        .features {
            padding: 5rem 5%;
            background: #f8f9fa;
        }

        @media (prefers-color-scheme: dark) {
            .features {
                background: #161615;
            }
        }

        .section-title {
            text-align: center;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.125rem;
            color: #706f6c;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (prefers-color-scheme: dark) {
            .section-subtitle {
                color: #A1A09A;
            }
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            border: 1px solid rgba(25, 20, 0, 0.06);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(25, 20, 0, 0.13);
        }

        @media (prefers-color-scheme: dark) {
            .feature-card {
                background: #1b1b18;
                border-color: #3E3E3A;
            }

            .feature-card:hover {
                border-color: #62605b;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            }
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #1b1b18;
        }

        @media (prefers-color-scheme: dark) {
            .feature-card h3 {
                color: #EDEDEC;
            }
        }

        .feature-card p {
            color: #706f6c;
            line-height: 1.7;
        }

        @media (prefers-color-scheme: dark) {
            .feature-card p {
                color: #A1A09A;
            }
        }

        /* CTA Section */
        .cta {
            padding: 6rem 5%;
            text-align: center;
            background: #fff2f2;
            position: relative;
            overflow: hidden;
        }

        @media (prefers-color-scheme: dark) {
            .cta {
                background: #1D0002;
            }
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(245, 48, 3, 0.05) 0%, transparent 50%);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .cta p {
            font-size: 1.25rem;
            color: #706f6c;
            margin-bottom: 2rem;
        }

        @media (prefers-color-scheme: dark) {
            .cta p {
                color: #A1A09A;
            }
        }

        /* Footer */
        footer {
            background: #1b1b18;
            color: #A1A09A;
            padding: 3rem 5%;
            text-align: center;
            font-size: 0.875rem;
        }

        @media (prefers-color-scheme: dark) {
            footer {
                background: #161615;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem 5%;
            }

            .nav-links {
                gap: 0.5rem;
            }

            .hero {
                padding: 6rem 5% 3rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-btn {
                width: 100%;
            }

            .features {
                padding: 3rem 5%;
            }

            .cta {
                padding: 4rem 5%;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">TaskFlow</div>
        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-btn nav-btn-primary">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-secondary">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Organize Your Life,<br>One Task at a Time</h1>
            <p>The elegant task management system that helps you stay productive and focused on what truly matters.
                Simple, powerful, and built for modern workflows.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">Get Started Free</a>
                <a href="#features" class="hero-btn hero-btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">Everything you need to succeed</h2>
        <p class="section-subtitle">Powerful features designed to help you manage tasks effortlessly and boost your
            productivity.</p>
        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">✨</span>
                <h3>Intuitive Task Creation</h3>
                <p>Create and organize tasks in seconds with our clean, distraction-free interface. Add details, set
                    priorities, and stay on top of deadlines.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🎯</span>
                <h3>Smart Prioritization</h3>
                <p>Focus on what matters most with intelligent priority management. Keep your most important tasks front
                    and center, always.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📊</span>
                <h3>Progress Tracking</h3>
                <p>Visualize your productivity with detailed insights and analytics. Track completion patterns and
                    celebrate your achievements.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🔔</span>
                <h3>Intelligent Reminders</h3>
                <p>Never miss a deadline with smart notifications that keep you informed without overwhelming you.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🌓</span>
                <h3>Dark Mode Ready</h3>
                <p>Beautiful light and dark themes that adapt to your preferences, ensuring comfort during extended work
                    sessions.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">⚡</span>
                <h3>Lightning Fast</h3>
                <p>Built with Laravel for exceptional performance. Access your tasks instantly, anytime, anywhere.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to boost your productivity?</h2>
            <p>Join thousands of productive individuals who trust TaskFlow to organize their work and life.</p>
            <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">Start Your Journey Today</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} TaskFlow. All rights reserved. Crafted with Laravel.</p>
    </footer>
</body>

</html>