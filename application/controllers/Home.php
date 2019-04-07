<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		// TODO : tampilkan landing page bagi user yang belum daftar
		$this->load->view("V_landing_page");
	}
}