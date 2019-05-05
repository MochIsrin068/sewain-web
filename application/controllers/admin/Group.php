<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('m_category');
		$this->load->model('m_genre');
	} 
	public function index()
	{
		$this->load->helper('form');
		$this->data[ "page_title" ] = "Grouping";
		$this->data[ "categories" ] = $this->m_category->categories()->result();
		$this->data[ "genres" ] = $this->m_genre->genres()->result();
		$this->render( "admin/group/V_list" );
	}
	public function add_category()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  

		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('name',  $this->lang->line('category_name'), 'trim|required');
		$this->form_validation->set_rules('description',  $this->lang->line('category_description'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');
			
			if($this->m_category->create( $data ))
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_category->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_category->errors() ) );
			}
			
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_category->errors() ? $this->m_category->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		redirect(site_url('admin/group'));  
	}

	public function edit_category(  )//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  
		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('name',  $this->lang->line('category_name'), 'trim|required');
		$this->form_validation->set_rules('description',  $this->lang->line('category_description'), 'trim|required');
		$this->form_validation->set_rules('id',  $this->lang->line('category_name'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');

			$data_param['id'] = $this->input->post('id');

			
			if($this->m_category->update( $data, $data_param  ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_category->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_category->errors() ) );
			}
			
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_category->errors() ? $this->m_category->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		}
		redirect(site_url('admin/group'));  
	}
	public function delete_category()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  

		$data_param['id'] = $this->input->post('id');
		if( $this->m_category->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_category->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_category->errors() ) );
		}
		redirect(site_url('admin/group'));  
	}

	// _genre
	public function add_genre()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  

		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('name',  $this->lang->line('category_name'), 'trim|required');
		$this->form_validation->set_rules('description',  $this->lang->line('category_description'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');
			
			if($this->m_genre->create( $data ))
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_genre->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_genre->errors() ) );
			}
			
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_genre->errors() ? $this->m_genre->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		redirect(site_url('admin/group'));  
	}

	public function edit_genre(  )//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  
		$this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('name',  $this->lang->line('category_name'), 'trim|required');
		$this->form_validation->set_rules('description',  $this->lang->line('category_description'), 'trim|required');
		$this->form_validation->set_rules('id',  $this->lang->line('category_name'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');

			$data_param['id'] = $this->input->post('id');

			
			if($this->m_genre->update( $data, $data_param  ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_genre->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_genre->errors() ) );
			}
			
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_genre->errors() ? $this->m_genre->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

		}
		redirect(site_url('admin/group'));  
	}
	public function delete_genre()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/group'));  

		$data_param['id'] = $this->input->post('id');
		if( $this->m_genre->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_genre->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_genre->errors() ) );
		}
		redirect(site_url('admin/group'));  
	}
}