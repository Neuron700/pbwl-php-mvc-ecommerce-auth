<h2 class="fw-bold mb-3">Edit Produk</h2>

<div class="card">
      <div class="card-body">
            <form action="<?php echo URL; ?>/produk/update" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="produk_id" value="<?php echo (int) $data['row']['produk_id']; ?>">
                  <div class="row g-3">
                        <div class="col-md-6">
                              <label for="produk_id_kat" class="form-label">Kategori <span class="text-danger">*</span></label>
                              <select name="produk_id_kat" id="produk_id_kat" class="form-select" required>
                                    <?php foreach ($data['listkategori'] as $kat) { ?>
                                          <option value="<?php echo (int) $kat['kat_id']; ?>"
                                                <?php echo ((int) $kat['kat_id'] === (int) $data['row']['produk_id_kat']) ? 'selected' : ''; ?>>
                                                <?php echo e($kat['kat_nama']); ?>
                                          </option>
                                    <?php } ?>
                              </select>
                        </div>

                        <div class="col-md-6">
                              <label for="produk_kode" class="form-label">Kode Produk <span class="text-danger">*</span></label>
                              <input type="text" name="produk_kode" id="produk_kode" class="form-control" maxlength="50"
                                     value="<?php echo e($data['row']['produk_kode']); ?>" required>
                        </div>

                        <div class="col-md-12">
                              <label for="produk_nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                              <input type="text" name="produk_nama" id="produk_nama" class="form-control" maxlength="256"
                                     value="<?php echo e($data['row']['produk_nama']); ?>" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_hrg" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                              <input type="number" name="produk_hrg" id="produk_hrg" class="form-control" min="0" step="1"
                                     value="<?php echo (int) $data['row']['produk_hrg']; ?>" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_stock" class="form-label">Stok <span class="text-danger">*</span></label>
                              <input type="number" name="produk_stock" id="produk_stock" class="form-control" min="0" step="1"
                                     value="<?php echo (int) $data['row']['produk_stock']; ?>" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_photo" class="form-label">Ganti Foto</label>
                              <input type="file" name="produk_photo" id="produk_photo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                              <div class="form-text">Kosongkan bila foto tidak diganti. Maks 2 MB.</div>
                        </div>

                        <?php if (!empty($data['row']['produk_photo'])) { ?>
                              <div class="col-12">
                                    <span class="form-label d-block">Foto saat ini</span>
                                    <img src="<?php echo URL; ?>/uploads/produk/<?php echo e($data['row']['produk_photo']); ?>"
                                         alt="Foto <?php echo e($data['row']['produk_nama']); ?>"
                                         class="rounded border"
                                         style="max-width: 160px; max-height: 160px; object-fit: cover;">
                              </div>
                        <?php } ?>

                        <div class="col-md-12">
                              <label for="produk_keterangan" class="form-label">Keterangan</label>
                              <textarea name="produk_keterangan" id="produk_keterangan" class="form-control" rows="4"><?php echo e($data['row']['produk_keterangan']); ?></textarea>
                        </div>

                        <div class="col-12 d-flex gap-2">
                              <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                              <a href="<?php echo URL; ?>/produk" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
            </form>
      </div>
</div>
