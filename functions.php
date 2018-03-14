<?php
/**
 * Siuy Child functions and definitions
 *
 * For more information on hooks, actions, and filters,
 *
 * @see 		https://codex.wordpress.org/Theme_Development
 * @see 		https://codex.wordpress.org/Child_Themes
 * @see 		https://codex.wordpress.org/Plugin_API
 * @author  	Mahdi Yazdani
 * @package 	Siuy Child
 * @since 		1.0.0
 */
if (!defined('ABSPATH')):
	exit;
endif;
if (!class_exists('Siuy_Child')):
	/**
	 * The setup Siuy Child class
	 */
	class Siuy_Child

	{
		private $parent_public_assets_url;
		private $child_public_assets_url;
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct()

		{
			$this->parent_public_assets_url = esc_url(get_template_directory_uri() . '/assets/');
			$this->child_public_assets_url = esc_url(get_stylesheet_directory_uri() . '/assets/');
			add_action('after_setup_theme', array(
				$this,
				'setup'
			) , 10);
			add_action('wp_enqueue_scripts', array(
				$this,
				'enqueue'
			) , 10);
			add_action('wp_enqueue_scripts', array(
				$this,
				'enqueue_child'
			) , 99);
		}
		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0.0
		 */
		public function setup()

		{
			/**
			 *  This theme styles the visual editor to resemble the theme style,
			 *  specifically font, colors, icons, and column width.
			 */
			add_editor_style(array(
				get_stylesheet_directory_uri() . '/assets/css/editor-style.css',
				add_query_arg(apply_filters('siuy_default_font_family', array(
					'family' => urlencode('Lato:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i') ,
					'subset' => urlencode('latin,latin-ext')
				)) , 'https://fonts.googleapis.com/css')
			));
		}
		/**
		 * Enqueue scripts and styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue()

		{
			wp_enqueue_style('siuy-styles', $this->parent_public_assets_url . '/css/siuy.css', SIUY_THEME_VERSION);
			if (is_rtl()):
				wp_enqueue_style('siuy-rtl-styles', get_template_directory_uri() . '/rtl.css', SIUY_THEME_VERSION);
			endif;
		}
		/**
		 * Enqueue scripts and styles.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_child()

		{
			wp_enqueue_style('siuy-child-styles', $this->child_public_assets_url . '/css/siuy-child.css', SIUY_THEME_VERSION);
			wp_enqueue_script('siuy-child-scripts', $this->child_public_assets_url . '/js/siuy-child.js', array(
				'jquery',
				'siuy-scripts'
			) , SIUY_THEME_VERSION, true);
		}
	}
endif;
return new Siuy_Child();
