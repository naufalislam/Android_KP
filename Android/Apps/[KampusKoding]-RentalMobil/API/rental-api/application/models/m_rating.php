<?php  


/**
* 
*/
class M_Rating extends CI_Model
{
	
	private $table_name 		= "tb_rating";
	private $table_destinations	= "tb_destinations";
	private $table_user			= "tb_users";

	private $primary = "ID_RATING";

	function get_all(){

		#Get all data destinations
		$this->db->select($this->table_user.'.NAME,'.$this->table_destinations.'.NAME_DESTINATION,'.$this->table_name.'.*');
		$this->db->join($this->table_user,$this->table_user.'.ID_USER='.$this->table_name.'.ID_USER','left');	
		$this->db->join($this->table_destinations,$this->table_destinations.'.ID_DESTINATION='.$this->table_name.'.ID_DESTINATION');
		$data=$this->db->get($this->table_name);
		return $data->result();

	}

	function get_by_id($id){

		#Get data destination by id
		$this->db->select($this->table_user.'.NAME,'.$this->table_destinations.'.NAME_DESTINATION,'.$this->table_name.'.*');
		$this->db->join($this->table_user,$this->table_user.'.ID_USER='.$this->table_name.'.ID_USER','left');	
		$this->db->join($this->table_destinations,$this->table_destinations.'.ID_DESTINATION='.$this->table_name.'.ID_DESTINATION');
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

	function get_rating_count_by_destination($id){
		#Get data destination by id
		$this->db->select_avg('RATING');
		$this->db->where('ID_DESTINATION',$id);
		$data=$this->db->get($this->table_name);

		return $data->row()->RATING;		
	}

}

?>