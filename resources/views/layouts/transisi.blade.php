
<div class="preloader">
    <div class="loader">
        <div class="logo-wrapper">
            <img src="{{ asset('images/ic_kemensos_1.png') }}" alt="Logo Kemensos">
        </div>
        <div class="loading-text">Memuat...</div>
    </div>
</div>

<style>
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    
    .preloader.fade-out {
        opacity: 0;
        visibility: hidden;
    }
    
    .loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .logo-wrapper {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        animation: pulse 1.5s infinite alternate;
    }
    
    .logo-wrapper img {
        width: 80px;
        height: auto;
    }
    
    .loading-text {
        font-size: 16px;
        font-weight: 500;
        color: #8b0000;
        letter-spacing: 2px;
        position: relative;
    }
    
    .loading-text::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #8b0000, #FFD700);
        animation: loading 2s infinite;
        border-radius: 10px;
    }
    
    @keyframes loading {
        0% {
            width: 0%;
            left: 0;
        }
        50% {
            width: 100%;
            left: 0;
        }
        100% {
            width: 0%;
            left: 100%;
        }
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.95);
        }
        100% {
            transform: scale(1.05);
        }
    }
</style>

<script>
    // Preloader animation
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        setTimeout(function() {
            preloader.classList.add('fade-out');
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        }, 1000);
    });
</script>