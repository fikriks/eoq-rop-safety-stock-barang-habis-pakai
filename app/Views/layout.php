<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> - Inventory System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <!-- Custom App CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid px-3">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-dark p-0 me-3 d-lg-none" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <img src="<?= base_url('logo.png') ?>" alt="Logo" height="70">
            </a>
        </div>
        
        <div class="dropdown">
            <a class="nav-link dropdown-toggle fw-bold small text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2 fs-5"></i> 
                <span class="d-none d-md-inline"><?= session()->get('nama_pengguna') ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                <li><a class="dropdown-item fw-bold py-2" href="/logout"><i class="bi bi-box-arrow-right me-2 text-danger"></i> Keluar</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('dashboard')) ? 'active' : '' ?>" href="/dashboard">
                            <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>
                    
                    <h6 class="sidebar-heading">Master Data</h6>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('kodering*')) ? 'active' : '' ?>" href="/kodering">
                            <i class="bi bi-journal-bookmark"></i> Kodering
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('barang*')) ? 'active' : '' ?>" href="/barang">
                            <i class="bi bi-box"></i> Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('harga*')) ? 'active' : '' ?>" href="/harga">
                            <i class="bi bi-currency-dollar"></i> Harga Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('supplier*')) ? 'active' : '' ?>" href="/supplier">
                            <i class="bi bi-truck"></i> Supplier
                        </a>
                    </li>
                    
                    <h6 class="sidebar-heading">Transaksi</h6>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('transaksi/masuk*')) ? 'active' : '' ?>" href="/transaksi/masuk">
                            <i class="bi bi-arrow-down-circle"></i> Barang Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('transaksi/keluar*')) ? 'active' : '' ?>" href="/transaksi/keluar">
                            <i class="bi bi-arrow-up-circle"></i> Barang Keluar
                        </a>
                    </li>
                    
                    <h6 class="sidebar-heading">Analisis Stok</h6>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('analisis*')) ? 'active' : '' ?>" href="/analisis">
                            <i class="bi bi-calculator"></i> Perhitungan EOQ/ROP
                        </a>
                    </li>
                    
                    <h6 class="sidebar-heading">Laporan</h6>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('laporan/stok*')) ? 'active' : '' ?>" href="/laporan/stok">
                            <i class="bi bi-printer"></i> Laporan Stok
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (url_is('laporan/transaksi*')) ? 'active' : '' ?>" href="/laporan/transaksi">
                            <i class="bi bi-file-earmark-text"></i> Laporan Transaksi
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col">
            <div class="container-fluid px-md-4 pt-4">
                <?= $this->renderSection('content') ?>

                <footer class="text-center">
                    &copy; 2026 KCD WILAYAH X - PROVINSI JAWA BARAT
                </footer>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    // Sidebar Toggle Logic
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebarMenu.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebarMenu.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    const notyf = new Notyf({
        duration: 4000,
        position: { x: 'right', y: 'top' },
        types: [
            { type: 'success', background: '#28a745', dismissible: true },
            { type: 'error', background: '#dc3545', dismissible: true }
        ]
    });

    <?php if (session()->getFlashdata('success')): ?>
        notyf.success('<?= session()->getFlashdata('success') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        notyf.error('<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('msg')): ?>
        notyf.error('<?= session()->getFlashdata('msg') ?>');
    <?php endif; ?>
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
