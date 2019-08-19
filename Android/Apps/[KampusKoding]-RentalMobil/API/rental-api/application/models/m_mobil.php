<?php  

/**
* 
*/
class m_mobil extends CI_Model
{
	private $table_name="tb_mobil";
	private $table_gallery="tb_gallery_mobil";
	private $primary="ID_MOBIL";
	private $plat="PLAT_NO_MOBIL"; 

	function get_all(){
		$this->db->select($this->table_name.'.*,GROUP_CONCAT(IMAGE) AS IMAGE');
		$this->db->join($this->table_gallery." tb_gal",$this->table_name.'.ID_MOBIL'.'=tb_gal.ID_MOBIL','left');
		$this->db->group_by($this->plat);
		return $this->db->get($this->table_name)->result();
	}

	function get_by_id($id){
		$this->db->select($this->table_name.'.*,GROUP_CONCAT(IMAGE) AS IMAGE');
		$this->db->join($this->table_gallery." tb_gal",$this->table_name.'.ID_MOBIL'.'=tb_gal.ID_MOBIL','left');
		$this->db->group_by($this->plat);
		$this->db->where($this->table_name.'.'.$this->primary,$id);
		return $this->db->get($this->table_name)->row();
	}

	function insert($data,$mobil_photo=null){
		$insert=$this->db->insert($this->table_name,$data);
		$id=$this->db->insert_id();

		if ($mobil_photo!=null&&$id) {
			$mobil_photo["ID_MOBIL"]=$id;
			$insert=$this->db->insert($this->table_gallery,$mobil_photo);
		}
	
		return $id;
	}

	function update($id,$data,$mobil_photo=null){
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);

		if ($mobil_photo!=null&&$update) {
			$mobil_photo["ID_MOBIL"]=$id;
			$this->db->where($this->primary,$id);
			$update=$this->db->update($this->table_gallery,$mobil_photo);
		}
	
		return $update;
	}

	function delete($id){
		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_name);
		return $delete;
	}

	function get_by_plat($plat_no){
		$this->db->where($this->plat,$plat_no);
		$data=$this->db->get($this->table_name)->row();
		return $data;
	}
}

?>