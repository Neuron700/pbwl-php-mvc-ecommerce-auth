<?php

namespace App\Controllers;

use App\Core\Controller;

class Index extends Controller
{
	public function index()
	{
		header('location:' . URL . '/dashboard');
		exit;
	}
}
