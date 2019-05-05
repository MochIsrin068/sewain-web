<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['book']                       = 'book';
$config['tables']['category']                   = 'category';
$config['tables']['book_genre']	    		    = 'book_genre';
$config['tables']['genre']          	        = 'genre';
$config['tables']['table_user']          	        = 'table_user';
/*
 | join untuk table_user_profile dan table_user 
 |
 */
$config['join']['book']             = 'book_id';
$config['join']['genre']            = 'genre_id';
$config['join']['category']         = 'category_id';
$config['join']['table_user']       = 'user_id';
/*
| -------------------------------------------------------------------------
| upload file.
| -------------------------------------------------------------------------
*/
$config['upload']['file_name']                  					= 'BOOK_';
$config['upload']['upload_path']									= './'.BOOK_PHOTO_PATH;
$config['upload']['allowed_types']                 					= 'gif|jpg|png|jpeg';
$config['upload']['overwrite']			           					= "true";
$config['upload']['upload_config']['max_size']				        = 20000000;

