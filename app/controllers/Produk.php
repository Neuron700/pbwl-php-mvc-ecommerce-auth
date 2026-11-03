<?php

// Update November 2024 — Produk CRUD lengkap (Project 6, wajib login)

namespace App\Controllers;

use App\Core\Controller;

class Produk extends Controller
{
     public object $model;

     public function __construct()
     {
          parent::cekLogin();

          $this->model = new \App\Models\Produk();
     }

     public function index()
     {
          $data['rows'] = $this->model->tampil();
          $this->dashboard('produk/index', $data);
     }

     public function input()
     {
          $data['listkategori'] = $this->model->listKategori();
          $this->dashboard('produk/input', $data);
     }

     public function simpan()
     {
          try {
               $this->model->simpan();
               $this->flash('success', 'Produk berhasil ditambahkan.');
          } catch (\InvalidArgumentException $e) {
               $this->flash('danger', $e->getMessage());
          } catch (\PDOException $e) {
               $this->flash('danger', $this->pdoMessage($e));
          }

          header('location:' . URL . '/produk');
          exit;
     }

     public function edit($id)
     {
          $row = $this->model->edit($id);

          if (!$row) {
               $this->flash('danger', 'Produk tidak ditemukan.');
               header('location:' . URL . '/produk');
               exit;
          }

          $data['row'] = $row;
          $data['listkategori'] = $this->model->listKategori();
          $this->dashboard('produk/edit', $data);
     }

     public function update()
     {
          try {
               $this->model->update();
               $this->flash('success', 'Produk berhasil diperbarui.');
          } catch (\InvalidArgumentException $e) {
               $this->flash('danger', $e->getMessage());
          } catch (\PDOException $e) {
               $this->flash('danger', $this->pdoMessage($e));
          }

          header('location:' . URL . '/produk');
          exit;
     }

     public function hapus($id)
     {
          $this->model->hapus($id);
          $this->flash('success', 'Produk berhasil dihapus.');
          header('location:' . URL . '/produk');
          exit;
     }

     public function detail($id)
     {
          $row = $this->model->edit($id);

          if (!$row) {
               $this->flash('danger', 'Produk tidak ditemukan.');
               header('location:' . URL . '/produk');
               exit;
          }

          $data['row'] = $row;
          $this->dashboard('produk/detail', $data);
     }

     private function flash(string $type, string $message): void
     {
          $_SESSION['flash'] = ['type' => $type, 'message' => $message];
     }

     /**
      * Pesan ramah untuk error PDO (mis. kode produk duplikat).
      */
     private function pdoMessage(\PDOException $e): string
     {
          if ($e->getCode() === '23000') {
               return 'Kode produk sudah dipakai. Gunakan kode lain.';
          }

          return 'Gagal menyimpan ke database.';
     }
}
