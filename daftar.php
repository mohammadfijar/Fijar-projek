<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/icon/toko.png">

    <style>
        body {
            background: url(assets/img/bgsenj.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        /* Lapisan gradasi gelap lembut di atas background */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: -1;
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(15px) saturate(160%);
            -webkit-backdrop-filter: blur(15px) saturate(160%);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        /* Efek highlight atas */
        .signup-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.15), transparent);
            border-radius: 20px 20px 0 0;
            pointer-events: none;
        }

        /* Efek border pelangi lembut */
        .signup-container::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            background: linear-gradient(45deg, #ff6b6b, #feca57, #48dbfb, #1dd1a1);
            z-index: -1;
            opacity: 0.5;
            background-size: 300% 300%;
            animation: borderFlow 8s ease infinite;
        }

        @keyframes borderFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            background: linear-gradient(90deg, #ffffff, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 8px rgba(78,205,196,0.4);
        }

        label {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #48dbfb;
            box-shadow: 0 0 10px rgba(72, 219, 251, 0.4);
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .btn-primary {
            background: linear-gradient(90deg, #48dbfb, #1dd1a1);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            color: #fff;
            box-shadow: 0 0 15px rgba(72,219,251,0.4);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #ff6b6b, #feca57);
            transform: scale(1.03);
            box-shadow: 0 0 25px rgba(255, 107, 107, 0.5);
        }

        a {
            color: #48dbfb;
            text-decoration: none;
        }

        a:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }

        .text-center {
            margin-top: 15px;
        }

        @media (max-width: 576px) {
            .signup-container {
                padding: 30px 25px;
                margin: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <h2><i class="fa fa-user-plus me-2"></i>Daftar Pelanggan</h2>
        <form method="post" action="proses_daftar.php">
            <div class="mb-3">
                <label><i class="fa fa-user me-1"></i>Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="mb-3">
                <label><i class="fa fa-envelope me-1"></i>Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
            </div>
            <div class="mb-3">
                <label><i class="fa fa-lock me-1"></i>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat password" required>
            </div>
            <div class="mb-3">
                <label><i class="fa fa-phone me-1"></i>No Telepon</label>
                <input type="text" name="no_telepon" class="form-control" placeholder="08xxxxxxxxxx">
            </div>
            <div class="mb-3">
                <label><i class="fa fa-map-marker me-1"></i>Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane me-2"></i>Daftar Sekarang</button>
            </div>
            <div class="text-center mt-3">
                Sudah punya akun? <a href="index.php">Login di sini</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
