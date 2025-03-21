<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Animation</title>
    <style>
        /* CSS untuk overlay loading */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Warna latar belakang halaman */
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang semi-transparan */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Pastikan di atas semua konten lainnya */
            visibility: visible;
            opacity: 1;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        .spinner {
            position: relative;
            width: 80px; /* Ukuran spinner yang lebih besar */
            height: 80px;
            border: 8px solid #f3f3f3; /* Warna abu-abu muda */
            border-top: 8px solid #3498db; /* Warna utama */
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
        }

        /* Animasi spinner */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-overlay.hidden {
            visibility: hidden;
            opacity: 0;
        }

        /* Gambar di tengah spinner */
        .loading-overlay img {
            position: absolute;
            width: 40px; /* Ukuran gambar yang lebih besar */
            height: 40px;
            object-fit: contain;
            z-index: 10; /* Pastikan gambar berada di atas spinner */
            animation: bounce 0.6s infinite alternate; /* Animasi bounce untuk gambar */
        }

        /* Animasi bounce untuk gambar */
        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <!-- Animasi Loading -->
    <div id="loading" class="loading-overlay">
        <div class="spinner">
            <img src="images/ic_kemensos_1.png" alt="Loading Image">
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            // Menyembunyikan elemen loading setelah halaman selesai dimuat
            const loadingOverlay = document.getElementById('loading');
            if (loadingOverlay) {
                setTimeout(() => {
                    loadingOverlay.classList.add('hidden');
                }, 500); // Delay 500ms agar loading tetap terlihat sebentar
            }
        });
    </script>
</body>
</html>