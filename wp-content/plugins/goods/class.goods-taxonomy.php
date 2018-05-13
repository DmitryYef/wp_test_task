<?php
/**
 * Custom Taxonomy: Goods Tag
 */

class Goods_Taxonomy {
	function __construct() {
		add_action('init', array ( $this, 'create_goods_taxonomy') );
	}
	
	public function create_goods_taxonomy() {
		register_taxonomy('goods_shop_taxonomy', array('goods'), array(
			'labels'                => array(
				'name'              => 'Категории',
				'singular_name'     => 'Категория',
				'all_items'         => 'Все категории',
				'view_item '        => 'Детально',
				'parent_item'       => 'Принадлежит: ',
				'parent_item_colon' => 'Принадлежит: ',
				'edit_item'         => 'Редактировать категорию',
				'update_item'       => 'Обновить категорию',
				'add_new_item'      => 'Добавить категорию',
				'new_item_name'     => 'Название категории',
				'menu_name'         => 'Таксономии',
			),
			'description'           => 'Категории',
			'public'                => true,
			'publicly_queryable'    => null,
			'show_in_nav_menus'     => true,
			'show_ui'               => true, 
			'show_in_menu'          => true,
			'hierarchical'          => true,
			'update_count_callback' => '',
			'rewrite'               => true,
			'capabilities'          => array(),
			'show_admin_column'     => false,
			'_builtin'              => false,
			'show_in_quick_edit'    => null,
		) );
	}

}

new Goods_Taxonomy();
