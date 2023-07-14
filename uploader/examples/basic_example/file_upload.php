<?php
//require_once(  ABSPATH  .'../../wp-config.php' );
require_once(  dirname(__FILE__)  .'/../../../../../../wp-load.php' );
    
//global $post;
global $wpdb;
require(dirname(__FILE__) . '/../../extras/Uploader.php');

// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
$upload_dir = ABSPATH . '/'.UPLOADS;

//echo $upload_dir;
$uploader = new FileUpload('uploadfile');

// Handle the upload
$result = $uploader->handleUpload($upload_dir);

if (!$result) {
  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
}
else{
       
		$created_at = date("Y-m-d H:i:s");
		$updated_at = date("Y-m-d H:i:s");
		
		$params = array(
			'file' => site_url(UPLOADS.'/'.$uploader->getFileName()),
			'created_at' =>$created_at,
			'updated_at' =>$updated_at
		);
	   $wpdb->insert($wpdb->prefix ."file_upload",$params);
}

echo json_encode(array('success' => true));
