<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| File Upload
|--------------------------------------------------------------------------
*/

$config['upload'] = array(
	'allowed_types' => 'gif|jpg|png|rar|zip|doc|docx|xls|xlsx|ppt|pptx|txt',
	'max_size' => 5000, // 5mb
	'overwrite' => true,
);

/*
|--------------------------------------------------------------------------
| Misc
|--------------------------------------------------------------------------
*/
$config['max_failed_login_attempts'] = 5;
$config['delay_failed_login_attempts'] = 18000;


?>