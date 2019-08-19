<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';


class Rating extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per user/key
		
		#Configure load model api table rating
		$this->load->model('m_rating');

	

	}


	function index_get($id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get rating' , 'data' => null );

		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No rating were found' , 'data' => null);
        
		#
		if (!empty($this->get('ID_RATING')))
			$id=$this->get('ID_RATING');
            

		if ($id==null) {
			#Call methode get_all from m_rating model
			$destination=$this->m_rating->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from m_rating model
			$destination=$this->m_rating->get_by_id($id);
		}


        # Check if the rating data store contains rating
		if ($destination) {
		
			#if found rating
			$this->response($destination , REST_Controller::HTTP_OK);

		}else{

	        #if Not found rating
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){

		#Initialize attribut table tb_rating
		$rating = array("ID_DESTINATION","ID_USER","RATING");

		#Initialize array rating_data for insert to table
		$rating_data=array();

		foreach ($rating as $row) {
				
			if (empty($this->post($row)))
				$value=null;
			else
				$value=$this->post($row);

			$rating_data[$row]=$value;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $rating_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail insert data' , 'data' => null );
		
		#Check if insert rating_data Success
		if ($this->m_rating->insert($rating_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{

			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){
	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete rating' );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail delete rating' );
		
		#Set response API if rating not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No rating were found' );

		if (!empty($this->get('ID_RATING')))
			$id=$this->get('ID_RATING');

		#Check available rating
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if ($this->m_rating->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('ID_RATING');

		#Initialize attribut table tb_rating
		$rating = array("ID_DESTINATION","ID_USER","RATING");
		$rating_data=array();

		foreach ($rating as $row) {
				
			if (empty($this->put($row)))
				$value=null;
			else
				$value=$this->put($row);

			$rating_data[$row]=$value;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success update rating' , 'data' => $rating_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail update rating' , 'data' => $rating_data );
		
		#Set response API if rating not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No rating were found' , 'data' => null );

		#Check available rating
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		
		if ($this->m_rating->update($id,$rating_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function destination_get($id=null){
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete rating', 'rating'=>null);

		#Set response API if rating not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No rating were found', 'rating'=>null );

		if (!empty($this->get('ID_DESTINATION')))
			$id=$this->get('ID_DESTINATION');
		
		$rating=$this->m_rating->get_rating_count_by_destination($id);

		if ($rating) {
			$response['SUCCESS']['rating']=$rating;
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_CREATED);
			
		}
	}


	function validate($id){
		$destination=$this->m_rating->get_by_id($id);
		if ($destination)
			return TRUE;
		else
			return FALSE;
	}


}

?>