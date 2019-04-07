<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_app extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function read( $app_id = -1 )
    {
        $sql = "
            SELECT * from app
        ";
        if( $app_id != -1 ){
            $sql .= "
                where app_id = '$app_id'
            ";  
        }
        return $query = $this->db->query($sql)->result();
    }
}

