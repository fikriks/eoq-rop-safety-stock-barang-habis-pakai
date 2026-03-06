<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Welcome<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-5 mb-4 bg-white rounded-0 border border-dark shadow-sm">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-dark">EOQ & ROP Management System</h1>
        <p class="col-md-8 fs-4 text-secondary">Optimalkan stok barang habis pakai dengan metode Economic Order Quantity (EOQ), Reorder Point (ROP), dan Safety Stock secara akurat.</p>
        <hr class="my-4 border-dark">
        <p class="fw-bold">Gunakan aplikasi ini untuk memantau inventaris dan melakukan pengadaan barang yang lebih efisien.</p>
        <button class="btn btn-primary btn-lg px-5" type="button">MULAI SEKARANG</button>
    </div>
</div>

<div class="row align-items-md-stretch">
    <div class="col-md-4 mb-4">
        <div class="h-100 p-5 text-white bg-dark border border-dark">
            <h2>EOQ Analysis</h2>
            <p>Hitung jumlah pesanan paling ekonomis untuk meminimalkan biaya penyimpanan dan pemesanan.</p>
            <a href="#" class="btn btn-outline-light rounded-0 fw-bold">PELAJARI</a>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="h-100 p-5 bg-white border border-dark">
            <h2 class="text-dark">ROP & Safety Stock</h2>
            <p>Tentukan titik pemesanan kembali dan stok pengaman untuk menghindari kekosongan barang di gudang.</p>
            <a href="#" class="btn btn-outline-dark rounded-0 fw-bold">PELAJARI</a>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="h-100 p-5 bg-white border border-dark">
            <h2 class="text-dark">Reports</h2>
            <p>Lihat laporan inventaris lengkap untuk pengambilan keputusan yang lebih cepat dan tepat.</p>
            <a href="#" class="btn btn-dark rounded-0 fw-bold">BUKA LAPORAN</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
