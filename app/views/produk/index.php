<div class="d-flex align-items-center justify-content-between mb-3">
      <h2 class="fw-bold mb-0">Produk</h2>
      <a href="<?php echo URL; ?>/produk/input" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Input Produk</a>
</div>

<div class="card">
      <div class="card-body p-0">
            <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                              <tr>
                                    <th class="ps-3">Foto</th>
                                    <th>KODE</th>
                                    <th>NAMA</th>
                                    <th>KATEGORI</th>
                                    <th class="text-end">HARGA</th>
                                    <th class="text-center">STOK</th>
                                    <th class="text-end pe-3">AKSI</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php if (empty($data['rows'])) { ?>
                                    <tr>
                                          <td colspan="7" class="text-center text-muted py-4">
                                                Belum ada produk. Klik <strong>Input Produk</strong> untuk menambahkan.
                                          </td>
                                    </tr>
                              <?php } ?>

                              <?php foreach ($data['rows'] as $row) { ?>
                                    <tr>
                                          <td class="ps-3">
                                                <?php if (!empty($row['produk_photo'])) { ?>
                                                      <img src="<?php echo URL; ?>/uploads/produk/<?php echo e($row['produk_photo']); ?>"
                                                           alt="Foto <?php echo e($row['produk_nama']); ?>"
                                                           class="rounded border"
                                                           style="width: 56px; height: 56px; object-fit: cover;">
                                                <?php } else { ?>
                                                      <div class="rounded border d-flex align-items-center justify-content-center text-muted"
                                                           style="width: 56px; height: 56px;">
                                                            <i class="bi bi-image fs-4"></i>
                                                      </div>
                                                <?php } ?>
                                          </td>
                                          <td><code><?php echo e($row['produk_kode']); ?></code></td>
                                          <td class="fw-semibold"><?php echo e($row['produk_nama']); ?></td>
                                          <td><span class="badge text-bg-secondary"><?php echo e($row['ktgr'] ?? '-'); ?></span></td>
                                          <td class="text-end">Rp <?php echo number_format((float) $row['produk_hrg'], 0, ',', '.'); ?></td>
                                          <td class="text-center"><?php echo (int) $row['produk_stock']; ?></td>
                                          <td class="text-end pe-3">
                                                <div class="d-flex justify-content-end gap-1">
                                                      <a href="<?php echo URL; ?>/produk/detail/<?php echo (int) $row['produk_id']; ?>" class="btn btn-outline-secondary btn-sm" title="Detail">
                                                            <i class="bi bi-eye"></i>
                                                      </a>
                                                      <a href="<?php echo URL; ?>/produk/edit/<?php echo (int) $row['produk_id']; ?>" class="btn btn-outline-primary btn-sm" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                      </a>
                                                      <a href="<?php echo URL; ?>/produk/hapus/<?php echo (int) $row['produk_id']; ?>"
                                                         class="btn btn-outline-danger btn-sm"
                                                         title="Hapus"
                                                         onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                            <i class="bi bi-trash"></i>
                                                      </a>
                                                </div>
                                          </td>
                                    </tr>
                              <?php } ?>
                        </tbody>
                  </table>
            </div>
      </div>
</div>
