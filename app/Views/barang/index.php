<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Barang<?= $this->endSection() ?>

<?= $this->section('header') ?>Master Barang<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Barang</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h6 class="m-0 fw-800 text-dark" style="letter-spacing: 0.5px;">DAFTAR BARANG HABIS PAKAI</h6>
                    <p class="small text-muted mb-0">Kelola detail item, kodering, dan pantau jumlah stok terkini.</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalImport">
                        <i class="bi bi-file-earmark-excel me-2"></i>Import
                    </button>
                    <button type="button" class="btn btn-dark px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Barang
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="ps-4 py-3 border-0 text-muted small fw-800">NAMA BARANG</th>
                                <th class="py-3 border-0 text-muted small fw-800">KODERING / REKENING</th>
                                <th class="py-3 border-0 text-muted small fw-800">HARGA TERBARU</th>
                                <th class="py-3 border-0 text-muted small fw-800 text-center">STOK</th>
                                <th class="text-end pe-4 py-3 border-0 text-muted small fw-800" width="200">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($barang)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-box2 display-4 text-light mb-3 d-block"></i>
                                            <p class="text-muted fw-bold">Belum ada data barang tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($barang as $item): ?>
                                    <tr class="border-bottom" style="border-color: #f1f1f1 !important;">
                                        <td class="ps-4 py-3">
                                            <div class="fw-800 text-dark text-uppercase"><?= $item['nama_barang'] ?></div>
                                            <div class="small text-muted fw-600">Satuan: <?= $item['satuan'] ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark small"><?= $item['kode_rekening'] ?></div>
                                            <div class="text-muted fw-600" style="font-size: 0.75rem;"><?= $item['nama_rekening'] ?></div>
                                        </td>
                                        <td class="fw-bold text-dark">Rp <?= number_format($item['harga_terbaru'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <div class="fw-800 <?= ($item['stok'] <= 5) ? 'text-danger' : 'text-dark' ?>" style="font-size: 1.1rem;">
                                                <?= $item['stok'] ?>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4 py-3 text-nowrap">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-light btn-sm fw-bold border" 
                                                        onclick="editBarang(<?= htmlspecialchars(json_encode($item)) ?>)">
                                                    <i class="bi bi-pencil-square me-1"></i>Ubah
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm fw-bold" 
                                                        onclick="confirmDelete(<?= $item['id'] ?>, '<?= $item['nama_barang'] ?>')">
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
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted fw-600">Total: <?= count($barang) ?> Jenis Barang</small>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase text-primary"><i class="bi bi-file-earmark-excel me-2"></i>Import Data Barang</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/barang/import" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body px-4">
                    <div class="alert bg-light border-0 small mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-800 small m-0 text-dark">FORMAT KOLOM EXCEL:</h6>
                            <a href="/template/barang" class="btn btn-sm btn-link text-decoration-none fw-bold p-0"><i class="bi bi-download me-1"></i>Download Template</a>
                        </div>
                        <ol class="mb-0 fw-600 text-muted">
                            <li>Nama Barang</li>
                            <li>Kode Rekening (Harus sesuai menu Kodering)</li>
                            <li>Satuan</li>
                            <li>Harga Beli Awal</li>
                            <li>Stok Awal</li>
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
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600; background-color: #000; border-color: #000;">
                        <i class="bi bi-upload me-2"></i>Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h6 class="modal-title fw-800 text-uppercase">TAMBAH BARANG BARU</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/barang/simpan" method="post">
                <?= csrf_field() ?>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">KODE REKENING (KODERING) <span class="text-danger">*</span></label>
                        <select name="id_kodering" class="form-select py-2" style="border-radius: 8px;" required>
                            <option value="">-- Pilih Kodering --</option>
                            <?php foreach($kodering as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= $k['kode_rekening'] ?> - <?= $k['nama_rekening'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">NAMA BARANG <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control py-2" placeholder="Nama item..." style="border-radius: 8px;" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-800 text-muted uppercase">SATUAN <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" class="form-control py-2" placeholder="Rim/Pak/Btl" style="border-radius: 8px;" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-800 text-muted uppercase">HARGA BELI AWAL <span class="text-danger">*</span></label>
                            <input type="number" name="harga_beli" class="form-control py-2" placeholder="0" style="border-radius: 8px;" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">STOK AWAL <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control py-2" value="0" style="border-radius: 8px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-dark px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-check-lg me-2"></i>Simpan Barang
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
                <h6 class="modal-title fw-800 text-uppercase">UBAH DATA BARANG</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/barang/ubah" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">KODE REKENING (KODERING) <span class="text-danger">*</span></label>
                        <select name="id_kodering" id="edit_kodering" class="form-select py-2" style="border-radius: 8px;" required>
                            <?php foreach($kodering as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= $k['kode_rekening'] ?> - <?= $k['nama_rekening'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">NAMA BARANG <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" id="edit_nama" class="form-control py-2" style="border-radius: 8px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-800 text-muted uppercase">SATUAN <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" id="edit_satuan" class="form-control py-2" style="border-radius: 8px;" required>
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
                    <i class="bi bi-trash3 text-danger fs-3"></i>
                </div>
                <h6 class="fw-800 text-dark uppercase">HAPUS BARANG?</h6>
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
    function editBarang(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_kodering').value = item.id_kodering;
        document.getElementById('edit_nama').value = item.nama_barang;
        document.getElementById('edit_satuan').value = item.satuan;
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    function confirmDelete(id, nama) {
        document.getElementById('del_nama').textContent = nama;
        document.getElementById('del_link').href = '/barang/hapus/' + id;
        new bootstrap.Modal(document.getElementById('modalDelete')).show();
    }
</script>
<?= $this->endSection() ?>
