<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nasrun Gun Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url(assets/img/scpt.jpeg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Lapisan lembut di atas background */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: -1;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.03); /* sangat transparan */
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 50px 45px;
            border-radius: 25px;
            box-shadow:
                0 0 25px rgba(255, 255, 255, 0.1),
                0 10px 35px rgba(0, 0, 0, 0.6);
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
        }

        /* Pantulan cahaya atas */
        .login-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.12), transparent);
            border-radius: 25px 25px 0 0;
            pointer-events: none;
        }

        /* Border gradasi lembut */
        .login-container::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 26px;
            background: linear-gradient(135deg, rgba(78,205,196,0.6), rgba(255,107,107,0.6));
            z-index: -1;
            opacity: 0.4;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 500;
            font-size: 2.3rem;
            background: linear-gradient(90deg, #ffffff, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(78,205,196,0.3);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.07);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            padding: 15px 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: #4ecdc4;
            box-shadow: 0 0 15px rgba(78,205,196,0.4);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            border-radius: 10px 0 0 10px;
            width: 50px;
            justify-content: center;
        }

        .btn-primary {
            background: rgba(78, 205, 196, 0.8);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1.1rem;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(78,205,196,0.3);
        }

        .btn-primary:hover {
            background: rgba(255, 107, 107, 0.8);
            box-shadow: 0 0 30px rgba(255, 107, 107, 0.5);
            transform: scale(1.03);
        }

        a {
            color: #4ecdc4;
            text-decoration: none;
        }

        a:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 40px 25px;
                margin: 20px;
            }
            .login-container h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="cek_login.php">
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="email" required>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="current-password" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

            <div class="mt-4 text-center">
                Belum punya akun pelanggan? <a href="daftar.php">Daftar di sini</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
