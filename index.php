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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.min.css">
  <script>
    /* // wait for the DOM to be loaded
	 var options = { 
    target:     '#planet_list', 
    url:        'controler.php', 
    success:    function() { 
        alert('planet created sucessfully'); 
    } 
}; 
     $(function() {
       // bind 'myForm' and provide a simple callback function
       $('#form_create_planet').ajaxForm( { beforeSubmit: validate } ); 
     });
	 function validate(formData, jqForm, options) { 
    // jqForm is a jQuery object which wraps the form DOM element 
    // 
    // To validate, we can access the DOM elements directly and return true 
    // only if the values of both the username and password fields evaluate 
    // to true 
 
    var form = jqForm[0]; 
    if (!form.planet_name.value) { 
        alert('Please enter a planet name'); 
        return false; 
    } 
	   if (!form.planet_size.value) { 
        alert('Please enter a planet size'); 
        return false; 
    } 
}*/
function dialog_me(item){
	$('#planet_name').val('');
	$('#planet_size').val('');
	$('#planet_type').val('');
	$( item ).dialog('open');
}
function delete_elem(type,id){
	$.ajax({ 
		url: "controler.php",
		type:'POST',
		dataType: "json",
		data: { delete : type,id : id },
		success: function(response){
			if(type == "planet")html = html_format_planet(response);
			else if(type == "deposit")html = html_format_deposit(response);
			$('#'+type+'_list_content').html(html);
    }});
	//first_load();
}
function dialog_update_planet(type,id,name,size,terrain){
	//('#planet_name').value = name;
	dialog_me(planet_create);
	$('#planet_name').val(name);
	$('#planet_size').val(size);
	$('#planet_type').val(terrain);
}
function html_format_planet(response){
					var html_format='<table><tr><th></th><th>Name</th><th>Type</th><th>Size</th><th>action</th><tr>';
				$.each(response, function(i, object) {
					//$.each(object, function(property, value) {
						html_format += '<tr><td><img src="https://img.swcombine.com//galaxy/planets/'+object.terrain_type_id+'/main.gif" width="30" height="30"></td><td><strong><span>'+object.name+'</span></strong></td><td>'+object.terrain_type_name+'</td><td>'+object.size+'*'+object.size+'</td><td><input type="button" value="Delete" onclick="delete_elem(\'planet\','+object.planet_id+')"><input type="button" value="View"><input type="button" value="Update" onclick="dialog_update_planet(\'planet\','+object.planet_id+',\''+object.name+'\','+object.size+','+object.terrain_type_id+')"></td></tr>'; 

				//	});
				});
				return html_format+'</table>';
}
function html_format_deposit(response){
					var html_format='<table><tr><th></th><th>Planet</th><th>Type</th><th>Size</th><th>Location</th><th>action</th><tr>';
				$.each(response, function(i, object) {
					//$.each(object, function(property, value) {
					html_format += '<td><img src="https://img.swcombine.com//materials/'+object.type_id+'/deposit.gif" width="20" height="20"></td><td>'+object.planet+'</td><td>'+object.type+'</td><td>'+object.size+'</td><td>('+object.coord_x+','+object.coord_y+')</td><td><input type="button" value="Delete" onclick="delete_elem(\'deposit\','+object.deposit_id+')"><input type="button" value="Update"></td></tr>';
				//	});
				});
				return html_format+'</table>';
}
function valid(){return true;}
function first_load(){
	$( "#planet_create" ).dialog({ 
	autoOpen: false,
    modal: true,
    resizable: false,

});
	$( "#deposit_create" ).dialog({ 
	autoOpen: false,
    modal: true,
    resizable: false,
});

	$.ajax({ url: "controler.php",
        type:'POST',
		dataType: "json",
		data: { get_planet_list : true },
        success: function(response){
           html = html_format_planet(response);
           $("#planet_list_content").html(html);
        }});
	$.ajax({ url: "controler.php",
        type:'POST',
		dataType: "json",
		data: { get_deposit_list : true },
        success: function(response){
				html = html_format_deposit(response);
                $("#deposit_list_content").html(html);
        }});
}
$(document).ready(function()
{
	first_load();
    $('#form_create_planet').submit(function(e)
    {     
        e.preventDefault();
        var $form = $(this);
        if(!valid()) return false;
        $.ajax({
			type:'POST',
			url:'controler.php',
			data:$('#form_create_planet').serialize(),
			dataType: "json",
			success:function(response)
			{
				html = html_format_planet(response);
                $("#planet_list_content").html(html);
				$("#planet_create").dialog('close');
            }
                });     

    })
	    $('#form_create_deposit').submit(function(e)
    {     
        e.preventDefault();
        var $form = $(this);
        if(!valid()) return false;
        $.ajax({
			type:'POST',
			url:'controler.php',
			data:$('#form_create_deposit').serialize(),
			dataType: "json",
			success:function(response)
			{
				html = html_format_deposit(response);
                $("#deposit_list_content").html(html);
				$("#deposit_create").dialog('close');
            }
                });     

    })
			
});

   </script>
  
</head>
<body>
	<div id="planet_create" class="" title="create planet">
	<form id="form_create_planet">
		<label for="planet_name">Name</label><input class="" type="text" name="planet_name" id="planet_name" placeholder="Enter planet name" >
		<label for="planet_size">Size</label><input class="" type="text" name="planet_size" id="planet_size" placeholder="Enter planet Size">
		<label for="planet_type">Type</label><select name="planet_type" class="" id="planet_type">
		<?php 
			$liste = new terrain();
			echo $liste->get_types(); 
			?>
		</select>
		<input type="submit" name="planet_action" id="action_planet" value="Validate" >
	</form>
	</div>
	<div id="deposit_create" class="form_box" title="create deposit">
	<form id="form_create_deposit">
		<label for="planet_id">Planet</label><select name="planet_id" class="">
		<?php 
			$liste = new planet();
			echo $liste->planet_get_select(); 
		?>
		</select>
		<label for="deposit_size">Size</label><input class="" type="text" name="deposit_size" placeholder="Enter deposit Size">
		<label for="coord_x">coord x</label><input class="" type="text" name="coord_x" placeholder="Enter deposit Size">
		<label for="coord_y">coord y</label><input class="" type="text" name="coord_y" placeholder="Enter deposit Size">
		<label for="deposit_type">Type</label><select name="deposit_type" class="">
		<?php 
			$liste = new deposit();
			echo $liste->get_types(); 
		?>
		</select>
		<input type="submit" name="action" value="Create Deposit">
	</form>
	</div>
<div class="navbar">
	<div>
		<input type="button" value="Create Planet" onclick="dialog_me('#planet_create','#deposit_create')">
	</div>
	<div>
		<input type="button" value="Create Deposit" onclick="dialog_me('#deposit_create','#planet_create')">
	</div>
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

</body>
</html>