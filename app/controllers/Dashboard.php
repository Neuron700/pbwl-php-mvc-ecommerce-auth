<?php

namespace App\Controllers;

use App\Core\Controller;

class Dashboard extends Controller
{

	public function __construct()
	{
		parent::cekLogin();
	}

	public function index()
	{
		$this->dashboard('dashboard/index');
	}

	public function logout()
	{
		$_SESSION = [];

		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
		}

		session_destroy();
		header('location:' . URL);
		exit;
	}
}
