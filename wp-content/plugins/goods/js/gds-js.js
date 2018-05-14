jQuery(document).ready(function($){
	$('.add-attr').click(function() {
		var next_attr = jQuery("#next_attr").val();
		jQuery("#next_attr").val(Number(next_attr)+1);
		$("#attributes").append('<li id="attr_'+next_attr+'">Атрибут: <input type="text" id="gds_attr_name_'+next_attr+'" name="gds_attr_name[]" value="" required="required"/>	Значение: <input type="text" id="gds_attr_value_'+next_attr+'" name="gds_attr_value[]" value="" required="required"/> <input class="remove-attr" type="button" value="Удалить" /></li>');
		return false;
	});
	
	jQuery(document).ready(function($){
		$('html').on('click', '.remove-attr', function(){			
			$(this).parent().remove();				
			return false;
		});
	});
});

function delete_attr(meta_id, attr_id){
	jQuery.ajax({
		url: 'admin-ajax.php',
		type:"post",
		data:{action: 'delete_attr', meta_id: meta_id, attr_id: attr_id},
		success: function(data){
			if( data=='OK' ){
				alert('Атрибут удален');
			}
		}
	});
}

function switch_state( id, state ){
	jQuery.ajax({
		url: "<?php echo admin_url("admin-ajax.php") ?>",
		type: "post",
		data: {action: 'switch_state', gds_id: id, gds_state: state }, 
		success:function(data){
			if( data=='OK' ){
				alert( 'Статус обновлен' );
			}
		}});
}