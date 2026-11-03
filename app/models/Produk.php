<?php

// Update November 2024 — Produk CRUD lengkap (Project 6)

namespace App\Models;

use App\Core\Model;

class Produk extends Model
{
      /**
       * Daftar produk + nama kategori.
       */
      public function tampil()
      {
            $sql = "SELECT p.*, k.kat_nama AS ktgr
                    FROM tb_produk p
                    LEFT JOIN tb_kategori k ON p.produk_id_kat = k.kat_id
                    ORDER BY p.produk_id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $this->selects($stmt);
      }

      public function listKategori()
      {
            $sql = "SELECT kat_id, kat_nama FROM tb_kategori ORDER BY kat_nama";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $this->selects($stmt);
      }

      /**
       * Ambil 1 produk (untuk edit/detail).
       */
      public function edit($id)
      {
            $sql = "SELECT p.*, k.kat_nama AS ktgr
                    FROM tb_produk p
                    LEFT JOIN tb_kategori k ON p.produk_id_kat = k.kat_id
                    WHERE p.produk_id = :produk_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":produk_id", $id);
            $stmt->execute();

            return $this->select($stmt);
      }

      /**
       * Simpan produk baru. Melempar \InvalidArgumentException bila validasi gagal.
       */
      public function simpan()
      {
            $input = $this->validatedInput($_POST);
            $photo = $this->uploadPhoto(); // null bila tidak ada file diunggah
            $userId = $this->currentUserId();

            $sql = "INSERT INTO tb_produk
                    SET produk_id_kat = :produk_id_kat,
                        produk_id_user = :produk_id_user,
                        produk_kode = :produk_kode,
                        produk_nama = :produk_nama,
                        produk_hrg = :produk_hrg,
                        produk_keterangan = :produk_keterangan,
                        produk_stock = :produk_stock,
                        produk_photo = :produk_photo";
            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":produk_id_kat", $input['produk_id_kat'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_id_user", $userId, \PDO::PARAM_INT);
            $stmt->bindValue(":produk_kode", $input['produk_kode']);
            $stmt->bindValue(":produk_nama", $input['produk_nama']);
            $stmt->bindValue(":produk_hrg", $input['produk_hrg'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_keterangan", $input['produk_keterangan']);
            $stmt->bindValue(":produk_stock", $input['produk_stock'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_photo", $photo);

            $stmt->execute();
      }

      /**
       * Update produk. Foto lama dipertahankan bila tidak ada file baru.
       */
      public function update()
      {
            $input = $this->validatedInput($_POST);
            $id = (int) ($_POST['produk_id'] ?? 0);

            if ($id <= 0) {
                  throw new \InvalidArgumentException("ID produk tidak valid.");
            }

            $lama = $this->edit($id);
            if (!$lama) {
                  throw new \InvalidArgumentException("Produk tidak ditemukan.");
            }

            $photo = $this->uploadPhoto();

            if ($photo !== null) {
                  $sql = "UPDATE tb_produk SET produk_id_kat=:produk_id_kat, produk_kode=:produk_kode,
                          produk_nama=:produk_nama, produk_hrg=:produk_hrg, produk_keterangan=:produk_keterangan,
                          produk_stock=:produk_stock, produk_photo=:produk_photo, updated_at=NOW()
                          WHERE produk_id=:produk_id";
            } else {
                  $sql = "UPDATE tb_produk SET produk_id_kat=:produk_id_kat, produk_kode=:produk_kode,
                          produk_nama=:produk_nama, produk_hrg=:produk_hrg, produk_keterangan=:produk_keterangan,
                          produk_stock=:produk_stock, updated_at=NOW()
                          WHERE produk_id=:produk_id";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":produk_id_kat", $input['produk_id_kat'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_kode", $input['produk_kode']);
            $stmt->bindValue(":produk_nama", $input['produk_nama']);
            $stmt->bindValue(":produk_hrg", $input['produk_hrg'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_keterangan", $input['produk_keterangan']);
            $stmt->bindValue(":produk_stock", $input['produk_stock'], \PDO::PARAM_INT);
            $stmt->bindValue(":produk_id", $id, \PDO::PARAM_INT);

            if ($photo !== null) {
                  $stmt->bindValue(":produk_photo", $photo);
            }

            $stmt->execute();

            // Foto baru berhasil disimpan → hapus foto lama
            if ($photo !== null && !empty($lama['produk_photo'])) {
                  $this->deletePhotoFile($lama['produk_photo']);
            }
      }

      /**
       * Hapus produk beserta file fotonya.
       */
      public function hapus($id)
      {
            $id = (int) $id;
            $lama = $this->edit($id);

            $sql = "DELETE FROM tb_produk WHERE produk_id = :produk_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":produk_id", $id, \PDO::PARAM_INT);
            $stmt->execute();

            if ($lama && !empty($lama['produk_photo'])) {
                  $this->deletePhotoFile($lama['produk_photo']);
            }
      }

      /**
       * Validasi & normalisasi input POST. Lempar InvalidArgumentException bila gagal.
       */
      private function validatedInput(array $post): array
      {
            $idKat = (int) ($post['produk_id_kat'] ?? 0);
            $kode = trim((string) ($post['produk_kode'] ?? ''));
            $nama = trim((string) ($post['produk_nama'] ?? ''));
            $hrg = (int) ($post['produk_hrg'] ?? -1);
            $keterangan = trim((string) ($post['produk_keterangan'] ?? ''));
            $stock = (int) ($post['produk_stock'] ?? -1);

            if ($idKat <= 0) {
                  throw new \InvalidArgumentException("Kategori wajib dipilih.");
            }
            if ($kode === '' || mb_strlen($kode) > 50) {
                  throw new \InvalidArgumentException("Kode produk wajib diisi (maks 50 karakter).");
            }
            if ($nama === '' || mb_strlen($nama) > 256) {
                  throw new \InvalidArgumentException("Nama produk wajib diisi (maks 256 karakter).");
            }
            if ($hrg < 0) {
                  throw new \InvalidArgumentException("Harga produk tidak boleh negatif.");
            }
            if ($stock < 0) {
                  throw new \InvalidArgumentException("Stok tidak boleh negatif.");
            }

            // Pastikan kategori benar-benar ada
            $stmt = $this->db->prepare("SELECT kat_id FROM tb_kategori WHERE kat_id = :id");
            $stmt->bindValue(":id", $idKat, \PDO::PARAM_INT);
            $stmt->execute();
            if (!$stmt->fetch()) {
                  throw new \InvalidArgumentException("Kategori tidak ditemukan.");
            }

            return [
                  'produk_id_kat' => $idKat,
                  'produk_kode' => $kode,
                  'produk_nama' => $nama,
                  'produk_hrg' => $hrg,
                  'produk_keterangan' => $keterangan === '' ? null : $keterangan,
                  'produk_stock' => $stock,
            ];
      }

      /**
       * Upload & validasi foto. Kembalikan nama file, atau null bila tidak ada upload.
       */
      private function uploadPhoto(): ?string
      {
            if (empty($_FILES['produk_photo']) || $_FILES['produk_photo']['error'] === UPLOAD_ERR_NO_FILE) {
                  return null;
            }

            $file = $_FILES['produk_photo'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                  throw new \InvalidArgumentException("Gagal mengunggah foto (kode error {$file['error']}).");
            }
            if ($file['size'] > 2 * 1024 * 1024) {
                  throw new \InvalidArgumentException("Ukuran foto maksimal 2 MB.");
            }

            // Validasi MIME asli file (bukan ekstensi dari user)
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            $allowed = [
                  'image/jpeg' => 'jpg',
                  'image/png' => 'png',
                  'image/webp' => 'webp',
                  'image/gif' => 'gif',
            ];

            if (!isset($allowed[$mime])) {
                  throw new \InvalidArgumentException("Format foto harus JPG, PNG, WEBP, atau GIF.");
            }

            $filename = 'produk_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
            $target = ROOT . 'uploads' . DIRECTORY_SEPARATOR . 'produk' . DIRECTORY_SEPARATOR . $filename;

            if (!move_uploaded_file($file['tmp_name'], $target)) {
                  throw new \InvalidArgumentException("Gagal menyimpan foto ke server.");
            }

            return $filename;
      }

      /**
       * ID user yang sedang login (wajib, dijaga oleh cekLogin di controller).
       */
      private function currentUserId(): int
      {
            $userId = (int) ($_SESSION['user_id'] ?? 0);

            if ($userId <= 0) {
                  throw new \InvalidArgumentException("Sesi login tidak valid. Silakan login ulang.");
            }

            return $userId;
      }

      private function deletePhotoFile(string $filename): void
      {
            // Hanya nama file, tanpa path traversal
            $safe = basename($filename);
            $path = ROOT . 'uploads' . DIRECTORY_SEPARATOR . 'produk' . DIRECTORY_SEPARATOR . $safe;

            if (is_file($path)) {
                  @unlink($path);
            }
      }
}
