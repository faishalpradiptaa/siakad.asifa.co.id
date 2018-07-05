<?php

// Error reporting
//error_reporting(0);

// HTTP access control
// header('Access-Control-Allow-Origin: yourwebsite.com');
// header('Access-Control-Allow-Origin: www.yourwebsite.com');

session_start();

require dirname(__FILE__) . '/ImgPicker.php';

$options = array(

	// Upload directory path
	'upload_dir' => dirname(__FILE__) . '/../files/',

	// Upload directory url:
	//'upload_url' => 'http://localhost/imgPicker/files/',
	//'upload_url' => 'files/',    
    upload_url => 'http://localhost/pmb/assets/additional/imgPicker/files/',
	// Accepted file types:
	'accept_file_types' => 'png|jpg|jpeg|gif',
	
	// Directory mode:
	'mkdir_mode' => 0777,
	
	// File size restrictions (in bytes):
	'max_file_size' => null,
    'min_file_size' => 1,
    
    // Image resolution restrictions (in px):
    'max_width'  => null,
    'max_height' => null,
    'min_width'  => 1,
    'min_height' => 1,

    // Image versions:
    'versions' => array(
    	// This will create 2 image versions: the original one and a 200x200 one
    	'avatar' => array(
    		//'upload_dir' => '',
    		//'upload_url' => '',
    		// Create square image
    		'crop' => true,
    		'max_width' => 200,
    		'max_height' => 200
    	),
    ),

    /**
	 * 	Load callback
	 *
	 *  @param 	ImgPicker 		$instance
	 *  @return string|array
	 */
    'load' => function($instance) {
    	//return 'avatar.jpg';
    },

    /**
	 * 	Delete callback
	 *
	 *  @param  string 		    $filename
	 *  @param 	ImgPicker 		$instance
	 *  @return boolean
	 */
    'delete' => function($filename, $instance) {
    	return true;
    },
	
	/**
	 * 	Upload start callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'upload_start' => function($image, $instance) {
		$image->name = '~avatar.' . $image->type;		
	},
	
	/**
	 * 	Upload complete callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'upload_complete' => function($image, $instance) {
	},

	/**
	 * 	Crop start callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'crop_start' => function($image, $instance) {
		$image->name = 'avatar.' . $image->type;
	},

	/**
	 * 	Crop complete callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'crop_complete' => function($image, $instance) {
	}
);

// Create new ImgPicker instance
new ImgPicker($options);

/*
new ImgPicker($options, $messges);
	$messages - array of messages (See ImgPicker.php)
*/