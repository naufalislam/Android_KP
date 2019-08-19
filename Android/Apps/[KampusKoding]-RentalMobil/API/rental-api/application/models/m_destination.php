<?php  


/**
* 
*/
class M_Destination extends CI_Model
{
	
	private $table_name 	= "tb_destinations";
	private $table_country	= "tb_countries";

	private $primary = "ID_DESTINATION";

	function get_all(){

		#Get all data destinations
		$this->db->join($this->table_country,$this->table_country.'.ID_COUNTRY='.$this->table_name.'.ID_COUNTRY','LEFT');
		$data=$this->db->get($this->table_name);
		return $data->result();

	}

	function get_by_id($id){

		#Get data destination by id
		$this->db->join($this->table_country,$this->table_country.'.ID_COUNTRY='.$this->table_name.'.ID_COUNTRY','LEFT');
		$this->db->where($this->primary,$id);
		$data=$this->db->get($this->table_name);

		return $data->row();
	}

	function insert($data){

		#Insert data to table tb_destinations
		$insert=$this->db->insert($this->table_name,$data);

		return $insert;
	}

	function delete($id){
		#Delete data destination by id
		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_name);

		return $delete;
	}

	function update($id,$data){
		#Update data destination by id
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);

		return $update;
	}

}

?>