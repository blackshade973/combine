<?php
include("constantes.php");
require_once("my_db.class.php");
require("deposit.class.php");
include("planet.class.php");

	if(isset($_POST['get_planet_deposit_list']))
	{
		/*get the list of all deposits on a given planet*/
		$planet = new planet($_POST['planet_id']);
		echo json_encode($planet->deposit_get(false),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['planet_name']) && isset($_POST['planet_name']) && isset($_POST['planet_size']) && isset($_POST['planet_type']))
	{
		/* form for creation or update of a planet has been updated */
		$planet = new planet();
		$planet->name = $_POST['planet_name'];
		$planet->size = $_POST['planet_size'];
		$planet->type = $_POST['planet_type'];	
		if(!isset($_POST['planet_id']) || $_POST['planet_id'] == null)
		{
			$planet->planet_create();
		}
		else
		{
			$planet->planet_update($_POST['planet_id']);
		}
	}
	if(isset($_POST['deposit_size']) && isset($_POST['deposit_type']) && isset($_POST['coord_x']) && isset($_POST['coord_y']))
	{
		/* form for creation or update of a deposit has been updated */
		$deposit = new deposit();
		$deposit->planet_id = $_POST['deposit_planet_id'];
		$deposit->size = $_POST['deposit_size'];
		$deposit->type = $_POST['deposit_type'];
		$deposit->coord_x = $_POST['coord_x'];
		$deposit->coord_y = $_POST['coord_y'];
		if(isset($_POST['deposit_id']) && $_POST['deposit_id'] != NULL)
		{
			$deposit->deposit_update($_POST['deposit_id']);
		}
		else 
		{
			$deposit->deposit_create();
		}
	}
	if(isset($_POST['get_planet_list']))
	{
		/*get the list of all planets */
		$liste = new planet();
		echo json_encode($liste->planet_get(),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['get_deposit_list']))
	{
		/*get the list of all deposits */
		$liste = new deposit();
		echo json_encode($liste->deposit_get(true),JSON_FORCE_OBJECT);
	}
	
	/* delete planets or deposits */
	if(isset($_POST['delete']))
	{
		if($_POST['delete'] == 'planet')
		{
			$planet = new planet($_POST['id']);
			$planet->planet_delete();
		}
		if($_POST['delete'] == 'deposit')
		{
			$deposit = new deposit();
			$deposit->deposit_delete($_POST['id']);
		}
	}
	if(isset($planet->message))
	{
		echo $planet->message;
	}
	else if (isset($deposit->message))
	{
		echo $deposit->message;
	}
		
?>