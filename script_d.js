function view_planet(id,size){
	$( "#map" ).dialog("option", "height", (size+3)*30);
	$( "#map" ).dialog("option", "width", (size+3)*30);
	$( "#map_content").css({'width': size*30});
	$( "#map_content").css({'height': size*30});
	put_deposit(id);
	$( "#map" ).dialog('open');
}
function put_deposit(id){
	$("#map_content").empty();
	$.ajax({ url: "controler.php",
        type:'POST',
		dataType: "json",
		data: { get_planet__deposit_list : true, planet_id : id },
        success: function(response){
			var elem='';
			var top;
			var left;
			$.each(response, function(i, object) {
				top = (object.coord_y*30)-15;
				left = ((object.coord_x-1)*30)+15;
				elm = '<div title = "'+object.type+' : '+object.size+' units" class ="elem" style="background-image: url(https://img.swcombine.com//materials/'+object.type_id+'/deposit.gif); position : absolute; top: '+top+'px;left: '+left+'px; z-index:100"></div>';
				$(elm).appendTo("#map_content");

			});
        }});	
}
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
		data: { delete : type,id : id },
		success: function(response){
					load_planet_list();
					load_deposit_list();
					$("#message").html(response);
		}});
}
function dialog_update_planet(id,name,size,terrain){
	dialog_me(planet_create);
	$('#planet_name').val(name);
	$('#planet_size').val(size);
	$('#planet_type').val(terrain);
	$('#planet_id').val(id);
}
function dialog_update_deposit(id,planet_id,size,terrain,coord_x,coord_y){
	dialog_me(deposit_create);
	$("#planet_id").val(planet_id)
	$('#coord_x').val(coord_x);
	$('#coord_y').val(coord_y);
	$('#deposit_size').val(size);
	$('#deposit_type').val(terrain);
	$('#deposit_id').val(id);
}
function html_format_planet(response){
	var html_format='<table><tr><th></th><th>Name</th><th>Type</th><th>Size</th><th>action</th><tr>';
	$.each(response, function(i, object) {
		html_format += '<tr><td><img src="https://img.swcombine.com//galaxy/planets/'+object.terrain_type_id+'/main.gif" width="30" height="30"></td><td><strong><span>'+object.name+'</span></strong></td><td>'+object.terrain_type_name+'</td><td>'+object.size+'*'+object.size+'</td><td><input type="button" value="Delete" onclick="delete_elem(\'planet\','+object.planet_id+')"><input type="button" value="View" onclick="view_planet('+object.planet_id+','+object.size+')"><input type="button" value="Update" onclick="dialog_update_planet('+object.planet_id+',\''+object.name+'\','+object.size+','+object.terrain_type_id+')"></td></tr>'; 
	});
	return html_format+'</table>';
}
function html_format_deposit(response){
	var html_format='<table><tr><th></th><th>Planet</th><th>Type</th><th>Size</th><th>Location</th><th>action</th><tr>';
	$.each(response, function(i, object) {
		html_format += '<td><img src="https://img.swcombine.com//materials/'+object.type_id+'/deposit.gif" width="20" height="20"></td><td>'+object.planet+'</td><td>'+object.type+'</td><td>'+object.size+'</td><td>('+object.coord_x+','+object.coord_y+')</td><td><input type="button" value="Delete" onclick="delete_elem(\'deposit\','+object.deposit_id+')"><input type="button" value="Update" onclick="dialog_update_deposit('+object.deposit_id+',\''+object.planet_id+'\','+object.size+','+object.type_id+','+object.coord_x+','+object.coord_y+')"></td></tr>';
		});
	return html_format+'</table>';
}
function reload_select_planet(response){
	$("#deposit_planet_id").children().remove();
	$.each(response, function(i, object) {
		$("#deposit_planet_id").append('<option value="'+object.planet_id+'">'+object.name+'</option>');
	});
}
function load_planet_list(){
	$.ajax({ url: "controler.php",
    type:'POST',
	dataType: "json",
	data: { get_planet_list : true },
    success: function(response){
        html = html_format_planet(response);
        $("#planet_list_content").html(html);
		reload_select_planet(response);
    }});
}
function load_deposit_list(){
	$.ajax({ url: "controler.php",
        type:'POST',
		dataType: "json",
		data: { get_deposit_list : true },
        success: function(response){
			html = html_format_deposit(response);
            $("#deposit_list_content").html(html);
        }});	
}

function valid(){
	$('#form_create_planet').validate({
		rules: {
			planet_size: {
				required : true,
				digits : true
			},
			planet_name: {
			required: true,
			maxlength: 55
			}
		},
		messages: {
			planet_size: {
				required : "Please enter a planet size",
				digits : "planet size must be a number",
			},
			planet_name: {
				required: "Please provide a planet_name",
				minlength: "Planet name should be 55 carac max"
			}
		},
		submitHandler: function() {
			$.ajax({
				type:'POST',
				url:'controler.php',
				data:$('#form_create_planet').serialize(),
				//dataType: "json",
				success:function(response)
				{
					load_planet_list();
					load_deposit_list();
					$("#planet_create").dialog('close');
					$("#message").html(response);
				}
            });     

		}
	});
	$('#form_create_deposit').validate({
		rules: {
			deposit_size: {
				required : true,
				digits : true
			},
			coord_x : {
				required : true,
				digits : true
			},
			coord_y :{
				required : true,
				digits : true
			}
		},
		messages: {
			deposit_size: {
				required : "Please enter a size",
				digits : "size must be a number",
			},
			coord_x: {
				required : "Please enter a x coordinate",
				digits : "coordinate must be a number",
			},
			coord_y: {
				required : "Please enter a y coordinate",
				digits : "coordinate must be a number",
			},
			
		},
		submitHandler: function() {
			$.ajax({
				type:'POST',
				url:'controler.php',
				data:$('#form_create_deposit').serialize(),
				success:function(response)
				{
					load_planet_list();
					load_deposit_list();
					$("#deposit_create").dialog('close');
					$("#message").html(response);
				}
            });     

		}
	});
}

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
	$( "#map" ).dialog({ 
	autoOpen: false,
    modal: true,
    resizable: false,

});
}

$(document).ready(function()
{
	first_load();
	valid('#form_create_planet');
	valid('#form_create_deposit');
	load_planet_list();
	load_deposit_list();
 
			
});
