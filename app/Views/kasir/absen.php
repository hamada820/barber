<?php if (session('role') == 'Kasir'): ?>
    <?= $this->include('template/header2') ?>
    <?= $this->include('template/sidebar') ?>
<?php endif ?>
<?php if (session('role') == 'Pegawai'): ?>
    <?= $this->include('template/pegawai/header') ?>
    <?= $this->include('template/pegawai/sidebar') ?>
<?php endif ?>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <h1>Absensi</h1>
    </div>
    <div class="container">
        <h2>Form Absen</h2>
        <div id="ucapan" class="ucapan">
            <h3>Anda Telah Absen</h3>
        </div>
        <?php if (session('error')) : ?>
            <div style="text-align: center;"><?= session('error') ?></div>
        <?php endif ?>
        <br><br>
        <div class="map-container" id="map" style="height: 400px;"></div>
        <form action="<?= base_url('absen/hadir') ?>" method="post">
            <div class="button-container">
                <input type="hidden" id="locationStatus" name="LocationStatus">
                <button id="button" type="submit" class="my-button" disabled>Hadir</button>
            </div>
        </form>
        <form action="<?= base_url('absen/keluar') ?>" method="post">
            <div class="button-container">
                <button id="keluar-button" class="my-button" onclick="showPopup()" disabled>Keluar</button>
            </div>
        </form>
        <form action="<?= base_url('absen/hadir/libur') ?>" method="post">
            <div class="button-container">
                <button type="submit" class="my-button">Libur</button>
            </div>
        </form>
    </div>
</main>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    const popup = document.getElementById('my-popup');

    function showPopup() {
        popup?.classList.add('show');
    }

    function hidePopup() {
        popup?.classList.remove('show');
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation tidak didukung browser Anda.");
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        const map = L.map('map').setView([latitude, longitude], 16);

        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        // Marker posisi pengguna
        const marker = L.marker([latitude, longitude]).addTo(map);

        // Lokasi kantor (lokasi absen)
        const centerLat = -3.76065018099517;
        const centerLng = 114.76943722903827;

        // Lingkaran radius 10 meter
        const circle = L.circle([centerLat, centerLng], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 10
        }).addTo(map);

        // Cek apakah dalam radius
        const distance = map.distance([latitude, longitude], [centerLat, centerLng]);

        const button = document.getElementById("button");
        const keluarButton = document.getElementById("keluar-button");
        const locationStatus = document.getElementById("locationStatus");

        if (distance <= 10000) {
            locationStatus.value = "true";
            button.disabled = false;
            keluarButton.disabled = false;
        } else {
            locationStatus.value = "false";
            button.disabled = true;
            keluarButton.disabled = true;
        }
    }

    function showError(error) {
        let message = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                message = "User menolak permintaan geolokasi.";
                break;
            case error.POSITION_UNAVAILABLE:
                message = "Informasi lokasi tidak tersedia.";
                break;
            case error.TIMEOUT:
                message = "Permintaan lokasi pengguna habis waktu.";
                break;
            case error.UNKNOWN_ERROR:
                message = "Terjadi kesalahan tidak dikenal.";
                break;
        }
        alert(message);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kehadiranStatus = <?= json_encode(session('kehadiranStatus')) ?>;
        const keluarStatus = <?= json_encode(session('keluarStatus')) ?>;

        if (kehadiranStatus === 'sudah') {
            document.getElementById('ucapan').style.display = 'block';
        } else {
            document.getElementById('ucapan').style.display = 'none';
        }
    });
</script>