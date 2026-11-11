<?php

namespace App\Core;

class Controller
{
	// Layout home
	public function login($view)
	{
		require_once ROOT . "layouts/login.php";
	}

	// layout dashboard
	public function dashboard($view, $data = [])
	{
		require_once ROOT . "layouts/dashboard.php";
	}

	// Proyek ini TIDAK memakai autentikasi — halaman terbuka untuk semua
	public static function cekLogin()
	{
		// Sengaja kosong: tidak perlu login untuk mengakses halaman mana pun
		return;
	}
}
