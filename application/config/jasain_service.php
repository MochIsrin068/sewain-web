<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['table_user']                     = 'table_user';
$config['tables']['table_service']                  = 'table_service';
$config['tables']['table_portofolio']               = 'table_portofolio';
$config['tables']['table_category']                 = 'table_category';
/*
 | join untuk table_user_profile dan table_user 
 |
 */
$config['join']['table_user']           = 'id_user';
$config['join']['table_service']        = 'id_service';
$config['join']['table_portofolio']     = 'id_portofolio';
$config['join']['table_category']       = 'id_category';
