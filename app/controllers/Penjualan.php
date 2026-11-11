<?php

namespace App\Controllers;

use App\Core\Controller;

class Penjualan extends Controller
{
     public object $model;

     public function __construct()
     {
          $this->model = new \App\Models\Penjualan();
     }

     public function index()
     {
          $data['rows'] = $this->model->tampil();
          $data['ringkasan'] = $this->model->ringkasan();
          $this->dashboard('penjualan/index', $data);
     }

     public function input()
     {
          $data['listproduk'] = $this->model->listProduk();
          $this->dashboard('penjualan/input', $data);
     }

     public function simpan()
     {
          try {
               $this->model->simpan();
               $this->flash('success', 'Penjualan berhasil dicatat. Stok produk berkurang otomatis.');
          } catch (\InvalidArgumentException $e) {
               $this->flash('danger', $e->getMessage());
          } catch (\PDOException $e) {
               $this->flash('danger', 'Gagal menyimpan ke database.');
          }

          header('location:' . URL . '/penjualan');
          exit;
     }

     public function edit($id)
     {
          $row = $this->model->edit($id);

          if (!$row) {
               $this->flash('danger', 'Data penjualan tidak ditemukan.');
               header('location:' . URL . '/penjualan');
               exit;
          }

          $data['row'] = $row;
          $data['listproduk'] = $this->model->listProduk();
          $this->dashboard('penjualan/edit', $data);
     }

     public function update()
     {
          try {
               $this->model->update();
               $this->flash('success', 'Penjualan berhasil diperbarui.');
          } catch (\InvalidArgumentException $e) {
               $this->flash('danger', $e->getMessage());
          } catch (\PDOException $e) {
               $this->flash('danger', 'Gagal menyimpan ke database.');
          }

          header('location:' . URL . '/penjualan');
          exit;
     }

     public function hapus($id)
     {
          $this->model->hapus($id);
          $this->flash('success', 'Penjualan berhasil dihapus. Stok produk dikembalikan.');
          header('location:' . URL . '/penjualan');
          exit;
     }

     private function flash(string $type, string $message): void
     {
          $_SESSION['flash'] = ['type' => $type, 'message' => $message];
     }
}
