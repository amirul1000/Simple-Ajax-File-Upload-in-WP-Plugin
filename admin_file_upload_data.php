<?php
  global $wpdb;
  $cmd='';
  $id = '';
  $cmd = isset($_REQUEST['cmd'])?$_REQUEST['cmd']:'';
  $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
  
  switch($cmd){
	case "save":
	         $created_at = "";
			 $updated_at = "";

			if($id<=0){
				 $created_at = date("Y-m-d H:i:s");
			 }
			else if($id>0){
				 $updated_at = date("Y-m-d H:i:s");
			 }

			$params = array(
			                'file' => $_REQUEST['file'],
							'created_at' =>$created_at,
							'updated_at' =>$updated_at,
							
							);
			
			 
			if($id>0){
			unset($params['created_at']);
			}if($id<=0){
			unset($params['updated_at']);
			} 
			if($id<=0){
			$res = $wpdb->insert($wpdb->prefix ."file_upload",$params);
			}
			if($id>0){
			
			 $res = $wpdb->update($wpdb->prefix ."file_upload",$params,array('id'=>$_REQUEST['id']));
			 
			}
			 ob_start();
             ob_end_flush();
			 echo "<script>";
			  echo "window.location.href = 'admin.php?page=file_upload_data';";
			 echo "</script>";
	      break;
	case "delete":  
	      $wpdb->delete($wpdb->prefix ."file_upload",array('id'=>$_REQUEST['id']));
		   ob_start();
           ob_end_flush();
		   echo "<script>";
			  echo "window.location.href = 'admin.php?page=file_upload_data';";
			 echo "</script>";
	      break;  
    case "edit":
	         if(!empty($_REQUEST['id'])){
		     	$file_upload_data  = $wpdb->get_results("select * from ".$wpdb->prefix ."file_upload where id='".$_REQUEST['id']."'"); 
			 }
			 include(dirname(__FILE__) . '/template/admin/file_upload_data/form.php');  
		  break;		  
	default:
	   $file_upload_data  = $wpdb->get_results("select * from ".$wpdb->prefix ."file_upload  ORDER BY id DESC"); 
	   include(dirname(__FILE__) . '/template/admin/file_upload_data/index.php');  
  }
?>