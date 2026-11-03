<h2>Kategori</h2>

<a href="<?php echo URL; ?>/kategori/input" class="btn btn-primary mb-3">Input Kategori</a>

<table class="table table-bordered">
      <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>KETERANGAN</th>
            <th>EDIT</th>
      </tr>

      <?php foreach ($data['rows'] as $row) { ?>
            <tr>
                  <td><?php echo (int) $row['kat_id']; ?></td>
                  <td><?php echo e($row['kat_nama']); ?></td>
                  <td><?php echo e($row['kat_keterangan']); ?></td>
                  <td><a href="<?php echo URL; ?>/kategori/edit/<?php echo (int) $row['kat_id']; ?>" class="btn btn-primary">Edit</a></td>
            </tr>
      <?php } ?>

</table>