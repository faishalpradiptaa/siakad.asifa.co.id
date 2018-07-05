<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/  //$CI =& get_instance();
    //$accessed_class=$CI->router->fetch_class();
    //$accessed_method=$CI->router->fetch_method();

    $hook['post_controller_constructor'][]=array(
                                'class'=>'checkpermition',
                                'function'=>'run',
                                'filename'=>'action_permition.php',
                                'filepath'=>'hooks',
                                'params'=>array(
                                            //'accessed_class'=>$accessed_class,
//                                            'accessed_method'=>$accessed_method
                                            )
    );


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */