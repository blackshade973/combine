<?php
include("deposit.class.php");
include("planet.class.php");
include("terrain.class.php");

if(isset($_POST)){
	if(isset($_POST['planet_name']))
	{
		if(!isset($_POST['planet_id']))
		{
			$planet = new planet('',$_POST['planet_name'],$_POST['planet_size'],$_POST['planet_type']);
		}
		else
		{
			$planet = new planet($_POST['planet_id']);
			$planet->name = $_POST['planet_name'];
			$planet->size = $_POST['planet_size'];
			$planet->type = $_POST['planet_type'];
			$planet->planet_update();
		}
		echo json_encode($planet->planet_get(true),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['deposit_size']))
	{
		if(!isset($_POST['deposit_id']))
		{
			$deposit = new deposit('',$_POST['planet_id'],$_POST['deposit_size'],$_POST['deposit_type'],$_POST['coord_x'],$_POST['coord_y']);
		}
		else
		{
			$deposit = new deposit($_POST['deposit_id']);
			$deposit->planet_id = $_POST['planet_id'];
			$deposit->size = $_POST['deposit_size'];
			$deposit->type = $_POST['deposit_type'];
			$deposit->coord_x = $_POST['coord_x'];
			$deposit->coord_y = $_POST['coord_y'];
			$deposit->deposit_update();
		}
		echo json_encode($deposit->deposit_get(true),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['get_planet_list']))
	{
		$liste = new planet();
		echo json_encode($liste->planet_get(true),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['get_deposit_list']))
	{
		$liste = new deposit();
		echo json_encode($liste->deposit_get(true),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['delete']))
	{
		if($_POST['delete'] == 'planet')
		{
			$planet = new planet($_POST['id']);
			$planet->planet_delete();
			echo json_encode($planet->planet_get(true),JSON_FORCE_OBJECT);
		}
		if($_POST['delete'] == 'deposit')
		{
			$deposit = new deposit($_POST['id']);
			$deposit->deposit_delete();
			echo json_encode($deposit->deposit_get(true),JSON_FORCE_OBJECT);
		}
	}
}


?>