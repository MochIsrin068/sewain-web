<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends User_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('m_category');
		$this->load->model('m_genre');
		
	} 
	public function index()
	{
		// TODO : halaman dashbord untuk user yang sudah terdaftar 
		$this->data[ "page_title" ] = "Buku Saya";
		$user = $this->user_auth->user()->row();//curr user
		$this->data["books"] = $this->book_service->books( $user->id_user )->result();
		$this->render( "user/dashboard/content" );
	}
}