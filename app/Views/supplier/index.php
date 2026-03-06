<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Supplier<?= $this->endSection() ?>

<?= $this->section('header') ?>Daftar Supplier<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Supplier</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 fw-800 text-dark">DATA VENDOR / SUPPLIER</h6>
                    <p class="small text-muted mb-0">Kelola daftar penyedia barang habis pakai.</p>
                </div>
                <button class="btn btn-dark shadow-sm px-4" style="border-radius: 8px; font-weight: 600;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Supplier
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NAMA SUPPLIER</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800" width="200">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($supplier)): ?>
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted fw-bold">Belum ada data supplier.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($supplier as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3">
                                            <span class="fw-800 text-dark text-uppercase"><?= $item['nama_supplier'] ?></span>
                                        </td>
                                        <td class="text-end pe-4 py-3 text-nowrap">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-light btn-sm fw-bold border" 
                                                        onclick="editSupplier(<?= htmlspecialchars(json_encode($item)) ?>)">
                                                    <i class="bi bi-pencil-square me-1"></i>Ubah
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm fw-bold" 
                                                        onclick="confirmDelete(<?= $item['id'] ?>, '<?= $item['nama_supplier'] ?>')">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            </div>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase">TAMBAH SUPPLIER</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/supplier/simpan" method="post">
                <?= csrf_field() ?>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">NAMA SUPPLIER <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" class="form-control py-2" style="border-radius: 8px;" placeholder="E.g. CV. Media Stationery" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-dark px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-check-lg me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase">UBAH SUPPLIER</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/supplier/ubah" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">NAMA SUPPLIER <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" id="edit_nama" class="form-control py-2" style="border-radius: 8px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-dark px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                </div>
                <h6 class="fw-800 text-dark uppercase">HAPUS SUPPLIER?</h6>
                <p class="small text-muted mb-4">Anda akan menghapus <br><strong id="del_nama" class="text-dark"></strong></p>
                <div class="d-grid gap-2">
                    <a href="#" id="del_link" class="btn btn-danger py-2" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-trash3 me-2"></i>Hapus Sekarang
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
    function editSupplier(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_nama').value = item.nama_supplier;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    function confirmDelete(id, nama) {
        document.getElementById('del_nama').textContent = nama;
        document.getElementById('del_link').href = '/supplier/hapus/' + id;
        new bootstrap.Modal(document.getElementById('modalDelete')).show();
    }
</script>
<?= $this->endSection() ?>
