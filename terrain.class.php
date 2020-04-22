<?php
class terrain{
	public $type;
	private $planet_id;
	private $coord_x;
	private $coord_y;
	
		public function __construct($name=null,$size=null,$type=null){
		$this->db = new mysqli("localhost", "root", "", "combine");

	}
	public function get_types(){
		$req = "SELECT id,type_name FROM terrains_types";
		$ret = '';
		if ($result = $this->db->query($req)) 
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