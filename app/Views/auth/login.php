<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS (Optional if not used, but kept for utilities) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body>

<div class="login-container">
    <header class="login-header">
        <h1>Inventory System</h1>
        <p>EOQ, ROP, & Safety Stock App</p>
    </header>
    
    <div class="login-body">
        <form action="/auth/login" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" class="form-control" id="username" placeholder="ADMIN123" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="kata_sandi" class="form-control" id="password" placeholder="********" required>
            </div>
            <button type="submit" class="btn-login">MASUK</button>
        </form>
    </div>
    
    <footer class="footer-text">
        (C) 2026 KCD WILAYAH X - PROVINSI JAWA BARAT
    </footer>
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
            { type: 'error', background: '#ff0000', dismissible: true }
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
