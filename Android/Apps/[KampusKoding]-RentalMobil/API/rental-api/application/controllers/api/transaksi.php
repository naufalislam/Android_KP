<?php 

require APPPATH . 'libraries/REST_Controller.php';
class transaksi extends REST_Controller
{
	
	function __construct()
	{

		parent::__construct();
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per pesanan/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per pesanan/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per pesanan/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per pesanan/key
		$this->methods['history']['limit']=10; #10 requests per hour per pesanan/key
		$this->load->helper('url');
		#Configure load model api table pesanan
		$this->load->model('m_transaksi');
	}

	function index_get(){
		echo "string";
	}

	function index_delete($id=null){
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success delete pesanan'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail delete pesanan'  );
		
		#Set response API if pesanan not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no pesanan were found' );

		
		if ($this->m_transaksi->cancel($id)) {			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{
			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}
	}
}
?>