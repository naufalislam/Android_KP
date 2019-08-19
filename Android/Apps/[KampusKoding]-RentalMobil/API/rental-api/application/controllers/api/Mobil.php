<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class Mobil extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per mobil/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per mobil/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per mobil/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per mobil/key
		
		#Configure load model api table mobil
		$this->load->model('m_mobil');
	}


	function index_get($id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get mobil' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No mobil were found' , 'data' => null );
        
		#
		if (!empty($this->get('ID_MOBIL')))
			$id=$this->get('ID_MOBIL');
            

		if ($id==null) {
			#Call methode get_all from m_mobil model
			$mobil=$this->m_mobil->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from m_mobil model
			$mobil=$this->m_mobil->get_by_id($id);
		}


        # Check if the mobil data store contains mobil
		if ($mobil) {
			if (count($mobil)==1)
				if (isset($mobil->IMAGE)) {
					$mobil->IMAGE=explode(',', $mobil->IMAGE);
				}else{
					$mobil[0]->IMAGE=explode(',', $mobil[0]->IMAGE);
				}
			else
				for ($i=0; $i <count($mobil) ; $i++)
					$mobil[$i]->IMAGE=explode(',', $mobil[$i]->IMAGE);
			// exit();
			$response['SUCCESS']['data']=$mobil;

			#if found mobil
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{
 
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){

		#
		$mobil_data = array('NAMA_MOBIL' =>$this->post('NAMA_MOBIL') , 
							'MERK_MOBIL' => $this->post('MERK_MOBIL') ,
							'DESKRIPSI_MOBIL' => $this->post('DESKRIPSI_MOBIL') , 
							'TAHUN_MOBIL' => $this->post('TAHUN_MOBIL') ,
							'KAPASITAS_MOBIL' => $this->post('KAPASITAS_MOBIL') ,
							'HARGA_MOBIL' => $this->post('HARGA_MOBIL') ,
							'WARNA_MOBIL' => $this->post('WARNA_MOBIL') ,
							'BENSIN_MOBIL' => 1,

							'PLAT_NO_MOBIL' =>$this->post('PLAT_NO_MOBIL'),
							'STATUS_SEWA'=>0,
							'STATUS_MOBIL'=>$this->post('STATUS_MOBIL'),
							'CREATED_MOBIL'=>date('Y-m-d h:i:s'),
						);

		 

		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		$mobil_photo=null;

		#Upload avatar
		if ($this->Upload_Images($image_name)){
			$mobil_photo['IMAGE']=$image_name;
			$mobil_photo['ID_MOBIL']=$image_name;
		}
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $mobil_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail insert data' , 'data' => null );
		
		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => null );

		if ($this->m_mobil->get_by_plat($this->post('PLAT_NO_MOBIL'))){
		
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		}

		#Check if insert mobil_data Success
		$id=$this->m_mobil->insert($mobil_data,$mobil_photo);
		if ($id) {
			$mobil_data["ID_MOBIL"]=$id;
			$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $mobil_data );

			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{
			#Remove image mobil
			if ($mobil_data['PHOTO']!=null) {
				$this->remove_image($mobil_data['PHOTO']);
			}
			
			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success delete mobil'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail delete mobil'  );
		
		#Set response API if mobil not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no mobil were found' );


		#Check available mobil
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('ID_MOBIL')))
			$id=$this->get('ID_MOBIL');
		
		if ($this->m_mobil->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('ID_MOBIL');

		$mobil_data = array('NAMA_MOBIL' =>$this->put('NAMA_MOBIL') , 
							'MERK_MOBIL' => $this->put('MERK_MOBIL') ,
							'DESKRIPSI_MOBIL' => $this->put('DESKRIPSI_MOBIL') , 
							'TAHUN_MOBIL' => $this->put('TAHUN_MOBIL') ,
							'KAPASITAS_MOBIL' => $this->put('KAPASITAS_MOBIL') ,
							'HARGA_MOBIL' => $this->put('HARGA_MOBIL') ,
							'WARNA_MOBIL' => $this->put('WARNA_MOBIL') ,
							'BENSIN_MOBIL' => $this->put('BENSIN_MOBIL') ,
							'PLAT_NO_MOBIL' =>$this->put('PLAT_NO_MOBIL'),
							'STATUS_MOBIL'=>$this->put('STATUS_MOBIL'),
							'CREATED_MOBIL'=>date('Y-m-d h:i:s'),
						);


		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		$mobil_photo=null;

		#Upload avatar
		if ($this->Upload_Images($image_name)){
			$mobil_photo['IMAGE']=$image_name;
			$mobil_photo['ID_MOBIL']=$image_name;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update mobil' , 'data' => $mobil_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail update mobil' , 'data' => $mobil_data );
		
		#Set response API if mobil not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no mobil were found' , 'data' => $mobil_data );

		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => $mobil_data );

		#Check available mobil
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);

		if ($this->m_mobil->get_by_plat($this->put('PLAT_NO_MOBIL'))!=null&&$this->m_mobil->get_by_plat($this->put('PLAT_NO_MOBIL'))->ID_MOBIL!=$id)
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		$update=$this->m_mobil->update($id,$mobil_data,$mobil_photo);
		if ($update) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$mobil=$this->m_mobil->get_by_id($id);
		if ($mobil)
			return TRUE;
		else
			return FALSE;
	}

	function Upload_Images($name) 
    {

    		if ($this->post('PHOTO')) {
	    		$strImage = str_replace('data:image/png;base64,', '', $this->post('PHOTO'));
    		}else{
    			$strImage = str_replace('data:image/png;base64,', '', $this->put('PHOTO'));

    		}
    		if (!empty($strImage)) {
    			$img = imagecreatefromstring(base64_decode($strImage));
							
				if($img != false)
				{
				   if (imagejpeg($img, './upload/mobil/'.$name)) {
				   	return true;
				   }else{
				   	return false;
				   }
				}
			}
	}

	function remove_image($name){
		$path='./upload/mobil/'.$name;
		unlink($path);
	}
}
?>