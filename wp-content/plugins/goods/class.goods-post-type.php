<?php
/**
 * Create post type: goods
 */

class GoodsPostType {
	use GoodsFormFields;
	
	function __construct() {
		add_action('init', array ($this, 'create_goods'));
		$this->metaboxes();
	}

	public function create_goods() {
		register_post_type( 'goods', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Товары',
				'singular_name'      => 'Товар',
				'add_new'            => 'Добавить товар',
				'add_new_item'       => 'Добавление товара',
				'edit_item'          => 'Редактирование товара',
				'view_item'          => 'Детально',
				'not_found'          => 'Не найдено',
				'menu_name'          => 'Tовары', 
			),
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => null, 
			'exclude_from_search' => null, 
			'show_ui'             => null, 
			'show_in_menu'        => null, 
			'show_in_admin_bar'   => null,
			'show_in_nav_menus'   => null, 
			'menu_icon'           => null, 
			'hierarchical'        => false,
			'supports'            => array(''), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array('goods_shop_taxonomy'),
			'has_archive'         => false,
			'rewrite' 			  => array('slug' => 'goods', 'with_front' => false),
			'query_var'           => true,
		) );
	}
}

new GoodsPostType();

