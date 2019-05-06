<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iklan extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('m_advertisement');
		$this->config->load('sewain', TRUE);
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Pengiklanan";
		$this->data[ "advertisements" ] = $this->m_advertisement->advertisements()->result();
		$this->render( "admin/advertisement/V_list" );
		// echo'<img src="http://localhost/sewain2/uploads/advertirsement_photo/ADVERTISEMENT_1_1557132668.png" alt="asddsa" height="auto" width="50000" >';
	}
	public function add()
    {
        $this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('image',  $this->lang->line('advertisement_image'), 'trim|required');
		$this->form_validation->set_rules('description',  $this->lang->line('advertisement_description'), 'trim|required');
		$this->form_validation->set_rules('order',  $this->lang->line('advertisement_order'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$_data =  $this->input->post( "image" ) ;
			list($type, $_data) = explode(';', $_data);
			list(, $_data)      = explode(',', $_data);
			$_data = base64_decode($_data);
			
			$upload = $this->config->item('upload', 'sewain');
			echo var_dump( $upload );
			$user = $this->user_auth->user()->row();//curr user
			$file_name = $upload["advertisement"]['file_name'].$user->id_user."_".time().'.jpg';
			$upload_path = $upload["advertisement"]['upload_path'];
			
			
			if( file_put_contents($upload_path.$file_name, $_data) )
			{
				$data['description'] 	= $this->input->post('description');
				$data['order'] 			= $this->input->post('order');
				$data['image'] 			= $file_name;
				
				if($this->m_advertisement->create( $data ))
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_advertisement->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_advertisement->errors() ) );
				}
			}
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_advertisement->errors() ? $this->m_advertisement->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect(site_url('admin/iklan'));  
	}
	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/iklan'));  

		$data_param['id'] = $this->input->post('id');
		$image = $this->input->post('image');
		
		if( $this->m_advertisement->delete( $data_param ) )
		{
			$upload = $this->config->item('upload', 'sewain');
			$upload_path = $upload["advertisement"]['upload_path'];
			@unlink( $upload_path.$image );

			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_advertisement->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_advertisement->errors() ) );
		}
		redirect(site_url('admin/iklan'));  
	}
	
}