<?php  

/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per user/key
		
		#Configure load model api table users
		$this->load->model('m_auth');
	}

	function index_post(){
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success get data' );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail get data' , 'data' => null );
		
		
		$data_user=$this->m_auth->get_user_by_emai($this->post('USERNAME'),md5($this->post('PASSWORD')));
		// $data_user=$this->m_auth->get_user_by_emai('admin@gmail.com',md5('admin'));
		// var_dump($this->post('EMAIL'),$this->post('PASSWORD')); die();
		if ($data_user) {
			$response['SUCCESS']['data']=$data_user;			
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);
		}else{
			$this->response($response['FAIL'] , REST_Controller::HTTP_NOT_FOUND);
		}

	}


}

?>