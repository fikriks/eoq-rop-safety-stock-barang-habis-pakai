<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Kelola Harga<?= $this->endSection() ?>

<?= $this->section('header') ?>Manajemen Harga Barang<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Harga Barang</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4">
                <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">PILIH BARANG</h6>
                <p class="small text-muted mb-0">Klik pada barang untuk melihat dan mengelola riwayat harga beli.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NAMA BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800">SATUAN</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">STOK</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($barang)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted fw-bold">Belum ada data barang tersedia.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($barang as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3">
                                            <span class="fw-800 text-dark text-uppercase"><?= $item['nama_barang'] ?></span>
                                        </td>
                                        <td class="fw-600 text-muted"><?= $item['satuan'] ?></td>
                                        <td class="text-center fw-800"><?= $item['stok'] ?></td>
                                        <td class="text-end pe-4 py-3">
                                            <a href="/harga/detail/<?= $item['id'] ?>" class="btn btn-light btn-sm fw-bold border px-3">
                                                <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Harga
                                            </a>
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
