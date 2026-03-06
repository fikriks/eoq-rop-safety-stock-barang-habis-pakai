<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Riwayat Harga<?= $this->endSection() ?>

<?= $this->section('header') ?>Riwayat Harga: <?= $barang['nama_barang'] ?><?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="/harga">Harga Barang</a></li>
<li class="breadcrumb-item active">Detail</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 fw-800 text-dark">DAFTAR HARGA BELI</h6>
                    <p class="small text-muted mb-0">List seluruh harga beli yang pernah tercatat untuk barang ini.</p>
                </div>
                <button class="btn btn-dark shadow-sm px-4" style="border-radius: 8px; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Harga Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">TGL DICATAT</th>
                                <th class="py-3 border-0 text-muted small fw-800">HARGA BELI</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayat_harga as $item): ?>
                                <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                    <td class="ps-4 py-3 fw-bold text-dark"><?= date('d/m/Y H:i', strtotime($item['dibuat_pada'])) ?></td>
                                    <td class="py-3 fw-800 text-primary">Rp <?= number_format($item['harga_beli'], 0, ',', '.') ?></td>
                                    <td class="text-end pe-4 py-3">
                                        <button class="btn btn-outline-danger btn-sm fw-bold px-3" 
                                                onclick="confirmDelete(<?= $item['id'] ?>)">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800">TAMBAH HARGA BARU</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/harga/simpan" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id'] ?>">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">HARGA BELI (RP) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_beli" class="form-control py-2" style="border-radius: 8px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-dark px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-check-lg me-2"></i>Simpan Harga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg text-center" style="border-radius: 16px;">
            <div class="modal-body p-4">
                <i class="bi bi-exclamation-triangle text-danger fs-3 mb-3 d-block"></i>
                <h6 class="fw-800 text-dark uppercase">HAPUS DATA HARGA?</h6>
                <p class="small text-muted mb-4">Pastikan setidaknya ada satu harga tersisa untuk barang ini.</p>
                <div class="d-grid gap-2">
                    <a href="#" id="del_link" class="btn btn-danger py-2" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-trash3 me-2"></i>Ya, Hapus
                    </a>
                    <button type="button" class="btn btn-light py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmDelete(id) {
        document.getElementById('del_link').href = '/harga/hapus/' + id;
        new bootstrap.Modal(document.getElementById('modalDelete')).show();
    }
</script>
<?= $this->endSection() ?>
