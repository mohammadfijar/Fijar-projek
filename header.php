<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nasrun Gun Shop</title>
    <link rel="shortcut icon" href="assets/img/icon/v1.png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- jQuery (wajib jika kamu pakai plugin lama) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: url(assets/img/bgnight.jpg) no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #3498db !important;
        }

        .nav-link {
            color: #333 !important;
            margin: 0 10px;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #0e6caa !important;
        }

        .navbar .cart-icon {
            font-size: 18px;
            color: #3498db;
        }

        .navbar .cart-icon:hover {
            color: #0e6caa;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container">
                <a class="navbar-brand" href="katalog_display.php">
                    Nasrun Gun Shop
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tentang.php">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lokasi.php">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kontak.php">Kontak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="katalog_display.php">Produk
                                <i class="fa fa-shopping-cart cart-icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
