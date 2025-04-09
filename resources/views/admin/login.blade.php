@extends('layouts.header')

@section('title', 'Login - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Modern Variable Colors */
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease;
    }


    .login-container {
        display: flex;
        width: 100%;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .main-container {
        display: flex;
        width: 100%;
        max-width: 1100px;
        min-height: 600px;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        z-index: 1;
        background-color: white;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .left-section {
        background-image: linear-gradient(135deg, rgba(139, 0, 0, 0.9) 0%, rgba(100, 0, 0, 0.85) 100%), url('images/bg1.png');
        background-size: cover;
        background-position: center;
        width: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 40px;
        color: var(--text-light);
    }

    /* Animated particles effect */
    .left-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkQ3MDAiIGZpbGwtb3BhY2l0eT0iMC4xNSIvPjwvcGF0dGVybj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.4;
        z-index: 0;
        animation: moveBackground 20s linear infinite;
    }

    @keyframes moveBackground {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 100px 100px;
        }
    }

    /* Animated Shapes */
    .shape {
        position: absolute;
        z-index: 0;
        opacity: 0.5;
    }
    
    .shape-1 {
        top: 10%;
        left: 10%;
        width: 50px;
        height: 50px;
        background: var(--secondary-color);
        border-radius: 50%;
        animation: floatAnimation 8s infinite alternate;
    }
    
    .shape-2 {
        bottom: 20%;
        right: 10%;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transform: rotate(45deg);
        animation: floatAnimation 12s infinite alternate-reverse;
    }
    
    @keyframes floatAnimation {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }
        50% {
            transform: translate(20px, 20px) rotate(10deg);
        }
        100% {
            transform: translate(-20px, 10px) rotate(-10deg);
        }
    }

    .logo {
        position: relative;
        z-index: 1;
        text-align: center;
        margin-bottom: 30px;
    }

    .logo img {
        width: 180px;
        filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        transition: var(--transition);
        animation: pulse 3s infinite alternate;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.05);
        }
    }

    .logo img:hover {
        transform: scale(1.05);
    }

    .left-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 400px;
    }

    .left-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        position: relative;
        display: inline-block;
    }

    .left-content h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--secondary-color);
        border-radius: 10px;
        animation: expandWidth 1.5s ease-out forwards;
    }
    
    @keyframes expandWidth {
        from { width: 0; }
        to { width: 80px; }
    }

    .left-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 30px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .right-section {
        width: 50%;
        padding: 60px 40px;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .login-form-container {
        width: 100%;
        max-width: 400px;
    }

    .right-section h2 {
        color: var(--primary-color);
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        display: inline-block;
    }

    .right-section h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--secondary-color);
        border-radius: 10px;
        animation: expandWidth 1.5s ease-out forwards;
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    label {
        display: block;
        font-size: 1rem;
        margin-bottom: 8px;
        color: var(--text-dark);
        font-weight: 600;
        transition: var(--transition);
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f9f9f9;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        outline: none;
        background-color: white;
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        font-size: 1.2rem;
        transition: var(--transition);
        z-index: 2;
    }

    .toggle-password:hover {
        color: var(--primary-color);
    }

    .login-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #a40000 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
        margin-top: 10px;
    }

    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.42, 0, 0.58, 1);
        z-index: -1;
    }

    .login-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(139, 0, 0, 0.3);
    }

    .login-btn:hover::before {
        width: 100%;
    }

    .login-btn i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .login-btn:hover i {
        transform: translateX(5px);
    }

    .footer-links {
        margin-top: 30px;
        text-align: center;
        width: 100%;
    }

    .footer-links p {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }

    .footer-links a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .footer-links a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .copyright {
        margin-top: 20px;
        font-size: 0.8rem;
        color: #999;
    }

    .alert {
        padding: 15px;
        margin-top: 20px;
        border-radius: 12px;
        font-size: 0.9rem;
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-danger {
        background-color: #fff5f5;
        color: #e53e3e;
        border-left: 4px solid #e53e3e;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .main-container {
            max-width: 90%;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            max-width: 95%;
        }

        .left-section, .right-section {
            width: 100%;
            padding: 40px 20px;
        }

        .left-section {
            min-height: 300px;
        }

        .logo img {
            width: 150px;
        }

        .left-content h1 {
            font-size: 2rem;
        }

        .left-content p {
            font-size: 1rem;
        }

        .right-section h2 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .login-container {
            padding: 20px 10px;
        }

        .main-container {
            min-height: auto;
        }

        .left-section {
            min-height: 250px;
            padding: 30px 15px;
        }

        .right-section {
            padding: 30px 15px;
        }

        .logo img {
            width: 120px;
        }

        .left-content h1 {
            font-size: 1.8rem;
        }

        .right-section h2 {
            font-size: 1.6rem;
        }

        .form-control {
            padding: 12px;
        }

        .login-btn {
            padding: 12px;
        }
    }
</style>
@endsection

@section('content')
@include('layouts.transisi')
<div class="login-container">
    <div class="main-container">
        <div class="left-section">
            <!-- Animated Shapes -->
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            
            <div class="logo" data-aos="fade-down" data-aos-delay="100">
                <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo Kemensos">
            </div>
            
            <div class="left-content" data-aos="fade-up" data-aos-delay="200">
                <h1>Selamat Datang</h1>
                <p>Silakan login untuk mengakses sistem informasi magang Kementerian Sosial Republik Indonesia</p>
            </div>
        </div>

        <div class="right-section">
            <div class="login-form-container">
                <h2 data-aos="fade-up">Login Admin</h2>
                
                <form action="{{ route('admin.authenticate') }}" method="POST" data-aos="fade-up" data-aos-delay="100">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="footer-links" data-aos="fade-up" data-aos-delay="200">
                    <p>Peserta? <a href="{{ route('login') }}">Login Disini</a></p>
                    <p class="copyright">© 2025 Kementerian Sosial RI. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
        
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            
            // Add animation
            this.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                this.style.transform = 'rotate(0deg)';
            }, 300);
        });
        
        // Add focus animations
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('label')?.classList.add('text-primary');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('label')?.classList.remove('text-primary');
            });
        });
        
        // Add button animation
        const loginBtn = document.querySelector('.login-btn');
        loginBtn.addEventListener('mouseenter', function() {
            this.querySelector('i').style.transform = 'translateX(5px)';
        });
        
        loginBtn.addEventListener('mouseleave', function() {
            this.querySelector('i').style.transform = 'translateX(0)';
        });
    });
</script>
@endsection