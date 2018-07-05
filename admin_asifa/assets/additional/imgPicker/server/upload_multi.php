<?php

// Error reporting
//error_reporting(0);

// HTTP access control
// header('Access-Control-Allow-Origin: yourwebsite.com');
// header('Access-Control-Allow-Origin: www.yourwebsite.com');

session_start();

require dirname(__FILE__) . '/Database/Database.php';

require dirname(__FILE__) . '/ImgPicker.php';

$options = array(

	// Upload directory path
	'upload_dir' => dirname(__FILE__) . '/../files/',

	// Upload directory url:
	'upload_url' => 'files/',

    /**
	 * 	Load callback
	 *
	 *  @param 	ImgPicker 		$instance
	 *  @return string|array
	 */
    'load' => function($instance) {
    	$db = new Database;
    	$results = $db->table('example_images')->get();

    	$images = array();
    	foreach ($results as $result) {
    		$images[] = $result->image;
    	}
    	return $images;
    },

    /**
	 * 	Delete callback
	 *
	 *  @param  string 		    $filename
	 *  @param 	ImgPicker 		$instance
	 *  @return boolean
	 */
    'delete' => function($filename, $instance) {
    	//return true;
    },
	
	/**
	 * 	Upload start callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'upload_start' => function($image, $instance) {
		//$image->name = '~4513.' . $image->type;		
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
		//$image->name = '4513.' . $image->type;
	},

	/**
	 * 	Crop complete callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'crop_complete' => function($image, $instance) {
		$data = array(
			'user_id' => 1,
			'image' => $image->name
		);

		$db = new Database;
		$db->table('example_images')->insert($data);
	}
);

// Create new ImgPicker instance
new ImgPicker($options);

/*
new ImgPicker($options, $messges);
	$messages - array of messages (See ImgPicker.php)
*/