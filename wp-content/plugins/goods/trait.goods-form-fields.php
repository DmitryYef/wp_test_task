<?php
trait GoodsFormFields{
	public $gds_metaboxes = ['name', 'price', 'state', 'description', 'attributes'];
	
	protected function metaboxes() {
		add_action( 'add_meta_boxes', function() {
			foreach( $this->gds_metaboxes as $gds_meta ){
				// TO DO: Добавить перевод.
				add_meta_box( "gds_{$gds_meta}", __($gds_meta). ": ", [$this, "goods_" . $gds_meta . "_meta"], 'goods' );
			}
		});
		add_action( 'save_post', [$this,'add_date_create']);
		foreach( $this->gds_metaboxes as $gds_meta ){
			add_action( 'save_post', [$this,"save_{$gds_meta}"]);
		}
	}
	
	/**
	* Name
	*/
	public function goods_name_meta( $post ) {
		$gds_name = get_post_meta($post->ID, 'gds_name', true);
		?>
		<p>
			<label for="gds_name">Наименование: </label>
			<input type="text" class="widefat" name="gds_name" id="gds_name" placeholder="Введите наименование товара (Максимум 255 символов)" value="<?php echo esc_attr( $gds_name );?>" required="required" maxlength="255" /> 
		</p>
		<?php
	}
	
	public function save_name( $id ) {
		if( isset($_POST['gds_name']) ) {
			update_post_meta( $id, 'gds_name', substr( sanitize_text_field( $_POST['gds_name'] ), 0, 255) );
		}
	}
	
	/**
	* Price
	*/
	public function goods_price_meta( $post ) {
		$gds_price = get_post_meta($post->ID, 'gds_price', true);
		?>
		<p>
			<label for="gds_price">Цена: </label>
			<input type="number" class="widefat" id="gds_price" name="gds_price" placeholder="Введите цену товара 0.0" value="<?php echo esc_attr( $gds_price );?>" required="required"/> 
		</p>
		<?php
	}
	
	public function save_price($id) {
		if( isset($_POST['gds_price']) ) {
			update_post_meta( $id, 'gds_price', number_format( sanitize_text_field( $_POST['gds_price'] ), 2, '.', '') );
		}
	}
	
	/**
	* State
	*/
	public function goods_state_meta($post) {
		$gds_state = get_post_meta($post->ID, 'gds_state', true);
		?>
		<p>
			В наличии <input type="radio" id="gds_state" name="gds_state" value="1" <?php echo $gds_state==1 ? 'checked="checked"' : '';?> /> 
			/ Нет на складе <input type="radio" id="gds_state" name="gds_state" value="0" <?php echo $gds_state==0 ? 'checked="checked"' : '';?>/> 
		</p>
		<?php
	}
	
	public function save_state( $id ) {
		$gds_state = $_POST['gds_state'];
		if( isset( $gds_state ) and in_array( $gds_state, [0, 1] ) ) {
			update_post_meta( $id, 'gds_state', $gds_state);
		}
	} 
	
	/**
	* Description
	*/
	public function goods_description_meta($post) {
		$gds_description = get_post_meta($post->ID, 'gds_description', true);
		?>
		<p>
			<label for="gds_description">Описание: </label>
			<textarea id="gds_description" name="gds_description" cols="100" rows="10"><?php echo esc_attr( $gds_description );?></textarea>
		</p>
		<?php
	}
	
	public function save_description($id) {
		$gds_description = $_POST['gds_description'];
		if( isset( $gds_description ) ) {
			update_post_meta( $id, 'gds_description', esc_html( $_POST['gds_description'] ) );
		}
	} 
	
	/**
	* Attributes
	*/
	public function goods_attributes_meta($post) {
		?>
		<script>
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
				url: "<?php echo admin_url("admin-ajax.php") ?>",
				type:"post",
				data:{action: 'delete_attr', meta_id: meta_id, attr_id: attr_id},
				success: function(data){
					if( data=='OK' ){
						alert('Атрибут удален');
					}
				}
			});
		}
		</script>
		<p>
			<ul id="attributes">
				<?php
				$i=0;
				while( $gds_attr_name_{$i} = get_post_meta($post->ID, "gds_attr_name_{$i}", true)){
					$gds_attr_value_{$i} = get_post_meta($post->ID, "gds_attr_value_{$i}", true);
					?>
						<li id="attr_<?php echo $i;?>">
							Атрибут: <input type="text" id="gds_attr_name_<?php echo $i;?>" name="gds_attr_name[]" value="<?php echo esc_attr( $gds_attr_name_{$i} );?>" required="required"/>
							Значение: <input type="text" id="gds_attr_value_<?php echo $i;?>" name="gds_attr_value[]" value="<?php echo esc_attr( $gds_attr_value_{$i} );?>" required="required"/>
							<input class="remove-attr" type="button" onclick='delete_attr("<?php echo $post->ID?>", "<?php echo $i;?>")' value="Удалить">
						</li>
					<?php
					$i++;
				} 
				?>
				</ul>
			</p>
			<input type="hidden" id="next_attr" value="<?php echo ++$i;?>">
			<input class="add-attr" type="button" value="Добавить атрибут">
		<?php
	}
	
	public function save_attributes($id) {
		if( isset( $_POST['gds_attr_name'] ) ) {
			for( $i=0; $i < count( $_POST['gds_attr_name'] ); $i++ ){
				update_post_meta( (int)$id, 'gds_attr_name_' . $i, (int)$_POST['gds_attr_name'][$i]);
				update_post_meta( (int)$id, 'gds_attr_value_' . $i, (int)$_POST['gds_attr_value'][$i]);
			}
		}
	}
	
	/**
	* Goods date create 
	*/
	public function add_date_create($id) {
		if( empty( get_post_meta($id, 'gds_created_at', true) ) ){
			update_post_meta( $id, 'gds_created_at', date( "Y-m-d h:i:s", time() ) ) ;
		}
	}
}