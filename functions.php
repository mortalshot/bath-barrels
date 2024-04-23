<?php

/**
 * bath-barrels functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bath-barrels
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('bb_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bb_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bath-barrels, use a find and replace
		 * to change 'bb' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('bb', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header' => esc_html__('Header menu', 'bb'),
				'lang' => esc_html__('Language menu', 'bb'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
	}
endif;
add_action('after_setup_theme', 'bb_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bb_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bb_content_width', 640);
}
add_action('after_setup_theme', 'bb_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function bb_scripts()
{
	wp_enqueue_style('bb-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('bb-stylesheet', get_template_directory_uri() . '/dist/css/style.min.css', array(), _S_VERSION);

	wp_enqueue_script('bb-custom-js', get_template_directory_uri() . '/dist/js/app.min.js', '', _S_VERSION, true);

	wp_localize_script('bb-custom-js', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'bb_scripts');

// Выводим настройки в меню админки
if (function_exists('acf_add_options_page')) {
	// Main Theme Settings Page
	$parent = acf_add_options_page(array(
		'page_title' => 'Настройки темы',
		'menu_title' => 'Настройки темы',
		'redirect'   => 'Настройки темы',
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Настройки темы',
		'menu_title' => 'Настройки темы',
		'menu_slug'  => "acf-options",
		'parent'     => $parent['menu_slug']
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Повторяющиеся блоки',
		'menu_title' => 'Повторяющиеся блоки',
		'parent'     => $parent['menu_slug']
	));
}

// Изменяем стартовую высоту textarea в advanced custom field
function PREFIX_apply_acf_modifications()
{
?>
	<style>
		.acf-editor-wrap iframe {
			min-height: 0;
		}
	</style>
	<script>
		(function($) {
			// (filter called before the tinyMCE instance is created)
			acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
				// enable autoresizing of the WYSIWYG editor
				mceInit.wp_autoresize_on = true;
				return mceInit;
			});
			// (action called when a WYSIWYG tinymce element has been initialized)
			acf.add_action('wysiwyg_tinymce_init', function(ed, id, mceInit, $field) {
				// reduce tinymce's min-height settings
				ed.settings.autoresize_min_height = 130;
				// reduce iframe's 'height' style to match tinymce settings
				$('.acf-editor-wrap iframe').css('height', '130px');
			});
		})(jQuery)
	</script>
<?php
}
add_action('acf/input/admin_footer', 'PREFIX_apply_acf_modifications');

// Отключение Emoji в WordPress
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

// Удаление стилей и скриптов wordpress по умолчанию
function wpassist_remove_block_library_css()
{
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('font-awesome');
	wp_dequeue_style('yith-wcwl-main');

	wp_dequeue_script('prettyPhoto');
	wp_dequeue_script('prettyPhoto-init');
}
add_action('wp_enqueue_scripts', 'wpassist_remove_block_library_css');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

function agentwp_dequeue_stylesandscripts()
{
	if (class_exists('woocommerce')) {
		wp_dequeue_style('selectWoo');
		wp_deregister_style('selectWoo');

		wp_dequeue_script('selectWoo');
		wp_deregister_script('selectWoo');

		wp_dequeue_script('wc-country-select');
	}
}

// Удаляем <p> и <br/> из Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

/* Меняем у excerpt '[...]' на '...' */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more)
{
	global $post;
	return '...';
}

// Удаляем аттрибут role и тэг h2 
function sanitize_pagination($content)
{
	$content = str_replace('navigation', '', $content);
	$content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

	return $content;
}
add_action('navigation_markup_template', 'sanitize_pagination');

