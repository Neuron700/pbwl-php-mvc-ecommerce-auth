<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
      <div>
            <h1 class="h4 fw-bold mb-0"><i class="bi bi-tags"></i> Kategori</h1>
            <p class="text-muted small mb-0">Kelola kategori produk Anda.</p>
      </div>
      <a href="<?php echo URL; ?>/kategori/input" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Input Kategori</a>
</div>

<div class="card shadow-sm">
      <div class="card-body p-0">
            <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                              <tr>
                                    <th class="ps-3">NO</th>
                                    <th>NAMA</th>
                                    <th>KETERANGAN</th>
                                    <th class="text-end pe-3">AKSI</th>
                              </tr>
                        </thead>
                        <tbody>
                              <?php if (empty($data['rows'])) { ?>
                                    <tr>
                                          <td colspan="4" class="text-center text-muted py-4">
                                                Belum ada kategori. Klik <strong>Input Kategori</strong>.
                                          </td>
                                    </tr>
                              <?php } ?>
                              <?php $no = 1; foreach ($data['rows'] as $row) { ?>
                                    <tr>
                                          <td class="ps-3"><?php echo $no++; ?></td>
                                          <td class="fw-semibold"><?php echo e($row['kat_nama']); ?></td>
                                          <td><?php echo e($row['kat_keterangan']); ?></td>
                                          <td class="text-end pe-3">
                                                <div class="d-flex justify-content-end gap-1">
                                                      <a href="<?php echo URL; ?>/kategori/edit/<?php echo (int) $row['kat_id']; ?>" class="btn btn-outline-primary btn-sm" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                      </a>
                                                      <a href="<?php echo URL; ?>/kategori/hapus/<?php echo (int) $row['kat_id']; ?>"
                                                         class="btn btn-outline-danger btn-sm"
                                                         title="Hapus"
                                                         onclick="return confirm('Yakin hapus kategori \"<?php echo e($row['kat_nama']); ?>\"? Produk yang memakai kategori ini akan memblokir penghapusan.')">
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
