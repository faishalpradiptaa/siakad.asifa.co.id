<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class MY_Controller extends CI_Controller{
	
		function __construct() {
			parent::__construct();
		}   
	}
	require_once APPPATH.'core/custom/admin_controller.php';
	require_once APPPATH.'core/custom/crud_controller.php';
	require_once APPPATH.'core/custom/crud_periodik_controller.php';
	require_once APPPATH.'core/custom/tr_periodik_controller.php';
	
?>