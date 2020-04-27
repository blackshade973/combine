<?php
class deposit {
	
	/** @var int $id */
	public $id;
	/** @var int $type */
	public $type;
	/** @var int $size */
	public $size;
	/** @var int $planet_id */
	public $planet_id;
	/** @var int $coord_x */
	public $coord_x;
	/** @var int $coord_y */
	public $coord_y;
	/** @var object $db */
	public $db;
	/** @var string $message*/
	public $message;

	
	public function __construct(){
		$this->db = new my_db();
	}

	/* check if the deposit location match the planet size
	check if there is already a deposit at coordinates */
	private function check_terrain(int $id=null) : bool {
		if($result = $this->db->select('*')->from('planet')->where('id = ? AND size >= ? and size >= ?')->params(array($this->planet_id,$this->coord_x,$this->coord_y))->get())
		{
			$nb = $result->num_rows;
			if($nb == 0)
			{
				$this->message = "deposit coordinates are out of range";
				return false;
			}
			else if($result = $this->db->select('*')->from('planet_deposit')->where('planet_id = ? AND coord_x= ? and coord_y >= ? AND id != ? ')->params(array($this->planet_id,$this->coord_x,$this->coord_y, $id))->get())
			{
				$nb = $result->num_rows;
				if($nb > 0)
				{
					$this->message = "there is already a deposit there";
					return false;
				}
			}
			return true;
		}
		else return true;
	}
	
	public function deposit_create(): bool{
		if(!$this->check_terrain())
		{
			return false;
		}
		else if($this->db->insert_into('planet_deposit')->values(array('',$this->planet_id,$this->type,$this->size,$this->coord_x,$this->coord_y)))
		{
			$this->message = "deposit created";
			return true;
		}
		else return false;
	}
	
	/* update a deposit */
	public function deposit_update(int $id) : bool{
		if(!$this->check_terrain($id))
		{
			return false;
		}
		else if($this->db->update('planet_deposit')->set('planet_id = ?,deposit_type_id = ?,size = ?,coord_x = ?,coord_y = ?')->where('id = ?')->params(array($this->planet_id, $this->type, $this->size, $this->coord_x, $this->coord_y, $id ))->go())
		{
			$this->message =  "deposit updated";
			return true;
		}
		else return false;
	}
	/**
	 * @return array<object>
	 */
	public function deposit_get(bool $all) : array{
		/* return a list of all deposit and their data for a given planet */
		$planet_list = array();
		if($all == false)
		{
			$result = $this->db->select('planet.name as planet, planet.id as planet_id, deposits_types.name as type, deposits_types.id as type_id, planet_deposit.size as size, planet_deposit.coord_x as coord_x, planet_deposit.coord_y as coord_y, planet_deposit.id as deposit_id')->from('planet,planet_deposit, deposits_types ')->where('planet.id = ? AND planet.id = planet_deposit.planet_id	AND planet_deposit.deposit_type_id = deposits_types.id')->params((array($this->id)))->get();
		}
		/* return all deposits for all planets */
		else
		{
			$result = $this->db->select('planet.name as planet, planet.id as planet_id, deposits_types.name as type, deposits_types.id as type_id, planet_deposit.size as size, planet_deposit.coord_x as coord_x, planet_deposit.coord_y as coord_y, planet_deposit.id as deposit_id')->from('planet,planet_deposit, deposits_types')->where('planet.id = planet_deposit.planet_id AND planet_deposit.deposit_type_id = deposits_types.id')->get();
		}
		while ($obj = $result->fetch_object()) 
		{
			$planet_list[] = $obj;
		}
		$result->close();
		return $planet_list;
	}
	
	public function deposit_delete(int $id) : bool{
		if($this->db->delete()->from('planet_deposit')->where('id = ?')->params(array($id) )->go())
		{
			$this->message =  "deposit deleted";
			return true;
		}
		else return false;
	}
	
	/*return a select list of all deposits type */
	public function get_types() : string{
		$req = "SELECT id,name FROM deposits_types";
		$ret = '';
		if($result = $this->db->select("id,name")->from('deposits_types')->get())
		{
			while ($obj = $result->fetch_object()) 
			{
				$ret.= '<option value="'.$obj->id.'">'.$obj->name.'</option>';
			}
		}
		$result->close();
		return $ret;
	}
	
	public function get_terrain_types() : string{
		$req = "SELECT  FROM terrains_types";
		$ret = '';
		if ($result = $this->db->select("id,type_name")->from("terrains_types")->get()) 
		{	$ret .= '<option disabled selected value> -- select a type -- </option>';
			while ($obj = $result->fetch_object()) 
			{
				$ret.= '<option value="'.$obj->id.'">'.$obj->type_name.'</option>';
			}
		}
		$result->close();
		return $ret;
	}	
}
?>