// Добавляем свой тип записи
add_action('init', 'register_post_types');
function register_post_types()
{
	register_post_type('products', [
		'label'  => null,
		'labels' => [
			'name'               => 'Товары', // основное название для типа записи
			'singular_name'      => 'Товар', // название для одной записи этого типа
			'add_new'            => 'Добавить новый товар', // для добавления новой записи
			'add_new_item'       => 'Добавить новый товар', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать товар', // для редактирования типа записи
			'new_item'           => 'Новый товар', // текст новой записи
			'view_item'          => 'Просмотр товара', // для просмотра записи этого типа.
			'search_items'       => 'Искать товар', // для поиска по этим типам записи
			'not_found'          => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Ничего не найдено', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Товары', // название меню
		],
		'description'         => 'Товары',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 3,
		'menu_icon'           => 'dashicons-cart',
		'hierarchical'        => true,
		'show_in_rest'		  => true,
		'supports'            => ['title', 'custom-fields'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['category',],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}
// Добавляем таксономии для своего типа записей
add_action('init', 'create_taxonomy');
function create_taxonomy()
{
	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy('category', ['products'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Категории',
			'singular_name'     => 'Категория',
			'search_items'      => 'Искать категорию',
			'all_items'         => 'Все категории',
			'view_item '        => 'Просмотр категории',
			'parent_item'       => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить новую',
			'new_item_name'     => 'Новая категория',
			'menu_name'         => 'Категории',
		],
		'description'           => 'Категории', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_menu'          => true, // равен аргументу show_ui
		'show_tagcloud'         => true, // равен аргументу show_ui
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'show_admin_column'		=> true,
		'show_in_rest'			=> true,
		'hierarchical'          => false,
		'rewrite'               => true,
	]);
}

// Функция для изменения "posts" на "Опции товара" в боковом меню администратора.
function change_post_menu_label()
{
	global $menu;
	global $submenu;
	$menu[5][0] = 'Опции товара';
	$submenu['edit.php'][5][0] = 'Опции товара';
	$submenu['edit.php'][10][0] = 'Добавить опцию';
	$submenu['edit.php'][16][0] = 'Группа опций';
	echo '';
}
add_action('admin_menu', 'change_post_menu_label');
function change_post_object_label()
{
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Новая опция';
	$labels->singular_name = 'Опция';
	$labels->add_new = 'Добавить новую';
	$labels->add_new_item = 'Добавить новую';
	$labels->edit_item = 'Редактировать';
	$labels->new_item = 'Новая опция';
	$labels->view_item = 'Смотреть';
	$labels->search_items = 'Искать опцию';
	$labels->not_found = 'Ничего не найдено';
	$labels->not_found_in_trash = 'Ничего не найдено';

	remove_post_type_support('post', 'editor');
	remove_post_type_support('post', 'excerpt');
	remove_post_type_support('post', 'comments');
	remove_post_type_support('post', 'thumbnail');
	remove_post_type_support('post', 'author');
	remove_post_type_support('post', 'trackbacks');
}
add_action('init', 'change_post_object_label');

// AJAX фильтр
add_action( 'wp_ajax_getpost', 'flex_get_posts' );
add_action( 'wp_ajax_nopriv_getpost', 'flex_get_posts' );

function flex_get_posts(){
	if (!empty($_POST['taxonomy'])) {
		$args = array(
			'post_type' => $_POST[ 'post_type' ],
			'posts_per_page' => -1, //posts per one load
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $_POST['taxonomy']
				)
			),
			'meta_key'  => 'product-price',
			'orderby' => 'meta_value_num',
			'order'	=> !empty($_POST['order']) ? $_POST['order'] : 'ASC',
			'paged' => $_POST['page'],
		);
	} else {
		$args = array(
			'post_type' => $_POST['post_type'],
			'posts_per_page' => -1, //posts per one load
			'meta_key'  => 'product-price',
			'orderby' => 'meta_value_num',
			'order'	=> !empty($_POST['order']) ? $_POST['order'] : 'ASC',
			'paged' => $_POST['page'],
		);
	}

	query_posts( $args );

	if (have_posts()) :
		while (have_posts()) :
			the_post();

			$id = get_the_ID();
			$galleryProduct = get_field('gallery-product', $id);
			$productPrice = get_field('product-price', $id);
			$terms = wp_get_post_terms($id, 'category');

			echo '<article class="main-catalog__product main-product">';
				echo '<div class="main-product__heading">';
					echo '<a href="'. get_the_permalink() .'" class="main-product__title title-h4">'. get_the_title() .'</a>';
					echo '<div class="main-product__category">'. $terms[0]->name .'</div>';
				echo '</div>';
				echo '<a href="'. get_the_permalink() .'" class="main-product__image"><img src="'. $galleryProduct[0]['url'] .'" alt="'. $galleryProduct[0]['alt'] .'" loading="lazy"></a>';
				echo '<div class="main-product__footer">';
					echo '<div class="main-product__price title-h3">'. number_format($productPrice, 0, '', ' ') .' ₽</div>';
					echo '<div class="main-product__button"><button type="button" data-popup="#request" class="btn btn_green _hover-black"><span>Заказать</span></button></div>';
				echo '</div>';
			echo '</article>';
		endwhile;
		wp_reset_query();
	endif;

	wp_die();
}