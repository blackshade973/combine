<?php
class deposit {
	public $type;
	public $size;
	public $planet_id;
	public $coord_x;
	public $coord_y;
	
	public function __construct(){
		$this->db = new mysqli("localhost", "root", "", "combine");
	}
	
	/* check if the deposit location match the planet size
	check if there is already a deposit at coordinates */
	
	private function check_terrain(){
		$req = 'SELECT * FROM planet WHERE id = '.$this->planet_id.' AND size >= '.$this->coord_x.' and size >= '.$this->coord_y.'';
		if ($result = $this->db->query($req))
			{
				$nb = $result->num_rows;
			}
		if($nb == 0) return "deposit coordinates are out of range";
		$req = 'SELECT * FROM planet_deposit WHERE planet_id = '.$this->planet_id.' AND coord_x= '.$this->coord_x.' and coord_y >= '.$this->coord_y.'';
		if ($result = $this->db->query($req))
			{
				$nb = $result->num_rows;
			}
		if($nb > 0) return "there is already a deposit there";
		
		return 1;
	}
	
	public function deposit_create(){
		$check = $this->check_terrain();
		if($check != 1) return $check;
		$req = 'INSERT INTO planet_deposit VALUES ("",'.$this->planet_id.','.$this->type.','.$this->size.','.$this->coord_x.','.$this->coord_y.')';
		if(!$this->db->query($req))
			return "Message d'erreur :".$this->db->error;
		else return "deposit created";
	
	}
	
	/*return a select list of all deposits type */
	public function get_types(){
		$req = "SELECT id,name FROM deposits_types";
		$ret = '';
		if ($result = $this->db->query($req)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$ret.= '<option value="'.$obj->id.'">'.$obj->name.'</option>';
			}
		}
		else return $this->db->error;
		$result->close();
		return $ret;
	}
	
	/* update a deposit */
	public function deposit_update($id){
		$check = $this->check_terrain();
		if($check != 1) return $check;
		$req = 'UPDATE planet_deposit SET planet_id = '.$this->planet_id.',deposit_type_id = '.$this->type.',size = '.$this->size.',coord_x = '.$this->coord_x.',coord_y = '.$this->coord_y.' 
				WHERE id = '.$id.'';
		if(!$this->db->query($req))
		return "Message d'erreur :".$this->db->error;
	return "deposit updated";
	}
	
	public function deposit_get($all){
		/* return a list of all deposit and their data for a given planet */
		if($all == false)
		{
			$req = 'SELECT planet.name as planet, planet.id as planet_id, deposits_types.name as type, deposits_types.id as type_id, planet_deposit.size as size, planet_deposit.coord_x as coord_x, planet_deposit.coord_y as coord_y, planet_deposit.id as deposit_id
			FROM planet,planet_deposit, deposits_types 
			WHERE planet.id = '.$this->id.' 
			AND planet.id = planet_deposit.planet_id
			AND planet_deposit.deposit_type_id = deposits_types.id';
		}
		/* return all deposits for all planets */
		else
		{
			$req = 'SELECT planet.name as planet, planet.id as planet_id, deposits_types.name as type, deposits_types.id as type_id, planet_deposit.size as size, planet_deposit.coord_x as coord_x, planet_deposit.coord_y as coord_y, planet_deposit.id as deposit_id
			FROM planet,planet_deposit, deposits_types 
			WHERE planet.id = planet_deposit.planet_id
			AND planet_deposit.deposit_type_id = deposits_types.id';
		}
		if ($result = $this->db->query($req)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$planet_list[] = $obj;
			}
			$result->close();
		}
	return $planet_list;
	}
	
	public function deposit_delete(){
		$req = 'DELETE FROM planet_deposit WHERE id = '.$this->id.'';
		if(!$this->db->query($req) && DEBUG==1)
			return "Message d'erreur :".$this->db->error;
	}
}
?>