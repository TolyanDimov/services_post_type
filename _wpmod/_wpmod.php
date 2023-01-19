<?php
/**
 * Plugin Name: WPMOD
 * Description: CPT
 * Version:     +100500
 */

/**
 * mod_cpt_services() ------------- Услуги.
 * permalink_services_cat() ------- Структура ссылок для категорий.
 * rewrite_rules_services_cat() --- Генерация правил перезаписи ссылок для категорий.
 *
 * breadcrumbs_cpt_services() ----- Blocksy - добавление 'post_type' в хлебные крошки.
 * breadcrumbs_cpt_services_cat() - Blocksy - замена 'taxonomy_name' в хлебных крошках.
 *
 * reset_rewrite_rules() --------- Сброс правил перезаписи при создании/удалении/изменении категорий и тегов.
 */

//==========================================================
// mod_cpt_services()
//==========================================================

add_action( 'init', 'mod_cpt_services', 0 );
function mod_cpt_services() {

	// cpt_services
	register_post_type( 'cpt_services', array(
		'labels'        => array(
			'name'                       => 'Услуги',
			'singular_name'              => 'Услуга',
			'menu_name'                  => 'Услуги',
			'name_admin_bar'             => 'Услугу',
			'add_new'                    => 'Добавить новую',
			'add_new_item'               => 'Добавить новую услугу',
			'edit_item'                  => 'Редактироваь услугу',
			'new_item'                   => 'Новая услуга',
			'view_item'                  => 'Показать услугу',
			'view_items'                 => 'Показать услуги',
			'search_items'               => 'Поиск услуг',
			'not_found'                  => 'Услуг не найдено.',
			'not_found_in_trash'         => 'В корзине услуг не найдено.',
			'parent_item_colon'          => 'Родительская услуга:',
			'all_items'                  => 'Все услуги',
			'archives'                   => 'Список услуг',
			'attributes'                 => 'Атрибуты услуги',
			'insert_into_item'           => 'Вставить на услугу',
			'uploaded_to_this_item'      => 'Загружено на эту страницу',
			'featured_image'             => 'IMG',
			'set_featured_image'         => 'Установить IMG',
			'remove_featured_image'      => 'Удалить IMG',
			'use_featured_image'         => 'Использовать IMG',
			'filter_items_list'          => 'Фильтр списка услуг',
			'items_list_navigation'      => 'Навигация по списку услуг',
			'items_list'                 => 'Список услуг',
			'item_published'             => 'Услуга опубликована.',
			'item_published_privately'   => 'Услуга опубликована в частном порядке.',
			'item_reverted_to_draft'     => 'Услуга вернулась к черновику.',
			'item_scheduled'             => 'Услуга запланирована.',
			'item_updated'               => 'Услуга обновлена.',
		),
		'public'        => true,
		'menu_position' => 100,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-category',
		'rewrite'       => array( 'slug' => 'services', 'with_front' => false ),
		'supports'      => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'trackbacks',
			'custom-fields',
			'comments',
			'revisions',
			'page-attributes',
			'post-formats'
		),
		'query_var'     => true,
		'show_in_rest'  => true,
	));

	// cpt_services_cat
	register_taxonomy( 'cpt_services_cat', array( 'cpt_services' ), array(
		'labels'        => array(
			'name'                       => 'Категории услуг',
			'singular_name'              => '', // Remove "Услуга" from H1
			'menu_name'                  => 'Категории услуг',
			'search_items'               => 'Поиск категории',
			'all_items'                  => 'Все категории',
			'parent_item'                => 'Родительская категория',
			'parent_item_colon'          => 'Родительская категория:',
			'edit_item'                  => 'Редактировать категорию',
			'view_item'                  => 'Показать категорию',
			'update_item'                => 'Обновить категорию',
			'add_new_item'               => 'Добавить новую категорию',
			'new_item_name'              => 'Название новой категории',
			'not_found'                  => 'Категорий не найдено.',
			'no_terms'                   => 'Нет категорий',
			'items_list_navigation'      => 'Навигация по списку категорий',
			'items_list'                 => 'Список категорий',
			'most_used'                  => 'Часто используемые',
			'back_to_items'              => '&larr; Вернуться к категориям',
		),
		'public'        => true,
		'hierarchical'  => true,
		'rewrite'       => array( 'slug' => 'services', 'hierarchical' => true, 'with_front' => false ),
		'query_var'     => true,
		'show_in_rest'  => true,
	));

	// cpt_services_tag
	register_taxonomy( 'cpt_services_tag', array( 'cpt_services' ), array(
		'labels'        => array(
			'name'                       => 'Теги услуг',
			'singular_name'              => '', // Remove "Тег" from H1
			'menu_name'                  => 'Теги услуг',
			'search_items'               => 'Поиск тегов',
			'popular_items'              => 'Популярные теги',
			'all_items'                  => 'Все теги',
			'edit_item'                  => 'Редактировать тег',
			'view_item'                  => 'Показать тег',
			'update_item'                => 'Обновить тег',
			'add_new_item'               => 'Добавить новый тег',
			'new_item_name'              => 'Название нового тега',
			'separate_items_with_commas' => 'Раделяйте теги запятыми',
			'add_or_remove_items'        => 'Добавить или удалить теги',
			'choose_from_most_used'      => 'Выберите из наиболее часто используемых тегов',
			'not_found'                  => 'Тегов не найдено.',
			'no_terms'                   => 'Нет тегов',
			'items_list_navigation'      => 'Навигация по списку тегов',
			'items_list'                 => 'Список тегов',
			'most_used'                  => 'Часто используемые',
			'back_to_items'              => '&larr; Вернуться к тегам',
		),
		'public'        => true,
		'hierarchical'  => false,
		'rewrite'       => array( 'slug' => 'services-tag', 'with_front' => false ),
		'query_var'     => true,
		'show_in_rest'  => true,
	));

	// reset_rewrite_rules
	flush_rewrite_rules();
}

