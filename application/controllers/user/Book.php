<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends User_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_category');
		$this->load->model('m_genre');
	} 
	public function index()
	{
		$user = $this->user_auth->user()->row();//curr user
		$this->data[ "page_title" ] = "Daftar Buku Saya";
		$this->data["books"] = $this->book_service->books( $user->id_user )->result();
		$this->render( "user/book/V_list" );		
	}
	public function add()
	{
		$this->load->helper('form');
		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules( $this->book_service->get_validation_config() );

		if ( $this->form_validation->run() === TRUE )
		{
			$data['title'] = $this->input->post('title');
			$data['description'] = $this->input->post('description');
			$data['language'] = $this->input->post('language');
			$data['author'] = $this->input->post('author');
			$data['page_count'] = $this->input->post('page_count');
			$data['publisher'] = $this->input->post('publisher');
			$data['price'] = $this->input->post('price');
			$data['category_id'] = $this->input->post('category_id');

			// echo var_dump( $this->input->post('genre_ids[]') );
			$genre_ids = $this->input->post('genre_ids[]');
			if($this->book_service->add_book( $data, $genre_ids ) )
			{
				echo $this->book_service->messages();
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->book_service->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->book_service->errors() ) );
			}
			redirect(site_url('user/book/add'));  
		}
		else
		{
			$this->data = $this->book_service->get_form_data(); //harus paling pertama

			$this->data[ "page_title" ] = "Tambah Buku";
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_category->errors() ? $this->m_category->errors() : $this->session->flashdata('message')));
			if( !empty($this->data['message']) )  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
			$this->render( "user/book/V_add" );		
		}
	}
	public function edit( $id = NULL )
	{
		$id = ( isset( $id ) ) ? $id : $this->input->post('id');
		if( $id == NULL ) redirect(site_url('user/book'));  

		$this->load->helper('form');
		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules( $this->book_service->get_validation_config() );

		if ( $this->form_validation->run() === TRUE )
		{
			$data['title'] = $this->input->post('title');
			$data['description'] = $this->input->post('description');
			$data['language'] = $this->input->post('language');
			$data['author'] = $this->input->post('author');
			$data['page_count'] = $this->input->post('page_count');
			$data['publisher'] = $this->input->post('publisher');
			$data['price'] = $this->input->post('price');
			$data['category_id'] = $this->input->post('category_id');

			$data_param['id'] = $this->input->post('id');

			$genre_ids = $this->input->post('genre_ids[]');
			
			if($this->book_service->edit_book( $data, $data_param, $genre_ids ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->book_service->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->book_service->errors() ) );
			}
			redirect(site_url('user/book/'));
		}
		else
		{
			$this->data = $this->book_service->get_form_data( $id ); //harus paling pertama

			$this->data[ "page_title" ] = "Edit Buku";
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_category->errors() ? $this->m_category->errors() : $this->session->flashdata('message')));
			if( !empty($this->data['message']) )  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

			$this->data["book"] = $this->book_service->book( $id )->row();
			$this->render( "user/book/V_edit" );		
		}
	}
	public function delete_image()
	{
		if( !($_POST) )	redirect(site_url('user/book'));

		$image_index = $this->input->post('image_index');
		$book_id = $this->input->post('id');
		if( $this->book_service->delete_image( $image_index, $book_id ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->book_service->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->book_service->errors() ) );
		}
		redirect(site_url('user/book'));  
	}
	public function add_image()
	{
		if( !($_POST) )	redirect(site_url('user/book'));

		$image_index = $this->input->post('image_index');
		$book_id = $this->input->post('id');
		if( $this->book_service->add_image( $book_id ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->book_service->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->book_service->errors() ) );
		}
		redirect(site_url('user/book'));  
	}
	public function delete()
	{
		if( !($_POST) )	redirect(site_url('user/book'));

		$data_param['id'] = $this->input->post('id');
		if( $this->book_service->delete_book( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->book_service->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->book_service->errors() ) );
		}
		redirect(site_url('user/book'));  
	}
}