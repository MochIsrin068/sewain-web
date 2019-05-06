<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct()
	{
			parent::__construct();
			$this->load->model('m_category');
			$this->load->model('m_genre');
	}
	public function index()
	{
		
		$genre_ids= array();
		if( ($_POST) )	
		{
			$genre_ids = $this->input->post('genre_ids[]');
		}
		if( $search = $this->input->get('search', FALSE) )
		{
			$this->data["books"] = $this->book_service->search( $search, $genre_ids )->result();
		}
		else
		{
			$this->data["books"] = $this->book_service->books( NULL, $genre_ids )->result();
		}
		$this->data["genre_ids"] = $genre_ids;
		$this->data[ "categories" ] = $this->m_category->categories()->result();
		$this->data[ "genres" ] = $this->m_genre->genres()->result();
		$this->render( 'V_landing_page' );
	}
}