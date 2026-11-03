<div class="d-flex align-items-center justify-content-between mb-3">
      <h2 class="fw-bold mb-0">Detail Produk</h2>
      <a href="<?php echo URL; ?>/produk" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
      <div class="row g-0">
            <div class="col-md-4">
                  <?php if (!empty($data['row']['produk_photo'])) { ?>
                        <img src="<?php echo URL; ?>/uploads/produk/<?php echo e($data['row']['produk_photo']); ?>"
                             alt="Foto <?php echo e($data['row']['produk_nama']); ?>"
                             class="img-fluid rounded-start"
                             style="width: 100%; height: 100%; object-fit: cover; min-height: 260px;">
                  <?php } else { ?>
                        <div class="d-flex align-items-center justify-content-center text-muted rounded-start"
                             style="min-height: 260px; background: #f1f3f5;">
                              <div class="text-center">
                                    <i class="bi bi-image" style="font-size: 4rem;"></i>
                                    <div>Tidak ada foto</div>
                              </div>
                        </div>
                  <?php } ?>
            </div>
            <div class="col-md-8">
                  <div class="card-body">
                        <span class="badge text-bg-secondary mb-2"><?php echo e($data['row']['ktgr'] ?? '-'); ?></span>
                        <h3 class="card-title fw-bold"><?php echo e($data['row']['produk_nama']); ?></h3>
                        <p class="text-muted mb-3">Kode: <code><?php echo e($data['row']['produk_kode']); ?></code></p>

                        <dl class="row mb-4">
                              <dt class="col-sm-4">Harga</dt>
                              <dd class="col-sm-8 fs-5 fw-semibold text-primary">Rp <?php echo number_format((float) $data['row']['produk_hrg'], 0, ',', '.'); ?></dd>

                              <dt class="col-sm-4">Stok</dt>
                              <dd class="col-sm-8"><?php echo (int) $data['row']['produk_stock']; ?> unit</dd>

                              <dt class="col-sm-4">Dibuat</dt>
                              <dd class="col-sm-8"><?php echo e($data['row']['created_at']); ?></dd>

                              <dt class="col-sm-4">Diperbarui</dt>
                              <dd class="col-sm-8"><?php echo e($data['row']['updated_at'] ?? '—'); ?></dd>
                        </dl>

                        <h6 class="fw-bold">Keterangan</h6>
                        <p class="card-text"><?php echo nl2br(e($data['row']['produk_keterangan'] ?? '—')); ?></p>

                        <div class="d-flex gap-2 mt-4">
                              <a href="<?php echo URL; ?>/produk/edit/<?php echo (int) $data['row']['produk_id']; ?>" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                              </a>
                              <a href="<?php echo URL; ?>/produk" class="btn btn-outline-secondary">Daftar Produk</a>
                        </div>
                  </div>
            </div>
      </div>
</div>
