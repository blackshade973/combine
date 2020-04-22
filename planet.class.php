<?php
class planet extends deposit{
	public $id;
	public $name;
	public $type;
	public $size;
	public $db;
	
	public function __construct($id=null){
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
	public function planet_create(){
		$req = 'INSERT INTO planet VALUES ("","'.$this->name.'",'.$this->type.','.$this->size.')';
		if(!$this->db->query($req))
			printf("Message d'erreur : %s\n", $this->db->error);
		return "planet created";
	}
	
	public function planet_delete(){
		$req = 'DELETE FROM planet WHERE id = '.$this->id.'';
		if(!$this->db->query($req) )
			printf("Message d'erreur : %s\n", $this->db->error);
		/* we better delete the deposits on the planet as well */
		$req = 'DELETE FROM planet_deposit WHERE planet_id = '.$this->id.'';
		if(!$this->db->query($req) )
			printf("Message d'erreur : %s\n", $this->db->error);
		return "Planet and all its deposits have been deleted";
	}
	
	public function planet_update($id){
		$req = 'UPDATE  planet SET name = "'.$this->name.'", type = '.$this->type.', size='.$this->size.' WHERE id = '.$id.'';
		if(!$this->db->query($req) && DEBUG==1)
			printf("Message d'erreur : %s\n", $this->db->error);
		/* deleting the deposit that are out of the new planet size. latter I should make a check before to see IF the size has changed*/
		$req = 'DELETE FROM planet_deposit WHERE planet_id = '.$id.' AND (coord_x >= '.$this->size.' OR coord_y >= '.$this->size.')';
		if(!$this->db->query($req) )
			printf("Message d'erreur : %s\n", $this->db->error);
		return "Planet updated. If the size has been changed, all deposits out of the new size, if any, have been deleted";
	}
	
	/*return a list of all planet with their data as an object */
	public function planet_get(){
		$req = 'SELECT planet.id as planet_id, planet.name as name, planet.type as terrain_type_id, planet.size, terrains_types.type_name as terrain_type_name  
			FROM planet,terrains_types 
			WHERE planet.type = terrains_types.id';

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
	
	/* return the list of planets as a select list. this function is no longer used */
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
}
?>