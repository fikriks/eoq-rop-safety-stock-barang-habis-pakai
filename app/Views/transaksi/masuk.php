<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Barang Masuk<?= $this->endSection() ?>

<?= $this->section('header') ?>Barang Masuk<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="#">Transaksi</a></li>
<li class="breadcrumb-item active">Masuk</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="/transaksi/masuk" method="get" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">Tgl Mulai</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-800 text-muted uppercase">Tgl Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-dark px-4 flex-grow-1" style="height: 42px;">
                            <i class="bi bi-filter me-2"></i>Filter
                        </button>
                        <a href="/transaksi/masuk" class="btn btn-light border px-4" style="height: 42px;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">RIWAYAT PENERIMAAN</h6>
                    <p class="small text-muted mb-0">Menampilkan data barang masuk berdasarkan filter yang dipilih.</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalImport">
                        <i class="bi bi-file-earmark-excel me-2"></i>Import
                    </button>
                    <button type="button" class="btn btn-dark px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Masuk
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">TANGGAL</th>
                                <th class="py-3 border-0 text-muted small fw-800">BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">JUMLAH</th>
                                <th class="py-3 border-0 text-muted small fw-800">HARGA BELI</th>
                                <th class="py-3 border-0 text-muted small fw-800">SUPPLIER</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800" width="120">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transaksi)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-file-earmark-text display-4 text-light mb-3 d-block"></i>
                                            <p class="text-muted fw-bold">Tidak ada data transaksi masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($transaksi as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3 fw-bold text-dark small"><?= date('d/m/Y', strtotime($item['tgl_transaksi'])) ?></td>
                                        <td class="py-3">
                                            <div class="fw-800 text-dark text-uppercase small"><?= $item['nama_barang'] ?></div>
                                            <div class="small text-muted fw-600" style="font-size: 0.7rem;">Oleh: <?= $item['nama_pengguna'] ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-soft-success text-success border-0 px-3 py-2 fw-800" style="background-color: #e8f5e9; font-size: 0.85rem;">+<?= $item['jumlah'] ?></span>
                                        </td>
                                        <td class="fw-bold text-dark small">Rp <?= number_format($item['harga_beli'] ?? 0, 0, ',', '.') ?></td>
                                        <td class="small fw-800 text-primary text-uppercase"><?= $item['nama_supplier'] ?: '-' ?></td>
                                        <td class="text-end pe-4 py-3 text-nowrap">
                                            <button class="btn btn-outline-danger btn-sm fw-bold px-3" 
                                                    onclick="confirmDelete(<?= $item['id'] ?>, '<?= $item['nama_barang'] ?>', '<?= $item['jumlah'] ?>')">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="small text-muted fw-600">
                    Menampilkan <?= count($transaksi) ?> data.
                </div>
                <div class="custom-pagination">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase text-primary"><i class="bi bi-file-earmark-excel me-2"></i>Import Barang Masuk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/transaksi/import-masuk" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4">
                    <div class="alert bg-light border-0 small mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-800 small m-0 text-dark text-uppercase">FORMAT KOLOM EXCEL:</h6>
                            <a href="/template/transaksi-masuk" class="btn btn-sm btn-link text-decoration-none fw-bold p-0"><i class="bi bi-download me-1"></i>Download Template</a>
                        </div>
                        <ol class="mb-0 fw-600 text-muted">
                            <li>Nama Barang (Harus sesuai Master Barang)</li>
                            <li>Nama Supplier (Harus sesuai Master Supplier)</li>
                            <li>Jumlah</li>
                            <li>Harga Beli</li>
                            <li>Tanggal (Format: YYYY-MM-DD)</li>
                            <li>Keterangan</li>
                        </ol>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">Pilih File Excel (.xlsx) <span class="text-danger">*</span></label>
                        <input type="file" name="file_excel" class="form-control" required accept=".xlsx">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-dark px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-upload me-2"></i>Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase text-dark"><i class="bi bi-plus-lg me-2"></i>Tambah Barang Masuk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/transaksi/simpan" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="tipe" value="MASUK">
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-800 text-muted uppercase">Pilih Barang <span class="text-danger">*</span></label>
                            <select name="id_barang" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Barang --</option>
                                <?php foreach ($barang as $b): ?>
                                    <option value="<?= $b['id'] ?>"><?= $b['nama_barang'] ?> (Stok: <?= $b['stok'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-800 text-muted uppercase">Supplier <span class="text-danger">*</span></label>
                            <select name="id_supplier" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Supplier --</option>
                                <?php foreach ($supplier_list as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-800 text-muted uppercase">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control" required min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-800 text-muted uppercase">Harga Beli <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light fw-bold">Rp</span>
                                <input type="number" name="harga_beli" class="form-control" required min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-800 text-muted uppercase">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_transaksi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-800 text-muted uppercase">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pengadaan ATK Bulan Maret"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4">Simpan Transaksi</button>
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
                    <i class="bi bi-trash3 text-danger fs-3"></i>
                </div>
                <h6 class="fw-800 text-dark uppercase">HAPUS TRANSAKSI?</h6>
                <p class="small text-muted mb-4">Anda akan menghapus transaksi masuk <br><strong id="del_nama" class="text-dark"></strong> sebanyak <strong id="del_jumlah" class="text-dark"></strong></p>
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
function confirmDelete(id, nama, jumlah) {
    document.getElementById('del_nama').textContent = nama;
    document.getElementById('del_jumlah').textContent = jumlah;
    document.getElementById('del_link').href = '/transaksi/hapus/' + id;
    new bootstrap.Modal(document.getElementById('modalDelete')).show();
}
</script>
<?= $this->endSection() ?>
