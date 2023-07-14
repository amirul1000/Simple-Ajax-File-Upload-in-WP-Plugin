<?php
   /*
	Plugin Name: File Upload
	Plugin URI: 
	Description: File Upload is an intelligent file_upload
	Version: 1.1
	Author: Amirul Momenin patainc@gmail.com
	Author URI: 
	License: GPL
	*/
	ob_start(); // line 1
	session_start(); // line 2
	$PLUGIN_URL = plugin_dir_url(__FILE__);
	define('FILEUPLOAD_PLUGIN_URL',substr($PLUGIN_URL,0,strlen($PLUGIN_URL)-1));
	define('FILEUPLOAD_PLUGIN_PATH', str_replace('\\', '/', dirname(__FILE__)) );
	define('UPLOADS', 'wp-content/uploads');
	
	if ( ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', __DIR__ . '/' );
	}

	
	// create hook for file uploading
	
	    ini_set("upload_max_filesize","5120M");
		ini_set("post_max_size","5120M");
		ini_set("max_input_time","-1");
	
	register_activation_hook(__FILE__,'file_upload_install'); 
	register_deactivation_hook( __FILE__, 'file_upload_remove' );
	function file_upload_install()
	 {  
	    create_page_2('file_upload');
	 
		global $file_upload_db_version;
		$file_upload_db_version = "1.0";
		global $wpdb;
		global $file_upload_db_version;
	
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	 
		
		
		add_option("file_upload_db_version", $file_upload_db_version);
		
	
	}
	
	function create_table_2() {
		global $wpdb;
		global $your_db_name;
		$charset_collate = $wpdb->get_charset_collate();
	 
		 $sql1 = "  CREATE TABLE ".$wpdb->prefix ."file_upload (
					  `id` int(10) NOT NULL AUTO_INCREMENT,		
					  `file` text,
					  `created_at` datetime DEFAULT NULL,
					  `updated_at` datetime DEFAULT NULL,
					   UNIQUE KEY id (id)
					) $charset_collate;";
					
		
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql1);
	}
	// run the install scripts upon plugin activation
	register_activation_hook(__FILE__,'create_table_2');
	
	function file_upload_remove()
	{
		global $wpdb;
		
		//remove page
		global $wpdb;
	
		$the_page_title = get_option( "my_plugin_page_title" );
		$the_page_name = get_option( "my_plugin_page_name" );
		$the_page_id = get_option( 'my_plugin_page_id' );
		if( $the_page_id ) {
			wp_delete_post( $the_page_id ); 
		}
		delete_option("my_plugin_page_title");
		delete_option("my_plugin_page_name");
		delete_option("my_plugin_page_id");
	}
	
	function create_page_2($title)
	{
		global $wpdb; 
		
		//file_upload
		$the_page_title = $title;
		$the_page_name = $title;
		
		delete_option("my_plugin_page_title");
		add_option("my_plugin_page_title", $the_page_title, '', 'yes');
		
		delete_option("my_plugin_page_name");
		add_option("my_plugin_page_name", $the_page_name, '', 'yes');
		
		delete_option("my_plugin_page_id");
		add_option("my_plugin_page_id", '0', '', 'yes');
		
		$the_page = get_page_by_title( $the_page_title );
		if ( ! $the_page ) {
			$_p = array();
			$_p['post_title'] = $the_page_title;
			$_p['post_content'] = "[".$title."]";
			$_p['post_status'] = 'publish';
			$_p['post_type'] = 'page';
			$_p['comment_status'] = 'closed';
			$_p['ping_status'] = 'closed';
			$_p['post_category'] = array(1);
			$the_page_id = wp_insert_post( $_p );
		}
	}

    //Admin		
	add_action('admin_menu', 'file_upload_manage');
	function file_upload_manage(){
	  add_menu_page('FileUpload Settings', 'FileUpload', 'manage_options', 'file_upload', 'file_upload_settings_func');
	  add_submenu_page( 'file_upload', 'FileUploadData', 'FileUploadData', 'manage_options', 'file_upload_data', 'file_upload_data_func');
	}
	 
	function file_upload_settings_func(){
		 include_once dirname(__FILE__) . '/admin_file_upload.php';   
	}   

	function file_upload_data_func(){
		 include_once dirname(__FILE__) . '/admin_file_upload_data.php';   
	} 
	
	//short code file_uploads
	function file_upload_sort_code_func( $atts ) {
		include_once dirname(__FILE__) . '/template/front/file_upload.php';
	}
	add_shortcode( 'file_upload', 'file_upload_sort_code_func' );
