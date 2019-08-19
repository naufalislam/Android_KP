<?php  

/**
* 
*/
class m_dashboard extends CI_Model
{

	function get_data(){
		return $this->db->query("SELECT (SELECT SUM(TOTAL_PEMBAYARAN) FROM `tb_transaksi` WHERE STATUS_PEMBAYARAN=1) AS TOTAL,(SELECT COUNT(ID_MOBIL) FROM `tb_mobil`) AS MOBIL,(SELECT COUNT(KODE_TRANSAKSI) FROM `tb_transaksi`) AS TRANSAKSI,(SELECT COUNT(ID_USER) FROM `tb_users` WHERE GROUP_USER=1) AS ADMIN,(SELECT COUNT(ID_USER) FROM `tb_users` WHERE GROUP_USER=2) AS USER ",false)->row();
		// return $this->db->get()->row();
	}	

}

?>