<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = array();
    public function __construct()
    {
       parent::__construct();
    }
    protected function render($the_view = NULL, $template = NULL)
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view, $this->data );
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/V_' . $template . '', $this->data);
		}
	}
}

class User_Controller extends MY_Controller
{
    public function __construct()
    {
       parent::__construct();
       if( !$this->user_auth->logged_in() ) redirect(site_url('/auth/login'));
    }
    protected function render($the_view = NULL, $template = 'user_master')
	{
		parent::render($the_view, $template);
	}
    
}

class Admin_Controller extends User_Controller
{
    public function __construct()
    {
       parent::__construct();
		if(!$this->user_auth->is_admin()) 
		{
			$this->user_auth->logout();
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, "anda harus menjadi admin!" ) );
			redirect(site_url('/auth/login'));
		}
    }
    protected function render($the_view = NULL, $template = 'admin_master')
	{
		parent::render($the_view, $template);
	}
}

class Public_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
    }
    protected function render($the_view = NULL, $template = 'public_master')
	{
		parent::render($the_view, $template);
	}
}