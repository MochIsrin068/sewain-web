<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		
	} 
	public function index()
	{
		$data['page_name'] = "Beranda";

		$this->load->view("_admin/_template/header");
		$this->load->view("_admin/_template/sidebar_menu");
			$this->load->view("_admin/_template/content", $data);
		$this->load->view("_admin/_template/footer");  
	}
}
