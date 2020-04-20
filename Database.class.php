<?php
//require_once('conf_debug.php');
//require_once('conf_tables_mysql.php');

class Database{
var $mysql_host='localhost'; // le serveur
var $mysql_login='root'; // le login
var $mysql_pass=''; // mot de passe
var $mysql_dbnom='combine'; // nom de la base de donnee
var $db;
function __construct()
{
	$this->db=mysql_connect($this->mysql_host,$this->mysql_login,$this->mysql_pass);
	mysql_select_db($this->mysql_dbnom,$this->db);
}

function get_db_link()
{
	return $this->db;
}

function close()
{
	mysql_close($this->db);
}

/*public function __destruct()
{
	mysql_close($this->db);
}*/
function make_insert($table,$values){
	$req = "INSERT INTO $table ($values)";
	if(DEBUG==1)
		echo "<font color='#FF0000'><strong>$req</strong></font><br>";
	if($insert = mysqli_query($req) or die('<font color="#FF0000"><strong>'.mysql_error().'</strong></font><br>'))
		return "succes";
	else 
		return "erreur";
}
function make_req_insert($req){
	if(DEBUG==1)
		echo "<font color='#FF0000'><strong>$req</strong></font><br>";
	if($insert = mysql_query($req) or die('<font color="#FF0000"><strong>'.mysql_error().'</strong></font><br>'))
		return "succes";
	else 
		return "erreur";
}
function make_delete($table,$where){
	$req="delete from $table where $where";
	if(DEBUG==1)
		echo "<font color='#FF0000'><strong>$req</strong></font><br>";
	mysql_query("delete from $table where $where")or die(''.$req.' ->'.mysql_error().'');
}
function make_update($table,$clause,$where){
	if(DEBUG==1)
		echo "<font color='#FF0000'><strong>UPDATE $table SET $clause where $where</strong></font><br>";
	if($insert = mysql_query("UPDATE $table SET $clause where $where") or die(mysql_error()))
		return "succes";
	else 
		return "erreur";
}
function get($id,$table,&$obj){
	if($id>0)
		$sql = "select * from $table where id = $id";
	else 
		$sql = "select * from $table";
if(DEBUG==1)
	echo "<font color='#FF0000'><strong>$sql</strong></font><br>";
	$select = mysql_query($sql);
	$result = mysql_fetch_object($select);
	if($result==FALSE)
		return FALSE;
	foreach(get_object_vars($result) as $var => $value)
		$obj->$var = $value;
	return $result;
}
/**
 * R�cupere le champ de nom "$nom_champ" dans la table $table pour $param=$val_param.
 * Attention de bien lancer cette fonction avec des parametres uniques, tels un ID.
 * En effet, si plusieurs r�sultats sont trouv�s, seul le premier sera r�cup�r�.
 * Le parametre filtre devrait etre l'ID ou tout autre champ unique.
 *
 * @param string $nom_champ Le nom du champ a rechercher
 * @param string $param Le nom du parametre de selection
 * @param mixed $val_champ La valeur du parametre de filtrage
 * @param string $table la table dans laquelle doit etre faite la recherche
 * @return mixed Le champ a r�cuperer si succes, FALSE si rien n'a �t� trouv�.
 */
function get_champ($nom_champ,$param,$val_param,$table)
{		  
$sql = "select `$nom_champ` from `$table` where `$param` = $val_param";
if(DEBUG==1)echo "<font color='#FF0000'><strong>$sql</strong></font><br>";
$res = mysql_query($sql) or die ('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$result = mysql_fetch_row($res);
return $result['0'];
}

function get_id($nom_champ,$val_champ,$table)
{		  
$sql = "select id from `$table` where `$nom_champ` = $val_champ";
if(DEBUG==1)echo "<font color='#FF0000'><strong>$sql</strong></font><br>";
$res = mysql_query($sql) or die ('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$result = mysql_fetch_row($res);
return $result['0'];
}

function get_all($table,&$obj)
{
	$result=null;//valeur de retour par defaut en cas de probleme
	$n=0;
	$sql = "select * from $table";
	if(DEBUG==1)
		{echo "<font color='#FF0000'><strong>$sql</strong></font><br>";}
	$select = mysql_query($sql);
	while($result = mysql_fetch_object($select))
	{
		foreach(get_object_vars($result) as $var => $value) $obj->$var[$n] = $value;
		$n++;
	}

	return $result;
}


function make_count($field,$table,$where)
{
	if(DEBUG==1)
		{echo "<font color='#FF0000'><strong>select count($field) from $table where $where</strong></font><br>";}
	return mysql_fetch_array(mysql_query("select count($field) from $table where $where"));
}


function make_select($req)
{
	if(DEBUG==1)
		{echo "<font color='#FF0000'><strong>$req</strong></font><br>";}
	$return='';//attention, different de 'null'!
	$select = mysql_query($req) or die ('erreur'.mysql_error().'<br>');
	$n=0;
	$num = mysql_num_rows($select);
	if($num==1)
	{
		$return=mysql_fetch_assoc($select);
	}
	else
	{
		while($result = mysql_fetch_assoc($select))
		{
			$return[$n]=$result;
			$n++;
		}
	}
	return $return;
}



}
?>