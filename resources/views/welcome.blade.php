@extends('layouts.master')

@section('title', 'Selamat Datang di WeMaTuK')

@section('content')
    <style>

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .welcome-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 4rem 3rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            max-width: 600px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .welcome-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Icon */
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .icon-wrapper:hover {
            transform: scale(1.05) rotate(3deg);
        }

        .welcome-icon {
            width: 40px;
            height: 40px;
            color: #ffffff;
        }

        /* Typography */
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .brand-name {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #718096;
            text-align: center;
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .btn-elegant {
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-elegant {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .btn-primary-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            color: #ffffff;
        }

        .btn-secondary-elegant {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary-elegant:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            color: #2d3748;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #a0aec0;
            font-size: 0.875rem;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 1rem;
        }

        /* Features */
        .features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding-top: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
            font-size: 0.9rem;
        }

        .feature-icon {
            width: 18px;
            height: 18px;
            color: #4a90e2;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 3rem 2rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .welcome-subtitle {
                font-size: 1rem;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-elegant {
                width: 100%;
                justify-content: center;
            }

            .features {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>

    <div class="welcome-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="welcome-card" id="welcomeCard">

                        <!-- Icon -->
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="welcome-icon"
                                viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                            </svg>
                        </div>

    
                        <h1 class="welcome-title">
                            {{-- Selamat Datang di<br> --}}
                            <span class="brand-name">WeMaTuK</span>
                        </h1>

                        <p class="welcome-subtitle">
                           Website Manajemen Tugas Kuliah.
                        </p>

                        <!-- Buttons -->
                        <div class="btn-group">
                            <a href="{{ route('login') }}" class="btn-elegant btn-primary-elegant">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="btn-elegant btn-secondary-elegant">
                                <i class="bi bi-person-plus"></i>
                                Register
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animation
            const card = document.getElementById('welcomeCard');
            setTimeout(() => {
                card.classList.add('show');
            }, 150);

            // Smooth button interactions
            const buttons = document.querySelectorAll('.btn-elegant');
            buttons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
@endsection