<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* 
	*/
	class Upload_Images{
		
      public function config_image($file_name,$path){
          $config['image_library'] = 'gd2';
          $config['file_name']=$file_name;
          $config['upload_path']=$path;
          $config['allowed_types']='png|jpg|gif';
          $config['max_size']=5000;
          $config['max_height']=5000;
          $config['max_width']=5000;
          $config['overwrite']=TRUE;
          return $config;
      }

      public function session_validation()
      {
          if(empty($_SESSION['user'])){
            redirect('Login');       
          }
      }

	}

?>