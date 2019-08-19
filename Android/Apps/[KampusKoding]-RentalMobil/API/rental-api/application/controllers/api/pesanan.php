<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';
class pesanan extends REST_Controller
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
		$this->load->model('m_pesanan');
	}

	function index_get($id=null, $userid=null, $trid=null){	
		// $as='[{"HARGA_MOBIL":"350000","ID_MOBIL":"2","MERK_MOBIL":"TOYOTA","NAMA_MOBIL":"Brio Satya E CVT","PLAT_NO_MOBIL":"D 0011 FZA","TGL_AKHIR_PENYEWAAN":"2017-11-29","TGL_SEWA":"2017-10-29","TOTAL":"11200000"},{"HARGA_MOBIL":"350000","ID_MOBIL":"15","MERK_MOBIL":"Datsun","NAMA_MOBIL":"Datsun Go","PLAT_NO_MOBIL":"D 1000 FX","TGL_AKHIR_PENYEWAAN":"2017-12-29","TGL_SEWA":"2017-10-29","TOTAL":"21700000"}]';
		// foreach (json_decode($as,true) as $row) {
		// 	echo $row["HARGA_MOBIL"];
		// 	// var_dump($row);
		// }
		// // var_dump();

		// exit();
		// var_dump($id == 'history'); die();

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get pesanan' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No pesanan were found' , 'data' => null );
        
		#
		if($id == 'history'){
			if ($trid==null) {
				#Call method get_all_by_userid from m_pesanan model
				$pesanan=$this->m_pesanan->get_pesanan_by_userid($userid);
			}else{
				#Call method get_by_iduser from m_pesanan model
				$pesanan=$this->m_pesanan->get_detail_by_id($trid);
				// var_dump($pesanan);
				// exit();
			}
		}else{
			
			if (!empty($this->get('KODE_TRANSAKSI')))
				$id=$this->get('KODE_TRANSAKSI');
	            

			if ($id==null) {
				#Call methode get_all from m_pesanan model
				$pesanan=$this->m_pesanan->get_all();
			
			}else{
				$id=str_replace("_", "-", $id);
				#Check if id <= 0
				// if ($id<=0) {
				// 	$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
				// }

				#Call methode get_by_id from m_pesanan model
				$pesanan=$this->m_pesanan->get_detail_by_id($id);
				// var_dump($pesanan);
				// exit();
			}
		}
			
        # Check if the pesanan data store contains pesanan
		if ($pesanan) {
			// if (count($pesanan)==1)
			// 	$pesanan->IMAGE=explode(',', $pesanan->IMAGE);
			// else
			// 	for ($i=0; $i <count($pesanan) ; $i++)
			// 		$pesanan[$i]->IMAGE=explode(',', $pesanan[$i]->IMAGE);

			$response['SUCCESS']['data']=$pesanan;

			#if found pesanan
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found pesanan
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	// function history($userid, $id=null){
	function history(){
	 	var_dump("hello");die();	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get pesanan' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No pesanan were found' , 'data' => 10 );
        
		#
		if (!empty($this->get('KODE_TRANSAKSI')))
			$id=$this->get('KODE_TRANSAKSI');
            
       

		if ($id==null) {
			#Call methode get_all_by_userid from m_pesanan model
			$pesanan=$this->m_pesanan->get_pesanan_by_userid($userid);
		
		}

		if ($id!=null) {
			#Check if id <= 0
			// if ($id<=0) {
			// 	$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			// }

			#Call method get_by_iduser from m_pesanan model
			$pesanan=$this->m_pesanan->get_history_user($id);
			// var_dump($pesanan);
			// exit();
		}


        # Check if the pesanan data store contains pesanan
		if ($pesanan) {
			// if (count($pesanan)==1)
			// 	$pesanan->IMAGE=explode(',', $pesanan->IMAGE);
			// else
			// 	for ($i=0; $i <count($pesanan) ; $i++)
			// 		$pesanan[$i]->IMAGE=explode(',', $pesanan[$i]->IMAGE);

			$response['SUCCESS']['data']=$pesanan;

			#if found pesanan
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found pesanan
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){
		#
		$kode=$this->m_pesanan->get_kode_transaksi();
		$KODE_TRANSAKSI="TRN-".date("YmdHms")."-".$kode->KODE_TRANSAKSI;


		$pesanan_data = array('KODE_TRANSAKSI' => $KODE_TRANSAKSI , 
							'ID_USER' => $this->post('ID_USER') ,
							'TGL_ORDER' => date("Y-m-d H:m:s") , 
							'TOTAL_PEMBAYARAN' => $this->post('TOTAL_PEMBAYARAN') ,
							'TGL_PEMBAYARAN' => null ,
							'BUKTI_PEMBAYARAN' => null,
							'STATUS_PEMBAYARAN' => 0 ,
							'STATUS_TRANSAKSI' => 0 ,
						);


		// $as='[{"HARGA_MOBIL":"350000","ID_MOBIL":"2","MERK_MOBIL":"TOYOTA","NAMA_MOBIL":"Brio Satya E CVT","PLAT_NO_MOBIL":"D 0011 FZA","TGL_AKHIR_PENYEWAAN":"2017-11-29","TGL_SEWA":"2017-10-29","TOTAL":"11200000"},{"HARGA_MOBIL":"350000","ID_MOBIL":"15","MERK_MOBIL":"Datsun","NAMA_MOBIL":"Datsun Go","PLAT_NO_MOBIL":"D 1000 FX","TGL_AKHIR_PENYEWAAN":"2017-12-29","TGL_SEWA":"2017-10-29","TOTAL":"21700000"}]';

		$detail_pesanan=array();
		foreach (json_decode($this->post("LIST_CART"),true) as $row) {

					$temp= array('KODE_TRANSAKSI' => $KODE_TRANSAKSI , 
							'ID_MOBIL' => $row["ID_MOBIL"],
							'TGL_SEWA' => $row["TGL_SEWA"] , 
							'TGL_AKHIR_PENYEWAAN' => $row["TGL_AKHIR_PENYEWAAN"],
							'TGL_PENGEMBALIAN' =>  null,
							'HARGA_MOBIL' => $row["HARGA_MOBIL"],
							'TOTAL' => $row["TOTAL"] ,
							'STATUS_MOBIL' => 1 ,
						);
					$detail_pesanan[]=$temp;
		}


		
		// KODE_TRANSAKSI
		// $temp=$pesanan_data;
		// $pesanan_data["BUKTI_PEMBAYARAN"]=$temp;

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success insert data' , 'data' => $pesanan_data);

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail insert data' , 'data' => null );
		
		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => null );

		#Check if insert pesanan_data Success
		if ($this->m_pesanan->insert($pesanan_data,$detail_pesanan)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{
			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

		
	}


	function index_delete($id=null){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success delete pesanan'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail delete pesanan'  );
		
		#Set response API if pesanan not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no pesanan were found' );


		#Check available pesanan
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('KODE_TRANSAKSI')))
			$id=$this->get('KODE_TRANSAKSI');
		
		if ($this->m_pesanan->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('KODE_TRANSAKSI');

		$pesanan_data = array('NAMA_pesanan' =>$this->put('NAMA_pesanan') , 
							'MERK_pesanan' => $this->put('MERK_pesanan') ,
							'DESKRIPSI_pesanan' => $this->put('DESKRIPSI_pesanan') , 
							'TAHUN_pesanan' => $this->put('TAHUN_pesanan') ,
							'KAPASITAS_pesanan' => $this->put('KAPASITAS_pesanan') ,
							'HARGA_pesanan' => $this->put('HARGA_pesanan') ,
							'WARNA_pesanan' => $this->put('WARNA_pesanan') ,
							'BENSIN_pesanan' => $this->put('BENSIN_pesanan') ,
							'PLAT_NO_pesanan' =>$this->put('PLAT_NO_pesanan'),
							'STATUS_SEWA'=>$this->put('STATUS_SEWA'),
							'STATUS_pesanan'=>$this->put('STATUS_pesanan'),
							'CREATED_pesanan'=>date('Y-m-d h:i:s'),
						);

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update pesanan' , 'data' => $pesanan_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail update pesanan' , 'data' => $pesanan_data );
		
		#Set response API if pesanan not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no pesanan were found' , 'data' => $pesanan_data );

		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => $pesanan_data );

		#Check available pesanan
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);

		if ($this->m_pesanan->get_by_plat($this->put('PLAT_NO_pesanan'))!=null&&$this->m_pesanan->get_by_plat($this->put('PLAT_NO_pesanan'))->KODE_TRANSAKSI!=$id)
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		if ($this->m_pesanan->update($id,$pesanan_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

}

?>