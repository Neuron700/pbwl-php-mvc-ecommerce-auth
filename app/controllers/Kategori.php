<?php

// Update November 2024

namespace App\Controllers;

use App\Core\Controller;

class Kategori extends Controller
{
	public object $model;

	public function __construct()
	{
		parent::cekLogin();

		$this->model = new \App\Models\Kategori();
	}

	public function index()
	{
		$data['rows'] = $this->model->tampil();
		$this->dashboard('kategori/index', $data);
	}

	public function input()
	{
		$this->dashboard('kategori/input');
	}

	public function simpan()
	{
		$this->model->simpan();
		$this->flash('success', 'Kategori berhasil ditambahkan.');
		header('location:' . URL . '/kategori');
		exit;
	}

	public function edit($id)
	{
		$data['row'] = $this->model->edit($id);

		if (!$data['row']) {
			$this->flash('danger', 'Kategori tidak ditemukan.');
			header('location:' . URL . '/kategori');
			exit;
		}

		$this->dashboard('kategori/edit', $data);
	}

	public function update()
	{
		$this->model->update();
		$this->flash('success', 'Kategori berhasil diperbarui.');
		header('location:' . URL . '/kategori');
		exit;
	}

	public function hapus($id)
	{
		try {
			$this->model->hapus($id);
			$this->flash('success', 'Kategori berhasil dihapus.');
		} catch (\PDOException $e) {
			// FK RESTRICT: kategori masih dipakai produk
			$this->flash('danger', 'Kategori tidak dapat dihapus karena masih digunakan produk.');
		}

		header('location:' . URL . '/kategori');
		exit;
	}

	private function flash(string $type, string $message): void
	{
		$_SESSION['flash'] = ['type' => $type, 'message' => $message];
	}
}
