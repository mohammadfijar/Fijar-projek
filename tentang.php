<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .banner {
            position: relative;
            width: 100%;
            height: 350px;
            background-image: url('assets/img/bgnight.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }
        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }
        .banner .box {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 20px;
        }
        .banner h3 {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            background: linear-gradient(45deg, #fff, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .banner p {
            font-size: 1.2rem;
            font-weight: 400;
            margin: 0;
        }
        .content-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .content-container h4 {
            font-size: 2rem;
            font-weight: 600;
            color: #4ecdc4;
            margin-bottom: 20px;
            text-align: center;
        }
        .content-container p {
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            text-align: justify;
        }
        .image-container {
            text-align: center;
            margin-top: 20px;
        }
        .image-container img {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 100%;
            height: auto;
        }
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        .row > [class^="col-"] {
            padding-left: 15px;
            padding-right: 15px;
        }
        @media (max-width: 768px) {
            .banner {
                height: 250px;
            }
            .banner h3 {
                font-size: 2rem;
            }
            .banner p {
                font-size: 1rem;
            }
            .content-container {
                padding: 20px;
            }
            .content-container h4 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="banner">
    <div class="box">
        <h3>About Us</h3>
        <p>Kenali lebih dekat dengan Toko Kami</p>
    </div>
</div>

<div class="container">
    <div class="content-container">
        <div class="row">
            <div class="col-md-8">
                <h4>Tentang Toko Kami</h4>
                <p>Toko Gun Shop adalah sebuah usaha keluarga yang bergerak di bidang penjualan perlengkapan dan aksesori senjata, mulai dari airsoft gun, peralatan taktis, perlengkapan keamanan diri, hingga berbagai kebutuhan outdoor dan hobi menembak. Toko ini melayani pelanggan secara langsung maupun melalui pemesanan online, dengan fokus pada kualitas produk serta pelayanan yang ramah dan profesional.</p>
                <p>Toko Gun Shop didirikan pada tahun 2016 oleh keluarga Bapak Metal dengan tujuan menyediakan perlengkapan menembak yang aman, legal, dan berkualitas bagi para penghobi dan komunitas pecinta olahraga shooting. Sejak awal berdiri, Ubay Gun Shop berkomitmen untuk menjadi penyedia perlengkapan taktis yang terpercaya dan mudah dijangkau. Dengan visi untuk selalu menghadirkan produk terbaik serta layanan cepat dan informatif, Ubay Gun Shop terus berkembang mengikuti kebutuhan pelanggan dan perkembangan teknologi tanpa meninggalkan nilai kekeluargaan dalam setiap pelayanannya.</p>
            </div>
            <div class="col-md-4 image-container">
                <img src="assets/img/scpt.jpeg" alt="Ubay Galon Store" height="300px" width="100%">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
