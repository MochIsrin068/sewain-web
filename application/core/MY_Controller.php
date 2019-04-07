<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public $APP_NAME = "jasain";
    public function __construct()
    {
       parent::__construct();

    }
}

class User_Controller extends MY_Controller
{
  public function __construct()
    {
       parent::__construct();
       
    }
}

class Admin_Controller extends User_Controller
{
   public function __construct()
    {
       parent::__construct();
        if(
            $this->session->userdata('user_level') != 1
        )
        {
            redirect(site_url('/user/login'));
        }
    }
}