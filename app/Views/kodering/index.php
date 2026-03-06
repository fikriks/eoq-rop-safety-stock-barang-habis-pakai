<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Kodering<?= $this->endSection() ?>

<?= $this->section('header') ?>Kode Rekening (Kodering)<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Kodering</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4">
                <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">DAFTAR KODE REKENING</h6>
                <p class="small text-muted mb-0">Daftar klasifikasi anggaran barang habis pakai sesuai standar akuntansi.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800" width="200">KODE REKENING</th>
                                <th class="py-3 border-0 text-muted small fw-800">URAIAN / NAMA REKENING</th>
                                <th class="pe-4 py-3 border-0 text-muted small fw-800 text-end">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($kodering)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-file-earmark-lock display-4 text-light mb-3 d-block"></i>
                                            <p class="text-muted fw-bold">Belum ada data kodering tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($kodering as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3 fw-800 text-dark" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                            <?= $item['kode_rekening'] ?>
                                        </td>
                                        <td class="py-3 fw-600 text-dark">
                                            <?= $item['nama_rekening'] ?>
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted small">
                                            #<?= $item['id'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted fw-600">Total: <?= count($kodering) ?> Kode Rekening</small>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
