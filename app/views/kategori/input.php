<h2 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Input Kategori</h2>

<div class="card shadow-sm" style="max-width: 640px">
      <div class="card-body">
            <form method="POST" action="<?php echo URL; ?>/kategori/simpan">
                  <div class="mb-3">
                        <label for="kat_nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kat_nama" id="kat_nama" class="form-control" placeholder="Mis. Minuman" required maxlength="50">
                  </div>
                  <div class="mb-3">
                        <label for="kat_keterangan" class="form-label">Keterangan</label>
                        <textarea name="kat_keterangan" id="kat_keterangan" class="form-control" rows="4" placeholder="Deskripsi singkat (opsional)"></textarea>
                  </div>
                  <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        <a href="<?php echo URL; ?>/kategori" class="btn btn-secondary">Batal</a>
                  </div>
            </form>
      </div>
</div>
