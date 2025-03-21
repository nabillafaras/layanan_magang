<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Magang Kemensos RI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #8b0000;
            --primary-hover: #a00000;
            --secondary-color: #FFD700;
            --text-light: #ffffff;
            --text-dark: #333333;
            --bg-light: #f8f9fa;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Calibri', sans-serif;
            overflow-x: hidden;
            color: var(--text-dark);
            background-image: linear-gradient(rgba(139, 0, 0, 0.85), rgba(139, 0, 0, 0.85)), url('images/bg1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .card {
            width: 100%;
            max-width: 550px;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 20px auto;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }
        
        h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2rem;
            text-align: center;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            text-align: center;
        }
        
        .progress-container {
            margin-bottom: 2.5rem;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            color: var(--text-dark);
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: var(--transition);
            border: 2px solid transparent;
        }
        
        .circle.bg-primary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 0 5px rgba(255, 215, 0, 0.3);
        }
        
        .step-label {
            margin-top: 8px;
            font-weight: 600;
            color: #666;
            transition: var(--transition);
        }
        
        .step.active .step-label {
            color: var(--primary-color);
        }
        
        .line {
            height: 3px;
            background-color: #e9ecef;
            flex-grow: 1;
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }
        
        .line.bg-primary {
            background-color: var(--secondary-color);
        }
        
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-step.active {
            display: block;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            transition: var(--transition);
            margin-bottom: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.2);
            background-color: white;
            outline: none;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            top: 40px;
            left: 15px;
            color: var(--primary-color);
            z-index: 10;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 100%;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(255, 215, 0, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #e6c300;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 215, 0, 0.4);
        }
        
        .btn-secondary {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            box-shadow: 0 4px 10px rgba(139, 0, 0, 0.3);
            margin-bottom: 10px;
        }
        
        .btn-secondary:hover {
            background-color: var(--primary-hover);
            color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(139, 0, 0, 0.4);
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }
        
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .custom-file-upload {
            border: 1px dashed var(--primary-color);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background-color: rgba(139, 0, 0, 0.05);
        }
        
        .custom-file-upload:hover {
            background-color: rgba(139, 0, 0, 0.1);
        }
        
        .upload-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .file-upload-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .form-feedback {
            font-size: 0.85rem;
            color: #dc3545;
            display: none;
            margin-top: 0.25rem;
        }
        
        .is-invalid ~ .form-feedback {
            display: block;
        }
        
        .fixed-height-upload {
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .btn-icon i {
            margin-right: 8px;
        }
        
        .d-grid {
            display: grid;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
        
        .mt-4 {
            margin-top: 1.5rem;
        }
        
        /* Responsif untuk layar kecil */
        @media (max-width: 576px) {
            .card {
                padding: 1.5rem;
            }
            
            .progress-container {
                margin-bottom: 1.5rem;
            }
            
            .circle {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }
            
            .step-label {
                font-size: 0.8rem;
            }
            
            h3 {
                font-size: 1.75rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
@include('layouts.transisi')
    <div class="card">
        <h3>Pendaftaran Magang</h3>
        <p class="subtitle">Ayo daftarkan diri Anda menjadi peserta magang di Kemensos RI</p>
        
        <div class="progress-container">
            <div class="step active">
                <div class="circle bg-primary">1</div>
                <div class="step-label">Data Diri</div>
            </div>
            <div class="line"></div>
            <div class="step">
                <div class="circle">2</div>
                <div class="step-label">Akademik</div>
            </div>
            <div class="line"></div>
            <div class="step">
                <div class="circle">3</div>
                <div class="step-label">Penempatan</div>
            </div>
        </div>
        
        <!-- Form -->
        <form id="registrations" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="step" id="step" value="1">

            <!-- Step 1: Data Diri -->
            <div id="step-1" class="form-step active">
                <div class="input-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                    <div class="form-feedback">Nama lengkap wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                    <i class="fas fa-calendar-alt input-icon"></i>
                    <input type="text" class="form-control" id="ttl" name="ttl" placeholder="Contoh: Jakarta, 15 Januari 2000" required>
                    <div class="form-feedback">Tempat, tanggal lahir wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <i class="fas fa-venus-mars input-icon"></i>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div class="form-feedback">Jenis kelamin wajib dipilih</div>
                </div>
                
                <div class="input-group">
                    <label for="no_hp" class="form-label">No Handphone</label>
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required pattern="\d{10,15}" title="Masukkan nomor handphone yang valid (10-15 digit)">
                    <div class="form-feedback">Nomor handphone wajib diisi (10-15 digit)</div>
                </div>
                
                <div class="input-group">
                    <label for="email" class="form-label">Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: nama@email.com" required>
                    <div class="form-feedback">Email wajib diisi dengan format yang benar</div>
                </div>
                
                <button type="button" class="btn btn-primary mt-4 btn-icon" id="next-to-step-2">
                    <i class="fas fa-arrow-right"></i> Selanjutnya
                </button>
            </div>

            <!-- Step 2: Akademik -->
            <div id="step-2" class="form-step">
                <div class="input-group">
                    <label for="asal_universitas" class="form-label">Asal Universitas</label>
                    <i class="fas fa-university input-icon"></i>
                    <input type="text" class="form-control" id="asal_universitas" name="asal_universitas" placeholder="Masukkan nama universitas" required>
                    <div class="form-feedback">Asal universitas wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <i class="fas fa-book input-icon"></i>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukkan jurusan" required>
                    <div class="form-feedback">Jurusan wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <i class="fas fa-graduation-cap input-icon"></i>
                    <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan program studi" required>
                    <div class="form-feedback">Program studi wajib diisi</div>
                </div>
                
                <div class="input-group">
                    <label for="semester" class="form-label">Semester</label>
                    <i class="fas fa-user-graduate input-icon"></i>
                    <input type="number" class="form-control" id="semester" name="semester" placeholder="Masukkan semester saat ini" required min="1" title="Semester minimal 1">
                    <div class="form-feedback">Semester wajib diisi (minimal 1)</div>
                </div>
                
                <div class="input-group">
                    <label for="ipk" class="form-label">IPK</label>
                    <i class="fas fa-award input-icon"></i>
                    <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" placeholder="Contoh: 3.50" required min="0" max="4" title="IPK harus antara 0 dan 4">
                    <div class="form-feedback">IPK wajib diisi (0.00 - 4.00)</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="transkrip_nilai" class="form-label">Unggah Transkrip Nilai</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-pdf upload-icon"></i>
                        <p class="mb-0" id="transkrip-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="transkrip_nilai" name="transkrip_nilai" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">Transkrip nilai wajib diunggah</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="surat_pengantar" class="form-label">Unggah Surat Pengantar Universitas</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-alt upload-icon"></i>
                        <p class="mb-0" id="surat-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="surat_pengantar" name="surat_pengantar" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">Surat pengantar wajib diunggah</div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-secondary btn-icon" id="back-to-step-1">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-primary btn-icon" id="next-to-step-3">
                        <i class="fas fa-arrow-right"></i> Selanjutnya
                    </button>
                </div>
            </div>

            <!-- Step 3: Penempatan -->
            <div id="step-3" class="form-step">
                <div class="input-group">
                    <label for="direktorat" class="form-label">Direktorat</label>
                    <i class="fas fa-building input-icon"></i>
                    <select class="form-select" id="direktorat" name="direktorat" required>
                        <option value="">Pilih direktorat</option>
                        <option value="Direktorat 1">Direktorat 1</option>
                        <option value="Direktorat 2">Direktorat 2</option>
                        <option value="Direktorat 3">Direktorat 3</option>
                        <option value="Direktorat 4">Direktorat 4</option>
                        <option value="Direktorat 5">Direktorat 5</option>
                    </select>
                    <div class="form-feedback">Direktorat wajib dipilih</div>
                </div>
                
                <div class="input-group">
                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                    <i class="fas fa-briefcase input-icon"></i>
                    <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" placeholder="Masukkan unit kerja" required>
                    <div class="form-feedback">Unit kerja wajib diisi</div>
                </div>
                
                <div class="file-upload-wrapper">
                    <label for="cv" class="form-label">Unggah CV</label>
                    <div class="custom-file-upload fixed-height-upload">
                        <i class="fas fa-file-contract upload-icon"></i>
                        <p class="mb-0" id="cv-label">Klik atau seret file PDF/JPG/PNG</p>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.jpg,.png" required>
                    </div>
                    <div class="form-feedback">CV wajib diunggah</div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-secondary btn-icon" id="back-to-step-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-success btn-icon" id="submit-final">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk mengubah status progres
        function updateProgress(currentStep, nextStep) {
            document.getElementById(`circle-step-${currentStep}`).classList.remove('bg-primary');
            document.getElementById(`circle-step-${nextStep}`).classList.add('bg-primary');

            const steps = document.querySelectorAll('.step');
            steps.forEach(step => step.classList.remove('active'));
            steps[nextStep - 1].classList.add('active');

            if (nextStep > currentStep) {
                document.getElementById(`line-step-${currentStep}`).classList.add('bg-primary');
            } else {
                document.getElementById(`line-step-${currentStep - 1}`).classList.remove('bg-primary');
            }
        }

        // Fungsi untuk menampilkan langkah form
        function showStep(currentStep, nextStep) {
            document.getElementById(`step-${currentStep}`).classList.add('d-none');
            document.getElementById(`step-${currentStep}`).classList.remove('active');

            document.getElementById(`step-${nextStep}`).classList.add('active');
            document.getElementById(`step-${nextStep}`).classList.remove('d-none');

            updateProgress(currentStep, nextStep);
            document.getElementById('step').value = nextStep;
        }

        // Fungsi untuk validasi setiap langkah
        function validateStep(step) {
            const inputs = document.querySelectorAll(`#step-${step} input, #step-${step} select`);
            let isValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.checkValidity()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    
                    // Tambahkan fokus ke input pertama yang tidak valid
                    if (document.querySelector('.is-invalid') === input) {
                        input.focus();
                    }
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Event listeners untuk navigasi langkah-langkah form
        document.getElementById('next-to-step-2').addEventListener('click', function () {
            if (validateStep(1)) {
                showStep(1, 2);
            }
        });

        document.getElementById('back-to-step-1').addEventListener('click', function () {
            showStep(2, 1);
        });

        document.getElementById('next-to-step-3').addEventListener('click', function () {
            if (validateStep(2)) {
                showStep(2, 3);
            }
        });

        document.getElementById('back-to-step-2').addEventListener('click', function () {
            showStep(3, 2);
        });
        
        // Event listener untuk pengiriman form
        document.getElementById('submit-final').addEventListener('click', function (e) {
            e.preventDefault();
            if (validateStep(3)) {
                let form = document.getElementById('registrations');
                let formData = new FormData(form);
                formData.append('step', '3');

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert('Terjadi kesalahan saat menyimpan data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data');
                });
            }
        });
        
        // Event listeners untuk menampilkan nama file yang diunggah
        document.getElementById('transkrip_nilai').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            document.getElementById('transkrip-label').textContent = fileName;
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('surat_pengantar').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            document.getElementById('surat-label').textContent = fileName;
            this.classList.remove('is-invalid');
        });
        
        document.getElementById('cv').addEventListener('change', function() {
            const fileName = this.files[0]?.name || "Klik atau seret file PDF/JPG/PNG";
            document.getElementById('cv-label').textContent = fileName;
            this.classList.remove('is-invalid');
        });
        
        // Hapus pesan kesalahan saat input berubah
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>