<?php  


/**
* 
*/
class M_Review extends CI_Model
{
	
	private $table_name 		= "tb_review_destination";
	private $table_users		= "tb_users";
	private $table_destination	= "tb_destinations";

	private $primary = "ID_REVIEW_DESTINATION";

	function get_all(){

		#Get all data review
		$this->db->select($this->table_name.'.*,'.$this->table_users.'.NAME,'.$this->table_users.'.PHOTO');
		$this->db->join($this->table_users,$this->table_users.'.ID_USER='.$this->table_name.'.ID_USER','LEFT');
		$data=$this->db->get($this->table_name);
		return $data->result();

	}

	function get_by_id($id){

		#Get data destination by id
		$this->db->select($this->table_name.'.*,'.$this->table_users.'.NAME,'.$this->table_users.'.PHOTO');
		$this->db->join($this->table_users,$this->table_users.'.ID_USER='.$this->table_name.'.ID_USER','LEFT');
		$this->db->where($this->primary,$id);
		$data=$this->db->get($this->table_name);

		return $data->row();
	}

	function get_by_id_destination($id){
		
		#Get data destination by id
		$this->db->select($this->table_name.'.*,'.$this->table_users.'.NAME,'.$this->table_users.'.PHOTO');
		$this->db->join($this->table_users,$this->table_users.'.ID_USER='.$this->table_name.'.ID_USER','LEFT');
		$this->db->where('ID_DESTINATION',$id);
		$data=$this->db->get($this->table_name);

		return $data->result();	
	}

	function insert($data){

		#Insert data to table tb_review
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