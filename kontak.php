<?php require "header.php"; ?>
<style>
    /* ====== Banner ====== */
    .banner .img {
        width: 100%;
        height: 280px;
        background-image: url('assets/img/bgnight.jpg');
        background-size: cover;
        background-position: center;
        margin: 0;
    }

    .img .box {
        height: 280px;
        background: rgba(0, 0, 0, 0.65);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: #fff;
        text-align: center;
        padding: 0 20px;
    }

    .img .box h3 {
        font-size: 26px;
        font-weight: 600;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    }

    /* ====== Form Section ====== */
    .contact-container {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 40px 30px;
        margin-top: -60px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(6px);
    }

    .contact-container h4 {
        color: #333;
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #19aa8d;
        box-shadow: 0 0 6px rgba(25, 170, 141, 0.5);
    }

    textarea {
        resize: none;
    }

    .btn-submit {
        background: linear-gradient(45deg, #19aa8d, #10786a);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 10px 0;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-submit:hover {
        background: linear-gradient(45deg, #10786a, #0b5a4e);
        transform: translateY(-2px);
    }

    /* ====== Contact Info ====== */
    .contact-info {
        color: #333;
        margin-top: 20px;
    }

    .contact-info h5 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #19aa8d;
    }

    .contact-info p {
        font-size: 15px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-info i {
        color: #19aa8d;
        font-size: 18px;
    }

    /* ====== Responsive ====== */
    @media (max-width: 768px) {
        .contact-container {
            padding: 25px 20px;
        }
        .img .box h3 {
            font-size: 22px;
        }
    }
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>Hubungi Kami — Kami Siap Membantu Anda</h3>
            <p>Isi formulir di bawah ini untuk pertanyaan atau saran.</p>
        </div>
    </div>
</div>

<div class="container contact-container">
    <div class="row">
        <!-- Form -->
        <div class="col-md-8 col-sm-12">
            <h4>Kirim Pesan</h4>
            <form action="mailto:galonubay1@gmail.com" method="post" enctype="text/plain">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Nama Depan" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Nama Belakang" required>
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control" placeholder="E-mail" required>
                    </div>
                    <div class="col-12 mt-3">
                        <textarea class="form-control" rows="6" placeholder="Masukkan pesan yang ingin dikirimkan..." required></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="fa fa-paper-plane"></i> Kirim Pesan
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="col-md-4 col-sm-12 contact-info">
            <h5>Informasi Kontak</h5>
            <p><i class="fa fa-phone"></i> 0877-8965-3214</p>
            <p><i class="fa fa-envelope"></i> gunshop1@gmail.com</p>
            <p><i class="fa fa-clock-o"></i> Senin - Sabtu (08.00 - 20.00)</p>
            <p><i class="fa fa-map-marker"></i> Jl. Kehancuran<br>Pancoran Mas,Depok,  Jawa Barat</p>
        </div>
    </div>
</div>
