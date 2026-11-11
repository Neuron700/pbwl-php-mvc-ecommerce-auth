<h2 class="fw-bold mb-3">Edit Penjualan</h2>

<div class="card shadow-sm">
      <div class="card-body">
            <form action="<?php echo URL; ?>/penjualan/update" method="post">
                  <input type="hidden" name="penjualan_id" value="<?php echo (int) $data['row']['penjualan_id']; ?>">
                  <div class="row g-3">
                        <div class="col-md-4">
                              <label for="tgl_penjualan" class="form-label">Tanggal Penjualan</label>
                              <input type="date" name="tgl_penjualan" id="tgl_penjualan" class="form-control"
                                     value="<?php echo e($data['row']['tgl_penjualan']); ?>" required>
                        </div>

                        <div class="col-md-4">
                              <label for="produk_id" class="form-label">Produk</label>
                              <select name="produk_id" id="produk_id" class="form-select produk-select" required>
                                    <?php foreach ($data['listproduk'] as $p) { ?>
                                          <option value="<?php echo (int) $p['produk_id']; ?>"
                                                  data-harga="<?php echo (int) $p['produk_hrg']; ?>"
                                                  data-stock="<?php echo (int) $p['produk_stock']; ?>"
                                                  <?php echo ((int) $p['produk_id'] === (int) $data['row']['produk_id']) ? 'selected' : ''; ?>>
                                                <?php echo e($p['produk_nama']); ?> — stok <?php echo (int) $p['produk_stock']; ?> — Rp <?php echo number_format((float) $p['produk_hrg'], 0, ',', '.'); ?>
                                          </option>
                                    <?php } ?>
                              </select>
                        </div>

                        <div class="col-md-4">
                              <label for="qty" class="form-label">Kuantitas (qty)</label>
                              <input type="number" name="qty" id="qty" class="form-control qty-input" min="1" step="1"
                                     value="<?php echo (int) $data['row']['qty']; ?>" required>
                        </div>

                        <div class="col-md-6">
                              <label for="total_preview" class="form-label">Total (otomatis)</label>
                              <div class="form-control fw-semibold" id="total_preview" style="background:#f9fafb"></div>
                              <div class="form-text">Perubahan qty otomatis menyesuaikan stok produk.</div>
                        </div>
                  </div>

                  <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                        <a href="<?php echo URL; ?>/penjualan" class="btn btn-secondary">Batal</a>
                  </div>
            </form>
      </div>
</div>

<script>
    function updateTotal() {
        const select = document.querySelector('.produk-select');
        const opt = select.selectedOptions[0];
        const harga = opt ? Number(opt.dataset.harga || 0) : 0;
        const qty = Number(document.querySelector('.qty-input').value || 0);
        document.getElementById('total_preview').textContent = 'Rp ' + (harga * qty).toLocaleString('id-ID');
    }
    document.querySelector('.produk-select').addEventListener('change', updateTotal);
    document.querySelector('.qty-input').addEventListener('input', updateTotal);
    updateTotal();
</script>
