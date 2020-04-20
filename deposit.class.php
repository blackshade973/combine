<?php
class deposit{
	public $type;
	public $size;
	
	public function __construct($id=null,$planet=null,$size=null,$type=null, $coord_x=null,$coord_y=null){
		$this->db = new mysqli("localhost", "root", "", "combine");
		if(isset($planet))
		{
			$this->deposit_create($planet,$size,$type,$coord_x,$coord_y);
		}
		if(isset($id))
		{
			$this->id = $id;
		}
	}
	private function deposit_create($planet,$size,$type,$coord_x,$coord_y){
		$req = 'INSERT INTO planet_deposit VALUES ("",'.$planet.','.$type.','.$size.','.$coord_x.','.$coord_y.')';
		if(!$this->db->query($req))
			printf("Message d'erreur : %s\n", $this->db->error);
	
	}
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
	
	public function deposit_get($all){
		if($all == false)
		{
			$req = 'SELECT planet.name as name, planet.type as terrain_type_id, planet.size, terrains_types.type_name as terrain_type_name  
			FROM planet,terrains_types 
			WHERE planet.id = '.$this->id.' 
			AND planet.type = terrains_types.id';
		}

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
			printf("Message d'erreur : %s\n", $this->db->error);
	}
}
?>