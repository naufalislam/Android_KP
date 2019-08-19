<?php  

/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';
class Dashboard extends REST_Controller
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
		$this->load->model('m_dashboard');
	}

	function index_get(){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get dashboard' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No dashboard were found' , 'data' => null );
        
            
		#Call methode get_all from m_mobil model
		$dashboard=$this->m_dashboard->get_data();
		

        # Check if the mobil data store contains mobil
		if ($dashboard) {
			$response['SUCCESS']['data']=$dashboard;

			#if found mobil
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found mobil
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}
}

?>