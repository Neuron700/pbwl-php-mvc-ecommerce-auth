<?php

namespace App\Controllers;

use App\Core\Controller;

class Login extends Controller
{
	// Autentikasi sudah tidak dipakai — arahkan ke dashboard
	public function index()
	{
		header('location:' . URL . '/dashboard');
		exit;
	}

	public function proses()
	{
		header('location:' . URL . '/dashboard');
		exit;
	}
}
