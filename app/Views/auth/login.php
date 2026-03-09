<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS Utilities -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body class="bg-light">

<div class="login-wrapper">
    <div class="login-card shadow-sm">
        <div class="login-brand mb-5">
            <div class="brand-icon mb-3">
                <i class="bi bi-box-seam fs-1"></i>
            </div>
            <h1 class="brand-name">INVENTORY SYSTEM</h1>
            <p class="brand-tagline">EOQ, ROP & SAFETY STOCK MANAGEMENT</p>
        </div>
        
        <form action="/auth/login" method="post" class="login-form">
            <?= csrf_field() ?>
            <div class="form-group mb-4">
                <label for="username" class="custom-label">USERNAME</label>
                <div class="input-wrapper">
                    <input type="text" name="nama_pengguna" id="username" class="custom-input" placeholder="Masukkan nama pengguna..." required autofocus autocomplete="off">
                </div>
            </div>
            
            <div class="form-group mb-5">
                <label for="password" class="custom-label">PASSWORD</label>
                <div class="input-wrapper">
                    <input type="password" name="kata_sandi" id="password" class="custom-input" placeholder="Masukkan kata sandi..." required>
                </div>
            </div>
            
            <button type="submit" class="btn-primary-flat">
                MASUK KE SISTEM <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>
        
        <div class="login-footer mt-5">
            <p class="footer-copy">&copy; 2026 KCD WILAYAH X - PROVINSI JAWA BARAT</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
    const notyf = new Notyf({
        duration: 4000,
        position: { x: 'right', y: 'top' },
        types: [
            { type: 'success', background: '#000000', dismissible: true },
            { type: 'error', background: '#dc3545', dismissible: true }
        ]
    });

    <?php if (session()->getFlashdata('msg')): ?>
        notyf.error('<?= session()->getFlashdata('msg') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        notyf.error('<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        notyf.success('<?= session()->getFlashdata('success') ?>');
    <?php endif; ?>
</script>
</body>
</html>
