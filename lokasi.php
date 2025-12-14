<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Kami </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: url('assets/img/bgnight.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.1));
            z-index: -1;
        }
        .lokasi-section {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 100px; /* untuk beri jarak dari navbar fixed-top */
            position: relative;
            z-index: 1;
        }
        .lokasi-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-align: center;
            color: #fff;
            max-width: 600px;
            width: 100%;
        }
        .lokasi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 50%, rgba(255, 255, 255, 0) 100%);
            border-radius: 20px;
            pointer-events: none;
        }
        .lokasi-card h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 300;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            background: linear-gradient(45deg, #fff, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .lokasi-card p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.9);
        }
        .lokasi-card .btn {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
            transition: all 0.3s ease;
        }
        .lokasi-card .btn:hover {
            background: linear-gradient(135deg, #4ecdc4, #ff6b6b);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.6);
            color: white;
        }
        .map-section {
            margin-top: 50px;
            padding: 20px;
        }
        .map-section h3 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        #googleMap {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
            .lokasi-card {
                padding: 30px 20px;
            }
            .lokasi-card h1 {
                font-size: 2rem;
            }
            .lokasi-card p {
                font-size: 1rem;
            }
            #googleMap {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    <section class="lokasi-section">
        <div class="container">
            <div class="lokasi-card">
                <h1><i class="fas fa-map-marker-alt"></i> Lokasi Toko</h1>
                <p>Silakan kunjungi kami dengan klik tautan di bawah ini untuk panduan lengkap:</p>
                <a href="https://www.google.com/maps/place/6%C2%B016'00.8%22S+106%C2%B042'23.6%22E/@-6.2668786,
                106.7039681,17z/data=!3m1!4b1!4m4!3m3!8m2!3d-6.2668786!4d106.706543?hl=id&entry=ttu&g_ep=
                EgoyMDI1MDUxMi4wIKXMDSoJLDEwMjExNDUzSAFQAw%3D%3D" 
                target="_blank" class="btn">
                    <i class="fas fa-external-link-alt"></i> Buka Lokasi di Google Maps
                </a>
            </div>
        </div>
    </section>

    <div class="container map-section">
        <h3><span class="text-primary">COORDINATE</span> LOCATION</h3>
        <div id="googleMap"></div>
    </div>

    <script>
        // Initialize and add the map
        function initMap() {
            var maps = {
                lat: -7.749923587395794,
                lng: 110.41867017745972
            };

            var map = new google.maps.Map(
                document.getElementById('googleMap'), {
                    zoom: 17,
                    center: maps
                });

            var marker = new google.maps.Marker({
                position: maps,
                map: map
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>
