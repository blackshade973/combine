<?php
include("deposit.class.php");
include("planet.class.php");
include("terrain.class.php");

if(isset($_POST)){
	if(isset($_POST['planet_name']))
	{
		$planet = new planet('',$_POST['planet_name'],$_POST['planet_size'],$_POST['planet_type']);
		echo json_encode($planet->planet_get(true),JSON_FORCE_OBJECT);
	}
	if(isset($_POST['deposit_size']))
	{
		$deposit = new deposit('',$_POST['planet_id'],$_POST['deposit_size'],$_POST['deposit_type'],$_POST['coord_x'],$_POST['coord_y']);
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