//==========================================================
// permalink_services_cat()
//==========================================================

function cpt_services_cat_slug($post_id) {

	$terms = get_the_terms($post_id, 'cpt_services_cat');
	$parent = 0;
	$new_terms = [];

	for ($i = 0;$i < sizeof($terms);++$i) {
		foreach ($terms as $term) {
			if ($term->parent == $parent) {
				$parent = $term->term_id;
				$new_terms[$term->term_id] = $term->slug;
			}
		}
	}

	return implode('/', $new_terms);
}

add_filter( 'post_type_link', 'permalink_services_cat', 1, 2 );
function permalink_services_cat( $permalink, $post ) {

	if ( strpos( $permalink, 'services' ) === false) return $permalink;
	$terms = get_the_terms( $post->ID, 'cpt_services_cat' );

	if ( !is_wp_error( $terms ) && !empty( $terms ) && is_object( $terms[0] )) {
		$taxonomy_slug = get_term_parents_list( $terms[0]->term_id, 'cpt_services_cat', array(
			'separator' => '/', 'format' => 'slug', 'link' => false, 'inclusive' => true
		));
		$taxonomy_slug = cpt_services_cat_slug($post->ID);
	} else {
		$taxonomy_slug = 'sandbox';
	}

	return str_replace( 'services', 'services/' . $taxonomy_slug, $permalink );
}

//==========================================================
// rewrite_rules_services_cat()
//==========================================================

add_filter( 'generate_rewrite_rules', 'rewrite_rules_services_cat' );
function rewrite_rules_services_cat( $wp_rewrite ) {

	$rules = array();
	$taxonomies = get_terms( array(
		'taxonomy' => 'cpt_services_cat', 'hide_empty' => false
	));

	foreach ( $taxonomies as $taxonomy ) {
		$taxonomy_slug = get_term_parents_list( $taxonomy->term_id, 'cpt_services_cat', array(
			'separator' => '/', 'format' => 'slug', 'link' => false, 'inclusive' => true
		));
		$rules[ '^services/' . $taxonomy_slug . '?$' ] = 'index.php?' . $taxonomy->taxonomy . '=' . $taxonomy->slug;
	}

	$rules[ '^services/([^/]*)/?$' ] = 'index.php?cpt_services_cat=$matches[1]';
	$rules[ '^services/(.+?)/page/?([0-9]{1,})/?$' ] = 'index.php?cpt_services_cat=$matches[1]&paged=$matches[2]';
	$rules[ '^services/(.+?)/([^/]*)/?$' ] = 'index.php?cpt_services=$matches[2]';
	$wp_rewrite->rules = $rules + $wp_rewrite->rules;
}

// //==========================================================
// // blocksy template
// //==========================================================

// // breadcrumbs_services()
// add_filter( 'blocksy:breadcrumbs:items-array', 'breadcrumbs_services' );
// function breadcrumbs_services( $items ) {

// 	if ( get_post_type() === 'cpt_services') {
// 		$items = array_merge(
// 			array_slice( $items, 0, 1 ), [[ 'name' => 'Услуги', 'url'  => home_url('/services') ]],
// 			array_slice( $items, 1 )
// 		);
// 	}

// 	return $items;
// }

// // breadcrumbs_services_cat()
// add_filter( 'blocksy:breadcrumbs:items-array', 'breadcrumbs_services_cat' );
// function breadcrumbs_services_cat( $items ) {

// 	if ( count( $items ) < 3 || ! isset( $items[2][ 'cpt_services_cat' ] )) {
// 		return $items;
// 	}

// 	if ( $items[2][ 'cpt_services_cat' ] !== 'sss' ) {
// 		return $items;
// 	}

// 	$items[2][ 'name' ] = __( 'Custom Label', 'blocksy' );
// 	return $items;
// }


//======================================================================
// reset_rewrite_rules()
//======================================================================

// cpt_services_cat
add_action( 'created_cpt_services_cat', 'reset_rewrite_rules' );
add_action( 'delete_cpt_services_cat',  'reset_rewrite_rules' );
add_action( 'edited_cpt_services_cat',  'reset_rewrite_rules' );
add_action( 'created_cpt_services_tag', 'reset_rewrite_rules' );
add_action( 'delete_cpt_services_tag',  'reset_rewrite_rules' );
add_action( 'edited_cpt_services_tag',  'reset_rewrite_rules' );

function reset_rewrite_rules() {
	flush_rewrite_rules();
}