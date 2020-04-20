<?php
class planet extends deposit{
	public $id;
	public $name;
	public $type;
	public $size;
	private $db;
	
	public function __construct($id=null,$name=null,$size=null,$type=null){
		$this->db = new mysqli("localhost", "root", "", "combine");
		if(isset($name))
		{
			$this->planet_create($name,$size,$type);
		}
		if(isset($id))
		{
			$this->id = $id;
		}
		
	}
	private function planet_create($name,$size,$type){
		$req = 'INSERT INTO planet VALUES ("","'.$name.'",'.$type.','.$size.')';
		if(!$this->db->query($req) && DEBUG==1)
			printf("Message d'erreur : %s\n", $this->db->error);
	}
	public function planet_delete(){
		$req = 'DELETE FROM planet WHERE id = '.$this->id.'';
		if(!$this->db->query($req) && DEBUG==1)
			printf("Message d'erreur : %s\n", $this->db->error);
	}
	public function planet_update(){
		$req = 'UPDATE  planet SET name = "'.$this->name.'", type = '.$this->type.', id='.$this->id.' WHERE id = '.$this->id.'';
		if(!$this->db->query($req) && DEBUG==1)
			printf("Message d'erreur : %s\n", $this->db->error);
	}
	public function planet_get($all=null){
		if($all == false)
		{
			$req = 'SELECT planet.name as name, planet.type as terrain_type_id, planet.size, terrains_types.type_name as terrain_type_name  
			FROM planet,terrains_types 
			WHERE planet.id = '.$this->id.' 
			AND planet.type = terrains_types.id';
		}
		else
		{
			$req = 'SELECT planet.id as planet_id, planet.name as name, planet.type as terrain_type_id, planet.size, terrains_types.type_name as terrain_type_name  
			FROM planet,terrains_types 
			WHERE planet.type = terrains_types.id';
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
	public function planet_get_select(){
		$req = "SELECT id,name FROM planet";
		$ret = '';
		if ($result = $this->db->query($req)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$ret.= '<option value="'.$obj->id.'">'.$obj->name.'</option>';
			}
		}
		$result->close();
		return $ret;
	}
	public function planet_load(){
		$req = 'SELECT id,type,coord_x,coord_y,deposit_type,deposit_size FROM planet WHERE id = '.$this->id.'';
		
	}

}
?>