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
			'description'           => 'Категории', // описание таксономии
			'public'                => true,
			'publicly_queryable'    => null, // равен аргументу public
			'show_in_nav_menus'     => true, // равен аргументу public
			'show_ui'               => true, // равен аргументу public
			'show_in_menu'          => true, // равен аргументу show_ui
			'hierarchical'          => true,
			'update_count_callback' => '',
			'rewrite'               => true,
			'capabilities'          => array(),
			'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
			'show_admin_column'     => false, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
			'_builtin'              => false,
			'show_in_quick_edit'    => null, // по умолчанию значение show_ui
		) );
	}

}

new Goods_Taxonomy();
