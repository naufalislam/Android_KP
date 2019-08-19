<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';


class Event extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per user/key
		
		#Configure load model api table destination
		$this->load->model('m_event');

	

	}


	function index_get($id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get user' , 'data' => null );

		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No destination were found' , 'data' => null);
        
		#
		if (!empty($this->get('ID_EVENT')))
			$id=$this->get('ID_EVENT');
            

		if ($id==null) {
			#Call methode get_all from m_event model
			$destination=$this->m_event->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from m_event model
			$destination=$this->m_event->get_by_id($id);
		}


        # Check if the destination data store contains destination
		if ($destination) {
		
			#if found destination
			$this->response($destination , REST_Controller::HTTP_OK);

		}else{

	        #if Not found destination
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){
		$this->Upload_Images(1);

		#Initialize attribut table tb_destination
		$destination = array("ID_DESTINATION","EVENT_NAME","START_EVENT","END_EVENT","TIME_START","END_TIME","DESCRIPTION_EVENT","STATUS_EVENT",);

		#Initialize array destination_data for insert to table
		$destination_data=array();

		foreach ($destination as $row) {
				
			if (empty($this->post($row)))
				$value=null;
			else
				$value=$this->post($row);

			$destination_data[$row]=$value;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $destination_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail insert data' , 'data' => null );
		
		#Check if insert destination_data Success
		if ($this->m_event->insert($destination_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{

			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){
	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete destination' );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail delete destination' );
		
		#Set response API if destination not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No destination were found' );

		if (!empty($this->get('ID_EVENT')))
			$id=$this->get('ID_EVENT');

		#Check available destination
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if ($this->m_event->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('ID_EVENT');

		#Initialize attribut table tb_destination
		$destination = array("ID_DESTINATION","EVENT_NAME","START_EVENT","END_EVENT","TIME_START","END_TIME","DESCRIPTION_EVENT","STATUS_EVENT",);

		#Initialize array destination_data for insert to table
		$destination_data=array();

		foreach ($destination as $row) {
				
			if (empty($this->put($row)))
				$value=null;
			else
				$value=$this->put($row);

			$destination_data[$row]=$value;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success update destination' , 'data' => $destination_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail update destination' , 'data' => $destination_data );
		
		#Set response API if destination not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No destination were found' , 'data' => null );

		#Check available destination
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		
		if ($this->m_event->update($id,$destination_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$destination=$this->m_event->get_by_id($id);
		if ($destination)
			return TRUE;
		else
			return FALSE;
	}


	function Upload_Images($id) 
    {

    		$strImage = str_replace('data:image/png;base64,', '', $this->post('file'));

	    	$img = imagecreatefromstring(base64_decode($strImage));
			
			$name=round(microtime(true)).date("Ymdhis").".jpg";
			
			if($img != false)
			{
			   if (imagejpeg($img, './upload/destinations/'.$name)) {
			   		
			   }else{

			   }
			}
	}

}

?>