<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Calibri, sans-serif;
            background-color: #a40000; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #dee2e6;
            color: black;
        }
        .circle.bg-primary {
            background-color: #a40000;
            color: white;
        }
        .line {
            height: 2px;
            width: 100%;
            background-color: #dee2e6;
        }
        .line.bg-primary {
            background-color: #a40000;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .btn-primary {
            background-color: #FFD700;
            color: #8b0000;
            border-radius: 5px;
            border: none;
        }
        .btn-primary:hover {
            background-color: #FFD700;
        }
        .btn-secondary {
            background-color: #a00000;
            color: #FFD700;
            border-radius: 5px;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .is-invalid {
            border-color: red;
        }
    </style>
</head>
<body>

    <div class="card">
        <h3 class="text-center">Pendaftaran</h3>
        <p class="text-center text-muted">Ayo daftarkan diri Anda menjadi peserta magang di Kemensos RI</p>

        <!-- Progress Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="step text-center">
                <div class="circle bg-primary text-white" id="circle-step-1">1</div>
                <small>Step 1</small>
            </div>
            <div class="line bg-secondary" id="line-step-1"></div>
            <div class="step text-center">
                <div class="circle bg-secondary text-white" id="circle-step-2">2</div>
                <small>Step 2</small>
            </div>
            <div class="line bg-secondary" id="line-step-2"></div>
            <div class="step text-center">
                <div class="circle bg-secondary text-white" id="circle-step-3">3</div>
                <small>Step 3</small>
            </div>
        </div>

        <!-- Form -->
        <form id="registrations" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="step" id="step" value="1">

            <!-- Step 1 -->
            <div id="step-1" class="form-step active">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="ttl" class="form-label">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control" id="ttl" name="ttl" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No Handphone</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required pattern="\d{10,15}" title="Masukkan nomor handphone yang valid (10-15 digit)">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="button" class="btn btn-primary w-100" id="next-to-step-2">Selanjutnya</button>
            </div>

            <!-- Step 2 -->
            <div id="step-2" class="form-step">
                <div class="mb-3">
                    <label for="asal_universitas" class="form-label">Asal Universitas</label>
                    <input type="text" class="form-control" id="asal_universitas" name="asal_universitas" required>
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" required>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester" required min="1" title="Semester minimal 1">
                </div>
                <div class="mb-3">
                    <label for="ipk" class="form-label">IPK</label>
                    <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" required min="0" max="4" title="IPK harus antara 0 dan 4">
                </div>
                <div class="mb-3">
                    <label for="transkrip_nilai" class="form-label">Unggah Transkrip Nilai</label>
                    <input type="file" class="form-control" id="transkrip_nilai" name="transkrip_nilai" accept=".pdf,.jpg,.png" required>
                </div>
                <div class="mb-3">
                    <label for="surat_pengantar" class="form-label">Unggah Surat Pengantar Universitas</label>
                    <input type="file" class="form-control" id="surat_pengantar" name="surat_pengantar" accept=".pdf,.jpg,.png" required>
                </div>
                <button type="button" class="btn btn-secondary w-100 mb-2" id="back-to-step-1">Kembali</button>
                <button type="button" class="btn btn-primary w-100" id="next-to-step-3">Selanjutnya</button>
            </div>

            <!-- Step 3 -->
            <div id="step-3" class="form-step">
                <div class="mb-3">
                    <label for="direktorat" class="form-label">Direktorat</label>
                    <select class="form-select" id="direktorat" name="direktorat" required>
                        <option value="">Pilih</option>
                        <option value="Direktorat 1">Direktorat 1</option>
                        <option value="Direktorat 2">Direktorat 2</option>
                        <option value="Direktorat 3">Direktorat 3</option>
                        <option value="Direktorat 4">Direktorat 4</option>
                        <option value="Direktorat 5">Direktorat 5</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                    <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" required>
                </div>
                <div class="mb-3">
                    <label for="cv" class="form-label">Unggah CV</label>
                    <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.jpg,.png" required>
                </div>
                <button type="button" class="btn btn-secondary w-100 mb-2" id="back-to-step-2">Kembali</button>
                <button type="button" class="btn btn-success w-100" id="submit-final">Kirim</button>
            </div>
        </form>
    </div>

    <script>
        function updateProgress(currentStep, nextStep) {
            document.getElementById(`circle-step-${currentStep}`).classList.remove('bg-primary');
            document.getElementById(`circle-step-${currentStep}`).classList.add('bg-secondary');

            document.getElementById(`circle-step-${nextStep}`).classList.add('bg-primary');
            document.getElementById(`circle-step-${nextStep}`).classList.remove('bg-secondary');

            if (nextStep > currentStep) {
                document.getElementById(`line-step-${currentStep}`).classList.add('bg-primary');
            } else {
                document.getElementById(`line-step-${currentStep - 1}`).classList.remove('bg-primary');
            }
        }

        function showStep(currentStep, nextStep) {
            document.getElementById(`step-${currentStep}`).classList.add('d-none');
            document.getElementById(`step-${currentStep}`).classList.remove('active');

            document.getElementById(`step-${nextStep}`).classList.add('active');
            document.getElementById(`step-${nextStep}`).classList.remove('d-none');

            updateProgress(currentStep, nextStep);
        }

        function validateStep(step) {
            const inputs = document.querySelectorAll(`#step-${step} input, #step-${step} select`);
            let isValid = true;

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

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

    </script>
</body>
</html>
