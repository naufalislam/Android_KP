<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class Fasilitas extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per fasilitas/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per fasilitas/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per fasilitas/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per fasilitas/key
		
		#Configure load model api table fasilitass
		$this->load->model('m_fasilitas');
	}


	function index_get($id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success get fasilitas' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no fasilitas were found' , 'data' => null );
        
		#
		if (!empty($this->get('ID_FASILITAS')))
			$id=$this->get('ID_FASILITAS');
            

		if ($id==null) {
			#Call methode get_all from m_fasilitas model
			$fasilitass=$this->m_fasilitas->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from m_fasilitas model
			$fasilitass=$this->m_fasilitas->get_by_id($id);
		}


        # Check if the fasilitass data store contains fasilitass
		if ($fasilitass) {
			$response['SUCCESS']['data']=$fasilitass;

			#if found fasilitass
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found fasilitass
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){
		
		#
		$fasilitas_data = array(
							'FASILITAS' =>$this->post('FASILITAS') , 
							'KET_FASILITAS' => $this->post('KET_FASILITAS') ,
							'BIAYA' => $this->post('BIAYA') , 
							);
		

		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		#Upload avatar
		if ($this->Upload_Images($image_name))
			$fasilitas_data['PHOTO']=$image_name;
	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success insert data' , 'data' => $fasilitas_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail insert data' , 'data' => null );
		
		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => null );

		if ($this->m_fasilitas->get_by_name($this->post('FASILITAS'))){

			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		}

		#Check if insert fasilitas_data Success
		if ($this->m_fasilitas->insert($fasilitas_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{

			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete fasilitas'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail delete fasilitas'  );
		
		#Set response API if fasilitas not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No fasilitass were found' );


		#Check available fasilitas
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('ID_FASILITAS')))
			$id=$this->get('ID_FASILITAS');
		
		if ($this->m_fasilitas->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('ID_FASILITAS');

		$fasilitas_data = array(
							'FASILITAS' =>$this->put('FASILITAS') , 
							'KET_FASILITAS' => $this->put('KET_FASILITAS') ,
							'BIAYA' => $this->put('BIAYA') , 
							);
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update fasilitas' , 'data' => $fasilitas_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail update fasilitas' , 'data' => $fasilitas_data );
		
		#Set response API if fasilitas not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no fasilitass were found' , 'data' => $fasilitas_data );

		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist insert data' , 'data' => $fasilitas_data );

		#Check available fasilitas
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);

		
		if ($this->m_fasilitas->get_by_name($this->put('FASILITAS'))->ID_FASILITAS!=null&&$this->m_fasilitas->get_by_name($this->put('FASILITAS'))->ID_FASILITAS!=$id)
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		if ($this->m_fasilitas->update($id,$fasilitas_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$fasilitass=$this->m_fasilitas->get_by_id($id);
		if ($fasilitass)
			return TRUE;
		else
			return FALSE;
	}

	function Upload_Images($name) 
    {

    		$strImage = str_replace('data:image/png;base64,', '', $this->post('PHOTO'));
    		if (!empty($strImage)) {
    			$img = imagecreatefromstring(base64_decode($strImage));
							
				if($img != false)
				{
				   if (imagejpeg($img, './upload/avatars/'.$name)) {
				   	return true;
				   }else{
				   	return false;
				   }
				}
			}
	}

	function remove_image($name){
		$path='./upload/avatars/'.$name;
		unlink($path);
	}


}

?>