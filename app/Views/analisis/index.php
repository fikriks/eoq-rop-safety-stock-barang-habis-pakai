<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Analisis Stok<?= $this->endSection() ?>

<?= $this->section('header') ?>Analisis EOQ & ROP<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Analisis</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4">
                <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">HASIL ANALISIS INVENTARIS</h6>
                <p class="small text-muted mb-0">Nilai EOQ, ROP, dan Safety Stock dihitung otomatis berdasarkan riwayat transaksi.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NAMA BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">HARGA REF.</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">STOK</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">EOQ</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">SAFETY STOCK</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">ROP</th>
                                <th class="py-3 border-0 text-muted small fw-800">TERAKHIR DIHITUNG</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800" width="180">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang as $item): ?>
                                <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                    <td class="ps-4 py-3">
                                        <div class="fw-800 text-dark text-uppercase small"><?= $item['nama_barang'] ?></div>
                                        <div class="small text-muted fw-600" style="font-size: 0.7rem;"><?= $item['nama_rekening'] ?></div>
                                    </td>
                                    <td class="text-center fw-bold small">
                                        Rp <?= number_format($item['harga_referensi'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-800"><?= $item['stok'] ?></div>
                                        <div class="small text-muted fw-bold" style="font-size: 0.7rem;"><?= $item['satuan'] ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['eoq']): ?>
                                            <span class="fw-800 text-primary"><?= round($item['eoq']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small fw-bold" style="font-size: 0.65rem;">BELUM ADA</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['stok_pengaman'] !== null): ?>
                                            <span class="fw-800 text-dark"><?= round($item['stok_pengaman']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small fw-bold">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['rop']): ?>
                                            <div class="fw-800 <?= ($item['stok'] <= $item['rop']) ? 'text-danger' : 'text-success' ?>">
                                                <?= round($item['rop']) ?>
                                            </div>
                                            <?php if ($item['stok'] <= $item['rop']): ?>
                                                <span class="badge bg-soft-danger text-danger fw-800" style="font-size: 0.6rem; background-color: #fbe9e7; padding: 2px 6px;">RE-ORDER!</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted small fw-bold">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small fw-600 text-muted">
                                        <?= $item['terakhir_dihitung_pada'] ? date('d/m/Y H:i', strtotime($item['terakhir_dihitung_pada'])) : '-' ?>
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        <a href="/analisis/hitung/<?= $item['id'] ?>" class="btn btn-light btn-sm fw-bold border">
                                            <i class="bi bi-gear-fill me-1 text-muted"></i>Atur
                                        </a>
                                    </td>
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
