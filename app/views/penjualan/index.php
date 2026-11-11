<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
      <div>
            <h1 class="h4 fw-bold mb-0"><i class="bi bi-receipt"></i> Penjualan</h1>
            <p class="text-muted small mb-0">Catat produk yang terjual; stok berkurang otomatis.</p>
      </div>
      <a href="<?php echo URL; ?>/penjualan/input" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Catat Penjualan</a>
</div>

<?php
$ringkasan = $data['ringkasan'] ?? ['transaksi' => 0, 'qty' => 0, 'omzet' => 0];
?>
<div class="row g-3 mb-3">
      <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                  <div class="card-body text-center py-3">
                        <div class="small text-muted">Total Transaksi</div>
                        <div class="h3 fw-bold mb-0"><?php echo (int) $ringkasan['transaksi']; ?></div>
                  </div>
            </div>
      </div>
      <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                  <div class="card-body text-center py-3">
                        <div class="small text-muted">Qty Terjual</div>
                        <div class="h3 fw-bold mb-0"><?php echo (int) $ringkasan['qty']; ?></div>
                  </div>
            </div>
      </div>
      <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                  <div class="card-body text-center py-3">
                        <div class="small text-muted">Omzet</div>
                        <div class="h4 fw-bold mb-0 text-success">Rp <?php echo number_format((float) $ringkasan['omzet'], 0, ',', '.'); ?></div>
                  </div>
            </div>
      </div>
</div>

<div class="card shadow-sm">
      <div class="card-body p-0">
            <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                              <tr>
                                    <th class="ps-3">NO</th>
                                    <th>TANGGAL</th>
                                    <th>PRODUK</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-end">HARGA SATUAN</th>
                                    <th class="text-end">TOTAL</th>
                                    <th class="text-end pe-3">AKSI</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php if (empty($data['rows'])) { ?>
                                    <tr>
                                          <td colspan="7" class="text-center text-muted py-4">
                                                Belum ada penjualan. Klik <strong>Catat Penjualan</strong>.
                                          </td>
                                    </tr>
                              <?php } ?>

                              <?php $no = 1; foreach ($data['rows'] as $row) { ?>
                                    <tr>
                                          <td class="ps-3"><?php echo $no++; ?></td>
                                          <td><?php echo e($row['tgl_penjualan']); ?></td>
                                          <td>
                                                <div class="fw-semibold"><?php echo e($row['produk_nama']); ?></div>
                                                <code class="small text-muted"><?php echo e($row['produk_kode']); ?></code>
                                          </td>
                                          <td class="text-center"><?php echo (int) $row['qty']; ?></td>
                                          <td class="text-end">Rp <?php echo number_format((float) $row['harga_satuan'], 0, ',', '.'); ?></td>
                                          <td class="text-end fw-semibold">Rp <?php echo number_format((float) $row['total'], 0, ',', '.'); ?></td>
                                          <td class="text-end pe-3">
                                                <div class="d-flex justify-content-end gap-1">
                                                      <a href="<?php echo URL; ?>/penjualan/edit/<?php echo (int) $row['penjualan_id']; ?>" class="btn btn-outline-primary btn-sm" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                      </a>
                                                      <a href="<?php echo URL; ?>/penjualan/hapus/<?php echo (int) $row['penjualan_id']; ?>"
                                                         class="btn btn-outline-danger btn-sm"
                                                         title="Hapus"
                                                         onclick="return confirm('Yakin menghapus penjualan ini? Stok produk akan dikembalikan.')">
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
