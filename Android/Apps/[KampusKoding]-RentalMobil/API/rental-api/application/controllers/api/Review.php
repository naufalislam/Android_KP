<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';


class Review extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per user/key
		
		#Configure load model api table review
		$this->load->model('m_review');

	

	}


	function index_get($id=null){	

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get data' , 'data' => null );

		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No review were found' , 'data' => null );
        
		#
		if (!empty($this->get('ID_REVIEW_DESTINATION')))
			$id=$this->get('ID_REVIEW_DESTINATION');
            

		if ($id==null) {
			#Call methode get_all from m_review model
			$review=$this->m_review->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from m_review model
			$review=$this->m_review->get_by_id($id);
		}


        # Check if the review data store contains review
		if ($review) {
			
			#Set response API if Success
			$response['SUCCESS']['data'] = $review;
	
			#if found review
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found review
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){

		#Initialize attribut table tb_review
		$review_data = array(
						"ID_USER"=>$this->post('ID_USER'),
						"ID_DESTINATION"=>$this->post('ID_DESTINATION'),
						"REVIEW"=>$this->post('REVIEW'),
						"DATE_REVIEW"=>date('Y-m-d H:i:s'),
					);


		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $review_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail insert data' , 'data' => null );
		
		#Check if insert review_data Success
		if ($this->m_review->insert($review_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{

			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){
	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete review' );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail delete review' );
		
		#Set response API if review not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No review were found' );


		#Check available review
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('ID_REVIEW_DESTINATION')))
			$id=$this->get('ID_REVIEW_DESTINATION');
		
		if ($this->m_review->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('ID_REVIEW_DESTINATION');

		#Initialize attribut table tb_review
		$review_data = array(
						"ID_USER"=>$this->put('ID_USER'),
						"ID_DESTINATION"=>$this->put('ID_DESTINATION'),
						"REVIEW"=>$this->put('REVIEW'),
						"DATE_REVIEW"=>date('Y-m-d H:i:s'),
					);


		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success update review' , 'data' => $review_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail update review' , 'data' => null );
		
		#Set response API if review not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No review were found' , 'data' => null);

		#Check available review
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		
		if ($this->m_review->update($id,$review_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$review=$this->m_review->get_by_id($id);
		if ($review)
			return TRUE;
		else
			return FALSE;
	}

	function destination_get($id){
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get review' , 'data' => null );
		
		#Set response API if review not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No review were found' , 'data' => null );

		#
		if (!empty($this->get('ID_DESTINATION')))
			$id=$this->get('ID_DESTINATION');

		$review=$this->m_review->get_by_id_destination($id);

		# Check if the review data store contains review
		if ($review) {
			$response['SUCCESS']['data']=$review;
			#if found review
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found review
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}
	}

}

?>