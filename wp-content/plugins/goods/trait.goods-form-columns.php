<?php
trait GoodsColumns{	
	protected function columns() {
		add_filter( 'manage_edit-goods_columns', [$this, 'post_columns'], 10, 1 );
		add_action( 'manage_posts_custom_column',[$this,  'switch_state'], 10, 1 );
	}

	public function post_columns( $my_columns ){
		$my_columns = array(
			'cb' => '<input type="checkbox" />',
			'gds_name' => 'Наименование',
			'gds_price' => 'Цена',
			'gds_state' => 'Статус',
			'date' => 'Дата создания',
		);
		return $my_columns;
	}

	public function switch_state( $column ) {
		global $post;
		switch ( $column ) {
			case 'gds_name':
				echo get_post_meta($post->ID, 'gds_name', true);
				break;
			case 'gds_price':
				echo get_post_meta($post->ID, 'gds_price', true);
				break;
			case 'gds_state':
				$gds_state = get_post_meta( $post->ID, 'gds_state', true );
			?>
				<p>
					<input type="radio" class="state_radio" name="gds_state_<?php echo $post->ID; ?>" value="1" onclick="switch_state('<?php echo $post->ID; ?>', 1);" <?php echo $gds_state=="1" ? 'checked="checked"' : '';?> /> В наличии  <br />
					<input type="radio" class="state_radio" name="gds_state_<?php echo $post->ID; ?>" value="0" onclick="switch_state('<?php echo $post->ID; ?>', 0);" <?php echo $gds_state=="0" ? 'checked="checked"' : '';?>/> Нет на складе  
				</p>
			<?php
				break;
		}
	}
}