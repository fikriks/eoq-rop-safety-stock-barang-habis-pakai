<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Laporan Transaksi<?= $this->endSection() ?>

<?= $this->section('header') ?>Laporan Transaksi Barang<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Laporan Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    @media print {
        .navbar, .sidebar, .btn, .breadcrumb, footer, .card-header, .filter-box {
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
            padding: 6px !important;
            font-size: 10pt !important;
        }
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
        }
    }
    .print-header {
        display: none;
    }
    .bg-soft-success { background-color: #e8f5e9 !important; }
    .bg-soft-danger { background-color: #fbe9e7 !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Filter Box -->
        <div class="card border-0 shadow-sm mb-4 filter-box" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="/laporan/transaksi" method="get" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted">TANGGAL MULAI</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted">TANGGAL SELESAI</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-dark px-4 flex-grow-1">
                            <i class="bi bi-filter me-2"></i>Filter Data
                        </button>
                        <button type="button" class="btn btn-light border px-4" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="print-header">
            <h4 class="fw-800 mb-1">KCD PENDIDIKAN WILAYAH X</h4>
            <h5 class="fw-700 mb-1">PROVINSI JAWA BARAT</h5>
            <p class="small mb-0">Laporan Mutasi Barang Habis Pakai</p>
            <p class="small fw-bold">Periode: <?= date('d/m/Y', strtotime($tgl_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tgl_selesai)) ?></p>
            <hr border="2">
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">TANGGAL</th>
                                <th class="py-3 border-0 text-muted small fw-800">BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800">TIPE</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">QTY</th>
                                <th class="py-3 border-0 text-muted small fw-800">HARGA</th>
                                <th class="pe-4 py-3 border-0 text-muted small fw-800">SUPPLIER / KET</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transaksi)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted fw-bold">Tidak ada data transaksi pada periode ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($transaksi as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3 small fw-bold"><?= date('d/m/Y', strtotime($item['tgl_transaksi'])) ?></td>
                                        <td class="py-3">
                                            <div class="fw-800 text-dark small text-uppercase"><?= $item['nama_barang'] ?></div>
                                        </td>
                                        <td class="py-3">
                                            <?php if ($item['tipe'] == 'MASUK'): ?>
                                                <span class="badge bg-soft-success text-success fw-800 py-1 px-2" style="font-size: 0.65rem;">MASUK</span>
                                            <?php else: ?>
                                                <span class="badge bg-soft-danger text-danger fw-800 py-1 px-2" style="font-size: 0.65rem;">KELUAR</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center fw-800"><?= $item['jumlah'] ?></td>
                                        <td class="py-3 small fw-bold">
                                            <?= $item['harga_beli'] ? 'Rp ' . number_format($item['harga_beli'], 0, ',', '.') : '-' ?>
                                        </td>
                                        <td class="pe-4 py-3 small text-muted">
                                            <div class="fw-bold text-dark"><?= $item['nama_supplier'] ?: '-' ?></div>
                                            <div><?= $item['keterangan'] ?: '-' ?></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
