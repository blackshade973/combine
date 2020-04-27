<?php include ('controler.php'); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Deposit Manager</title>
  <link rel="stylesheet" href="style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="http://malsup.github.io/jquery.form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="script_d.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.min.css">

</head>
<body>

	<div id="planet_create" class="" title="create planet">
	<form id="form_create_planet">
		<label for="planet_name">Name</label><input class="" type="text" name="planet_name" id="planet_name" placeholder="Enter planet name" >
		<label for="planet_size">Size</label><input class="" type="text" name="planet_size" id="planet_size" placeholder="Enter planet Size" min = 1 max=20>
		<label for="planet_type">Type</label><select name="planet_type" class="" id="planet_type">
		<?php 
			$liste = new deposit();
			echo $liste->get_terrain_types(); 
			?>
		</select>
		<input type="submit" name="planet_action" id="action_planet" value="Validate" >
		<input type="hidden" name="planet_id" id="planet_id"> 
	</form>
	</div>
	<div id="deposit_create" class="form_box" title="create deposit">
		<form id="form_create_deposit">
			<label for="planet_id">Planet</label><select name="deposit_planet_id" id="deposit_planet_id" class="">
			</select>
			<label for="deposit_size">Size</label><input class="" type="text" name="deposit_size" id="deposit_size" placeholder="Enter deposit Size">
			<label for="coord_x">coord x</label><input class="" type="text" name="coord_x" id="coord_x" placeholder="Enter deposit Size" min=1>
			<label for="coord_y">coord y</label><input class="" type="text" name="coord_y" id="coord_y" placeholder="Enter deposit Size" min=1>
			<label for="deposit_type">Type</label><select name="deposit_type" id="deposit_type" class="">
			<?php 
				//$liste = new deposit();
				echo $liste->get_types(); 
			?>
			</select>
			<input type="hidden" name="deposit_id" id="deposit_id"> 
			<input type="submit" name="action" value="Validate">
		</form>
	</div>
	<div class="navbar">
		<div>
			<input type="button" value="Create Planet" onclick="dialog_me('#planet_create','#deposit_create')">
		</div>
		<div>
			<input type="button" value="Create Deposit" onclick="dialog_me('#deposit_create','#planet_create')">
		</div>
		<div class="message" id="message"></div>
	</div>
	<div id="planet_list" class="main">
		<div class="contentHeading">
			<h2>Planets</h2>
		</div>
		<div id="planet_list_content"></div>
	</div>
	<div id="deposit_list" class="main">
		<div class="contentHeading">
			<h2>Deposits</h2>
		</div>
		<div id="deposit_list_content"></div>
		
	</div>
		<div id="map"><div id = "map_content" style="
						border : 1px solid;
						z-index:50;
                        background-image: repeating-linear-gradient(  0deg, transparent, transparent 29px, rgba(255, 255, 255, 0.1) 29px, rgba(255, 255, 255, 0.1) 30px),
                                       repeating-linear-gradient(-90deg, transparent, transparent 29px, rgba(255, 255, 255, 0.1) 29px, rgba(255, 255, 255, 0.1) 30px);
                     ">
    </div></div>
</body>
</html>