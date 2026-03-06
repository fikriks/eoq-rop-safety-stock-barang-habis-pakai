<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Laporan Stok<?= $this->endSection() ?>

<?= $this->section('header') ?>Laporan Stok Saat Ini<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Laporan Stok</li>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    @media print {
        .navbar, .sidebar, .btn, .breadcrumb, footer, .card-header {
            display: none !important;
        }
        main {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
        }
        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        .table th, .table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
        }
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
        }
    }
    .print-header {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="print-header">
            <h4 class="fw-800 mb-1">KCD PENDIDIKAN WILAYAH X</h4>
            <h5 class="fw-700 mb-1">PROVINSI JAWA BARAT</h5>
            <p class="small mb-0">Laporan Persediaan Barang Habis Pakai</p>
            <p class="small fw-bold">Per Tanggal: <?= date('d/m/Y') ?></p>
            <hr border="2">
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 fw-800 text-dark">DATA PERSEDIAAN</h6>
                    <p class="small text-muted mb-0">Total stok fisik yang tercatat di sistem.</p>
                </div>
                <button class="btn btn-dark px-4" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Cetak Laporan
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NO</th>
                                <th class="py-3 border-0 text-muted small fw-800">KODE REKENING</th>
                                <th class="py-3 border-0 text-muted small fw-800">NAMA BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">STOK</th>
                                <th class="pe-4 py-3 border-0 text-muted small fw-800">SATUAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($barang as $item): ?>
                                <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                    <td class="ps-4 py-3 text-muted small"><?= $no++ ?></td>
                                    <td class="py-3 fw-600 small"><?= $item['kode_rekening'] ?></td>
                                    <td class="py-3 fw-800 text-dark text-uppercase"><?= $item['nama_barang'] ?></td>
                                    <td class="text-center fw-800"><?= $item['stok'] ?></td>
                                    <td class="pe-4 py-3 fw-600 text-muted"><?= $item['satuan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
