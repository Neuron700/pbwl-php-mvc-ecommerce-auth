<?php

namespace App\Models;

use App\Core\Model;

class Penjualan extends Model
{
      /**
       * Daftar penjualan + data produk.
       */
      public function tampil()
      {
            $sql = "SELECT p.*, pr.produk_kode, pr.produk_nama
                    FROM tb_penjualan p
                    JOIN tb_produk pr ON pr.produk_id = p.produk_id
                    ORDER BY p.penjualan_id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $this->selects($stmt);
      }

      /**
       * Produk untuk dropdown form.
       */
      public function listProduk()
      {
            $sql = "SELECT produk_id, produk_kode, produk_nama, produk_hrg, produk_stock
                    FROM tb_produk
                    ORDER BY produk_nama";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $this->selects($stmt);
      }

      /**
       * Ringkasan untuk kartu di halaman daftar.
       */
      public function ringkasan(): array
      {
            $transaksi = (int) $this->db->query("SELECT COUNT(*) FROM tb_penjualan")->fetchColumn();
            $qty = (int) $this->db->query("SELECT COALESCE(SUM(qty), 0) FROM tb_penjualan")->fetchColumn();
            $omzet = (int) $this->db->query("SELECT COALESCE(SUM(total), 0) FROM tb_penjualan")->fetchColumn();

            return ['transaksi' => $transaksi, 'qty' => $qty, 'omzet' => $omzet];
      }

      public function edit($id)
      {
            $stmt = $this->db->prepare("SELECT * FROM tb_penjualan WHERE penjualan_id = :id");
            $stmt->bindValue(':id', (int) $id, \PDO::PARAM_INT);
            $stmt->execute();

            return $this->select($stmt);
      }

      /**
       * Simpan penjualan baru + kurangi stok produk (dalam transaksi).
       */
      public function simpan()
      {
            $tgl = $this->validateTanggal($_POST['tgl_penjualan'] ?? '');
            $produkId = (int) ($_POST['produk_id'] ?? 0);
            $qty = (int) ($_POST['qty'] ?? 0);

            if ($qty < 1) {
                  throw new \InvalidArgumentException('Jumlah (qty) minimal 1.');
            }

            $this->db->beginTransaction();

            try {
                  $produk = $this->ambilProdukLock($produkId);

                  if (!$produk) {
                        throw new \InvalidArgumentException('Produk tidak ditemukan.');
                  }
                  if ((int) $produk['produk_stock'] < $qty) {
                        throw new \InvalidArgumentException('Stok produk tidak cukup (sisa ' . (int) $produk['produk_stock'] . ').');
                  }

                  $harga = (int) $produk['produk_hrg'];
                  $total = $qty * $harga;

                  $stmt = $this->db->prepare(
                        "INSERT INTO tb_penjualan SET tgl_penjualan = :tgl, produk_id = :produk_id, qty = :qty, harga_satuan = :harga, total = :total"
                  );
                  $stmt->bindValue(':tgl', $tgl);
                  $stmt->bindValue(':produk_id', $produkId, \PDO::PARAM_INT);
                  $stmt->bindValue(':qty', $qty, \PDO::PARAM_INT);
                  $stmt->bindValue(':harga', $harga, \PDO::PARAM_INT);
                  $stmt->bindValue(':total', $total, \PDO::PARAM_INT);
                  $stmt->execute();

                  // Kurangi stok
                  $upd = $this->db->prepare(
                        "UPDATE tb_produk SET produk_stock = produk_stock - :q, updated_at = NOW() WHERE produk_id = :id"
                  );
                  $upd->bindValue(':q', $qty, \PDO::PARAM_INT);
                  $upd->bindValue(':id', $produkId, \PDO::PARAM_INT);
                  $upd->execute();

                  $this->db->commit();
            } catch (\Throwable $e) {
                  $this->db->rollBack();
                  throw $e;
            }
      }

