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
function dialog_update_planet(id,name,size,terrain){
	//('#planet_name').value = name;
	dialog_me(planet_create);
	$('#planet_name').val(name);
	$('#planet_size').val(size);
	$('#planet_type').val(terrain);
}
function dialog_update_deposit(id,planet_id,size,terrain,coord_x,coord_y){
	//('#planet_name').value = name;
	dialog_me(deposit_create);
	$("#planet_id").val(planet_id)
	$('#coord_x').val(coord_x);
	$('#coord_y').val(coord_y);
	$('#deposit_size').val(size);
	$('#deposit_type').val(terrain);
}
function html_format_planet(response){
					var html_format='<table><tr><th></th><th>Name</th><th>Type</th><th>Size</th><th>action</th><tr>';
				$.each(response, function(i, object) {
					//$.each(object, function(property, value) {
						html_format += '<tr><td><img src="https://img.swcombine.com//galaxy/planets/'+object.terrain_type_id+'/main.gif" width="30" height="30"></td><td><strong><span>'+object.name+'</span></strong></td><td>'+object.terrain_type_name+'</td><td>'+object.size+'*'+object.size+'</td><td><input type="button" value="Delete" onclick="delete_elem(\'planet\','+object.planet_id+')"><input type="button" value="View"><input type="button" value="Update" onclick="dialog_update_planet('+object.planet_id+',\''+object.name+'\','+object.size+','+object.terrain_type_id+')"></td></tr>'; 

				//	});
				});
				return html_format+'</table>';
}
function html_format_deposit(response){
					var html_format='<table><tr><th></th><th>Planet</th><th>Type</th><th>Size</th><th>Location</th><th>action</th><tr>';
				$.each(response, function(i, object) {
					//$.each(object, function(property, value) {
					html_format += '<td><img src="https://img.swcombine.com//materials/'+object.type_id+'/deposit.gif" width="20" height="20"></td><td>'+object.planet+'</td><td>'+object.type+'</td><td>'+object.size+'</td><td>('+object.coord_x+','+object.coord_y+')</td><td><input type="button" value="Delete" onclick="delete_elem(\'deposit\','+object.deposit_id+')"><input type="button" value="Update" onclick="dialog_update_deposit('+object.deposit_id+',\''+object.planet_id+'\','+object.size+','+object.type_id+','+object.coord_x+','+object.coord_y+')"></td></tr>';
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
