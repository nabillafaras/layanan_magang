@extends('layouts.header')

@section('title', 'Login Admin- Kementerian Sosial RI')

@section('additional_css')
<style>
    body {
        font-family: 'Calibri', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #F0F8FF;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .main-container {
        display: flex;
        width: 100%;
        max-width: 1100px;
        height: 80%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 70px;
    }

    .left-section {
        background-image: linear-gradient(rgba(139, 0, 0, 0.85), rgba(139, 0, 0, 0.85)), url('images/bg1.png');
        background-color: #8b0000;
        width: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .logo img {
        width: 150px;
    }

    .right-section {
        width: 50%;
        padding: 40px;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .right-section h2 {
        color: #8b0000;
        font-size: 26px;
        margin-bottom: 20px;
    }

    label {
        width: 100%;
        font-size: 14px;
        margin-bottom: 5px;
        color: #333;
        text-align: left;
        font-weight: 600;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input:focus {
        border-color: #8b0000;
        outline: none;
    }

    button.login-btn {
        width: 100%;
        padding: 12px;
        background-color: #8b0000;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button.login-btn:hover {
        background-color: #d32f2f;
    }

    .create-account {
        margin-top: 20px;
        font-size: 14px;
    }

    .create-account a {
        color: #8b0000;
        text-decoration: none;
        font-weight: bold;
    }

    .create-account a:hover {
        text-decoration: underline;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            height: auto;
        }

        .left-section, .right-section {
            width: 100%;
        }

        .right-section h2 {
            font-size: 22px;
        }

        .create-account {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
<body>
    <div class="main-container">
        <div class="left-section">
            <div class="logo">
                <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo Kemensos">
            </div>
        </div>

        <div class="right-section">
            <h2>Login Admin</h2>
            <form action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <div style="width: 100%">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username Admin" required>
            </div>

                <div class="password-container" style="width: 100%; position: relative; margin-bottom: 15px;">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" placeholder="Masukkan Password" 
                            required 
                            style="width: 100%; padding: 10px 40px 10px 15px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; font-size: 14px; transition: border-color 0.3s;">
                        <i class="fa fa-eye" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666; font-size: 16px;"
                            onclick="togglePasswordVisibility()"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>
            <!-- Bottom line dengan copyright dan admin link -->
            <div class="bg-[#700000] py-2">
                <div class="container mx-auto px-6 flex justify-between items-center">
                <p class="text-xs text-gray-300">Peserta? <a href="{{ route('login') }}" class="text-xs text-gray-300 hover:text-white transition-colors duration-200">
                        Login Disini </a>
                    </p>
                    <p class="text-xs text-gray-300">© 2024 Kementerian Sosial RI. All rights reserved.</p>
                </div>
            </div>
        </div>
        <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Cek tipe input, ubah dari password ke text, atau sebaliknya
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        
        // Ubah ikon mata tergantung tipe input
        if (type === 'password') {
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');
        } else {
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        }
    });
</script>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
@endsection