      /**
       * Update penjualan: sesuaikan stok berdasarkan selisih qty.
       */
      public function update()
      {
            $id = (int) ($_POST['penjualan_id'] ?? 0);
            if ($id <= 0) {
                  throw new \InvalidArgumentException('ID penjualan tidak valid.');
            }

            $tgl = $this->validateTanggal($_POST['tgl_penjualan'] ?? '');
            $produkId = (int) ($_POST['produk_id'] ?? 0);
            $qtyBaru = (int) ($_POST['qty'] ?? 0);

            if ($qtyBaru < 1) {
                  throw new \InvalidArgumentException('Jumlah (qty) minimal 1.');
            }

            $this->db->beginTransaction();

            try {
                  $row = $this->edit($id);
                  if (!$row) {
                        throw new \InvalidArgumentException('Penjualan tidak ditemukan.');
                  }

                  $qtyLama = (int) $row['qty'];
                  $delta = $qtyBaru - $qtyLama;

                  $produk = $this->ambilProdukLock($produkId);
                  if (!$produk) {
                        throw new \InvalidArgumentException('Produk tidak ditemukan.');
                  }
                  if ($delta > 0 && (int) $produk['produk_stock'] < $delta) {
                        throw new \InvalidArgumentException('Stok produk tidak cukup untuk menambah qty (sisa ' . (int) $produk['produk_stock'] . ').');
                  }

                  $harga = (int) $produk['produk_hrg'];
                  $total = $qtyBaru * $harga;

                  $stmt = $this->db->prepare(
                        "UPDATE tb_penjualan
                            SET tgl_penjualan = :tgl, produk_id = :produk_id, qty = :qty, harga_satuan = :harga, total = :total
                          WHERE penjualan_id = :id"
                  );
                  $stmt->bindValue(':tgl', $tgl);
                  $stmt->bindValue(':produk_id', $produkId, \PDO::PARAM_INT);
                  $stmt->bindValue(':qty', $qtyBaru, \PDO::PARAM_INT);
                  $stmt->bindValue(':harga', $harga, \PDO::PARAM_INT);
                  $stmt->bindValue(':total', $total, \PDO::PARAM_INT);
                  $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
                  $stmt->execute();

                  // Sesuaikan stok berdasarkan selisih (delta bisa negatif = stok kembali)
                  if ($delta !== 0) {
                        $upd = $this->db->prepare(
                              "UPDATE tb_produk SET produk_stock = produk_stock - :delta, updated_at = NOW() WHERE produk_id = :id"
                        );
                        $upd->bindValue(':delta', $delta, \PDO::PARAM_INT);
                        $upd->bindValue(':id', $produkId, \PDO::PARAM_INT);
                        $upd->execute();
                  }

                  $this->db->commit();
            } catch (\Throwable $e) {
                  $this->db->rollBack();
                  throw $e;
            }
      }

      /**
       * Hapus penjualan + kembalikan stok produk.
       */
      public function hapus($id)
      {
            $id = (int) $id;
            $row = $this->edit($id);

            if (!$row) {
                  return;
            }

            $this->db->beginTransaction();

            try {
                  $del = $this->db->prepare("DELETE FROM tb_penjualan WHERE penjualan_id = :id");
                  $del->bindValue(':id', $id, \PDO::PARAM_INT);
                  $del->execute();

                  $upd = $this->db->prepare(
                        "UPDATE tb_produk SET produk_stock = produk_stock + :q, updated_at = NOW() WHERE produk_id = :id"
                  );
                  $upd->bindValue(':q', (int) $row['qty'], \PDO::PARAM_INT);
                  $upd->bindValue(':id', (int) $row['produk_id'], \PDO::PARAM_INT);
                  $upd->execute();

                  $this->db->commit();
            } catch (\Throwable $e) {
                  $this->db->rollBack();
                  throw $e;
            }
      }

      private function ambilProdukLock($produkId)
      {
            $stmt = $this->db->prepare(
                  "SELECT produk_id, produk_nama, produk_hrg, produk_stock FROM tb_produk WHERE produk_id = :id FOR UPDATE"
            );
            $stmt->bindValue(':id', (int) $produkId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();
      }

      private function validateTanggal($s)
      {
            $d = \DateTime::createFromFormat('Y-m-d', trim((string) $s));

            if (!$d) {
                  throw new \InvalidArgumentException('Tanggal penjualan tidak valid.');
            }

            return $d->format('Y-m-d');
      }
}
