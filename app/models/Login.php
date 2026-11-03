<?php

namespace App\Models;

use App\Core\Model;

class Login extends Model
{
      /**
       * Ambil user berdasarkan email, lalu verifikasi password dengan password_verify().
       * Mengembalikan data user (tanpa hash) atau null bila gagal.
       */
      public function proses()
      {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                  return null;
            }

            $query = "SELECT * FROM tb_users WHERE user_email = :user_email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":user_email", $email);
            $stmt->execute();

            $row = $stmt->fetch();

            if (!$row || !password_verify($password, $row['user_password'])) {
                  return null;
            }

            // Jangan pernah membawa hash ke session/view
            unset($row['user_password']);

            return $row;
      }
}
