<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| upload file.
| -------------------------------------------------------------------------
*/
$config['upload']["advertisement"]['file_name']                  					= 'IKLAN_';
$config['upload']["advertisement"]['upload_path']									= './'.ADVERTISEMENT_PHOTO_PATH;

$config['upload']['allowed_types']                 					                = 'gif|jpg|png|jpeg';
$config['upload']['overwrite']			           					                = "true";
$config['upload']['upload_config']['max_size']				                        = 20000000;

