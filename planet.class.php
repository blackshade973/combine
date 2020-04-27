<?php
class planet extends deposit{
	
	/** @var int $id */
	public $id;
	/** @var string $name*/
	public $name;
	/** @var int $type*/
	public $type;
	/** @var int $size */
	public $size;
	/** @var object $db */
	public $db;
	/** @var string $message*/
	public $message;
	
	public function __construct(int $id=null){
		$this->db = new my_db();
		if(isset($id))
		{
			$this->id = $id;
		}
		
	}

	public function planet_create() : bool{
		if($this->db->insert_into('planet')->values(array('',$this->name,$this->type,$this->size)))
		{
			$this->message = "planet created";
			return true;
		}
		else return false;
	}
	
	public function planet_delete() : bool{
		if($this->db->delete()->from('planet')->where('id = ?')->params(array($this->id))->go())
		{
			/* we better delete the deposits on the planet as well */
			if($this->db->delete()->from('planet_deposit')->where('planet_id = ?')->params(array($this->id))->go())
			{
				$this->message =  "Planet and all its deposits have been deleted";
				return true;
			}
				
		}
		return false;
	}
	
	public function planet_update(int $id) : bool{
		if($this->db->update('planet')->set('name = ?, type = ?, size= ? ')->where('id = ?')->params(array($this->name,$this->type,$this->size,$id))->go())
		{
			/* deleting the deposits that are out of the new planet size. latter I should make a check before to see IF the size has changed*/
			if($this->db->delete()->from('planet_deposit')->where('planet_id = ? AND (coord_x >= ? OR coord_y >= ?)')->params(array($id,$this->size,$this->size))->go())
			{
				$this->message =  "Planet updated. If the size has been changed, all deposits out of the new size, if any, have been deleted";
				return true;
			}
		}
		return false;
	}
	
	/*return a list of all planet with their data as an object */
	/**
	* @return array<object>
	*/
	public function planet_get() : array{
		$planet_list = array();
		if($result = $this->db->select('planet.id as planet_id, planet.name as name, planet.type as terrain_type_id, planet.size, terrains_types.type_name as terrain_type_name')->from('planet,terrains_types ')->where('planet.type = terrains_types.id')->get())
		{
			while ($obj = $result->fetch_object()) 
			{
				$planet_list[] = $obj;
			}
			$result->close();
		}
			return $planet_list;
	}
}
?>