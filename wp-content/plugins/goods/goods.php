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
require_once( GOODS_PLUGIN_PATH . '/trait.goods-form-columns.php' ); 
require_once( GOODS_PLUGIN_PATH . '/class.goods-post-type.php' ); 
require_once( GOODS_PLUGIN_PATH . '/class.goods-taxonomy.php' ); 

add_action('wp_ajax_get_posts'       , 'get_posts_callback');

wp_register_script( 'gds-js.js', plugin_dir_url( __FILE__ ) . 'js/gds-js.js', array('jquery'));
wp_enqueue_script( 'gds-js.js' );

