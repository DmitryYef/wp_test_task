<?php
/*
 * Plugin Name: Каталог товаров
 * Description: Тестовое задание.
 * Version: 1.1
 * Author: Ефимов Дмитрий
 */
 
/* 
	Copyright 2018  Efimov Dmitriy  (email: dimayef@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('GOODS_PLUGIN_PATH', dirname(__FILE__));

require_once( GOODS_PLUGIN_PATH . '/trait.goods-form-fields.php' ); 
require_once( GOODS_PLUGIN_PATH . '/class.goods-post-type.php' ); 
require_once( GOODS_PLUGIN_PATH . '/class.goods-taxonomy.php' ); 

add_filter( 'template_include', 'include_template_function', 1 );
add_filter( 'manage_edit-goods_columns', 'true_add_post_columns', 10, 1 );
add_action( 'manage_posts_custom_column', 'true_fill_post_columns', 10, 1 );

add_action('wp_ajax_get_posts'       , 'get_posts_callback');
add_action('wp_ajax_nopriv_get_posts', 'get_posts_callback');

wp_register_script( 'gds-js.js', plugin_dir_url( __FILE__ ) . 'js/gds-js.js', array('jquery'));
wp_enqueue_script( 'gds-js.js' );

function include_template_function( $template_path ) {
    if ( get_post_type() == 'goods' ) {
        if ( is_single() ) {
            
            if ( $theme_file = locate_template( array ( 'single-goods.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '\templates\single-goods.php';
            }
        }
    }
    return $template_path;
}

function true_add_post_columns( $my_columns ){
	$my_columns = array(
		'title' => 'Наименование',
		'gds_price' => 'Цена',
		'gds_state' => 'Статус',
		'date' => 'Дата создания',
	);
	return $my_columns;
}

function true_fill_post_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'gds_price':
			echo get_post_meta($post->ID, 'gds_price', true);
			break;
		case 'gds_state':
			$gds_state = get_post_meta( $post->ID, 'gds_state', true );
		?>
			<script>
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
			</script>
			<p>
				<input type="radio" class="state_radio" name="gds_state_<?php echo $post->ID; ?>" value="1" onclick="switch_state('<?php echo $post->ID; ?>', 1);" <?php echo $gds_state=="1" ? 'checked="checked"' : '';?> /> В наличии  <br />
				<input type="radio" class="state_radio" name="gds_state_<?php echo $post->ID; ?>" value="0" onclick="switch_state('<?php echo $post->ID; ?>', 0);" <?php echo $gds_state=="0" ? 'checked="checked"' : '';?>/> Нет на складе  
			</p>
		<?php
			break;
	}
}