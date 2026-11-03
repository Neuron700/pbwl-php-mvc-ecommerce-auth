<h2 class="fw-bold mb-3">Input Produk</h2>

<div class="card">
      <div class="card-body">
            <form action="<?php echo URL; ?>/produk/simpan" method="post" enctype="multipart/form-data">
                  <div class="row g-3">
                        <div class="col-md-6">
                              <label for="produk_id_kat" class="form-label">Kategori <span class="text-danger">*</span></label>
                              <select name="produk_id_kat" id="produk_id_kat" class="form-select" required>
                                    <option value="">— Pilih kategori —</option>
                                    <?php foreach ($data['listkategori'] as $kat) { ?>
                                          <option value="<?php echo (int) $kat['kat_id']; ?>">
                                                <?php echo e($kat['kat_nama']); ?>
                                          </option>
                                    <?php } ?>
                              </select>
                              <div class="form-text">Belum ada kategori? <a href="<?php echo URL; ?>/kategori/input">Tambah kategori dulu</a>.</div>
                        </div>

                        <div class="col-md-6">
                              <label for="produk_kode" class="form-label">Kode Produk <span class="text-danger">*</span></label>
                              <input type="text" name="produk_kode" id="produk_kode" class="form-control" maxlength="50" placeholder="Mis. PRD-001" required>
                        </div>

                        <div class="col-md-12">
                              <label for="produk_nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                              <input type="text" name="produk_nama" id="produk_nama" class="form-control" maxlength="256" placeholder="Nama produk" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_hrg" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                              <input type="number" name="produk_hrg" id="produk_hrg" class="form-control" min="0" step="1" placeholder="0" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_stock" class="form-label">Stok <span class="text-danger">*</span></label>
                              <input type="number" name="produk_stock" id="produk_stock" class="form-control" min="0" step="1" placeholder="0" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_photo" class="form-label">Foto Produk</label>
                              <input type="file" name="produk_photo" id="produk_photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                              <div class="form-text">JPG/PNG/WEBP/GIF, maks 2 MB.</div>
                        </div>

                        <div class="col-md-12">
                              <label for="produk_keterangan" class="form-label">Keterangan</label>
                              <textarea name="produk_keterangan" id="produk_keterangan" class="form-control" rows="4" placeholder="Deskripsi singkat produk"></textarea>
                        </div>

                        <div class="col-12 d-flex gap-2">
                              <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                              <a href="<?php echo URL; ?>/produk" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
            </form>
      </div>
</div>
