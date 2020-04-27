<?php
class my_db{
	
	/** @var array<mixed> $params */
	public $params;
	/** @var string $req */
	private $req;
	/** @var object $db */
	private $db;
	/** @var mysqli_result<mixed> $select_results */
	private $select_results;
	
	public function __construct(){
		$this->db = new mysqli(HOST, USER, PASS, DBNAME);
	}

	public function select(string $what) : self{
		$this->req = 'SELECT '.$what.' ';
		return $this;
	}

	public function from(string $from) : self{
		$this->req .= 'FROM '.$from.' ';
		return $this;
	}

	public function where(string $where) : self{
		$this->req .='WHERE '.$where.' ';
		return $this;
	}

	/**
	* @return mysqli_result<mixed> 
	*/
	public function get() : mysqli_result{
		$this->make_request(true);
		return $this->select_results;
	}

	public function insert_into(string $table) : self{
		$this->req = 'INSERT INTO '.$table.' ';
		return $this;
	}
	/**
	* @param array<mixed> $values 
	*/
	public function values(array $values) : bool{
		$this->req .= 'VALUES (';
		foreach($values as $key=>$val)
		{
			if($val != '')$this->req .= '?,';
			else $this->req .= '"",';
		}
		$this->req = substr($this->req, 0, -1).')';
		$this->params = $values;
		return $this->make_request();
	}
	
	/**
	* @param array<mixed> $params 
	*/
	public function params(array $params) : self{
		$this->params = $params;
		return $this;
	}

	public function update(string $table) : self{
		$this->req  = 'UPDATE '.$table.' ';  
		return $this;
		}

	public function set(string $set) : self{
		$this->req .= ' SET '.$set.' ';
		return $this;
	}

	public function go() : bool{
		return $this->make_request();
	}

	public function delete() : self{
		$this->req = 'DELETE ';
		return $this;
	}
	
	public function make_request(bool $isSelect = false) : bool{
		if(!isset($this->params))
		{
			$this->select_results = $this->db->query($this->req);
			return true;
		}

		$string = '';
		$n = count($this->params);
		for($i = 0; $i < $n; $i++) {
			if (is_float($this->params[$i]))
			{
				$string .= 'd';
			}
            elseif (is_integer($this->params[$i]))
			{
				$string .= 'i';
			}
            elseif (is_string($this->params[$i]) && $this->params[$i] != '')
			{
				$string .= 's';
				$param[$i] = htmlspecialchars($this->params[$i]);
			}
            else if($this->params[$i]!='')
			{
				$string .= 'b';
			}
		}
		$param = array_merge(array($string), $this->params);
		$n = count($param);
		$a_params = array();
		for($i = 0; $i < $n; $i++)
		{
			if($param[$i]!='') $a_params[] = &$param[$i];
		}
		//echo $this->req.'<br>';
		$req_p = $this->db->prepare($this->req) or die ($this->db->error .'on req '. $this->req);
		call_user_func_array(array($req_p, 'bind_param'), $a_params);
		$result = $req_p->execute() or die ($this->db->error .'on req '. $this->req);
		if($isSelect ==  false)
		{
			return true;
		}
		else
		{
			$this->select_results = $req_p->get_result();
			return true;
		}
	}
	
}
?>