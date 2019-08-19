<?php  


/**
* 
*/
class m_fasilitas extends CI_Model
{
	private $table_name="tb_fasilitas";
	private $primary="ID_FASILITAS";
	private $fasilitas_name="FASILITAS";

	function get_all(){
		return $this->db->get($this->table_name)->result();
	}

	function get_by_id($id){
		$this->db->where($this->primary,$id);
		$data=$this->db->get($this->table_name)->row();
		return $data;
	}	

	function get_by_name($fasilitas){
		$this->db->where($this->fasilitas_name,$fasilitas);
		$data=$this->db->get($this->table_name)->row();
		return $data;
	}

	function insert($data){
		$res=$this->db->insert($this->table_name,$data);
		return $res;
	}

	function update($id,$data){
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);
		return $update;
	}

	function delete($id){
		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_name);
		return $delete;
	}

}

?>