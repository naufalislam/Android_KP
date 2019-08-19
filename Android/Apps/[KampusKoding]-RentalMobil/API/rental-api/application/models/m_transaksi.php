<?php  


/**
* 
*/
class m_transaksi extends CI_Model
{

	private $table_name 	= "tb_transaksi";
	private $table_detail 	= "tb_detail_transaksi";
	private $table_user		= "tb_users";
	private $table_mobil	= "tb_mobil";
	private $primary 		= "ID_DETAIL_TRANSAKSI";
	private $kode 			= "KODE_TRANSAKSI";

	function cancel($id){
		//get detail transkasi by ID_DETAIL_TRANSAKSI
		$data=$this->get_transaksi_by_id($id);

		//get detail transkasi by KODE_TRANSAKSI
		$data_transaksi=$this->get_transaksi_by_kode($data->KODE_TRANSAKSI);

		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_detail);

		if ($delete) {
			$this->db->where($this->kode,$data->KODE_TRANSAKSI);
			$data_transaksi->TOTAL_PEMBAYARAN=$data_transaksi->TOTAL_PEMBAYARAN - $data->TOTAL;
			$update=$this->db->update($this->table_name,(array)$data_transaksi);

			if($data_transaksi->TOTAL_PEMBAYARAN==0){
				$this->db->where($this->kode,$data->KODE_TRANSAKSI);
				$this->db->delete($this->table_name);
			}
		}

		return $delete;
	}

	function get_transaksi_by_id($id){
		$this->db->where($this->primary,$id);
		$data=$this->db->get("tb_detail_transaksi")->row();
		return $data;
	}

	function get_transaksi_by_kode($id){
		$this->db->where($this->kode,$id);
		$data=$this->db->get("tb_transaksi")->row();
		return $data;
	}
}

?>