<?php
/**
 * Onyx functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Onyx
 */

if ( ! function_exists( 'onyx_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function onyx_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Onyx, use a find and replace
		 * to change 'onyx' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'onyx', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        // Register Custom Navigation Walker
        require_once get_template_directory() . '/lib/navwalker/class-wp-bootstrap-navwalker.php';
        
        
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'onyx' ),
            'secondary' => esc_html__( 'Secondary', 'onyx' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'onyx_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
        
        // Add support for custom header.
        add_theme_support( 'custom-header' );
        
        // Add support for page excerpts.
        add_post_type_support( 'page', 'excerpt' );
	}
endif;
add_action( 'after_setup_theme', 'onyx_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function onyx_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'onyx_content_width', 640 );
}
add_action( 'after_setup_theme', 'onyx_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function onyx_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'onyx' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'onyx' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s col-md-3">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );
    
}
add_action( 'widgets_init', 'onyx_widgets_init' );

/**
 * Create widget showing posts from news category
 * 4 methods: construct, widget, form, update
 */

class News_Category extends WP_Widget {

	// create new isntance for news category posts
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'news_entries',
			'description'                 => __( 'Your site&#8217;s news Posts.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'news-posts', __( 'News Posts' ), $widget_ops );
		$this->alt_option_name = 'news_entries';
	}

	// output content for the widget
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'News Posts' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page'      => $number,
                    'category_name' => 'news',
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				),
				$instance
			)
		);

		if ( ! $r->have_posts() ) {
			return;
		}
		 echo $args['before_widget']; 
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
<ul>
    <?php foreach ( $r->posts as $recent_post ) : ?>
    <?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				?>
    <li>
        <a href="<?php the_permalink( $recent_post->ID ); ?>">
            <?php echo $title; ?></a>
        <?php if ( $show_date ) : ?>
        <span class="post-date">
            <?php echo get_the_date( '', $recent_post->ID ); ?></span>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>
<?php
		echo $args['after_widget'];
	}

	// handles widget form settings
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	// output form settings on widgets menu
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">
        <?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">
        <?php _e( 'Number of posts to show:' ); ?></label>
    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="
    <?php echo $this->get_field_id( 'show_date' ); ?>" name="
    <?php echo $this->get_field_name( 'show_date' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_date' ); ?>">
        <?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}

/**
 * create social media widget
 */
class Social_Media extends WP_Widget {

/**
* Register widget with WordPress.
*/
public function __construct() {
$widget_ops = array(
			'classname'                   => 'social_media',
			'description'                 => __( 'Your Social Media links.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'social-media', __( 'Social Media' ), $widget_ops );
		$this->alt_option_name = 'social_media';
}

/**
* Front-end display of widget.
*/
public function widget($args, $instance) {

    if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Social Media' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
    
$facebook = $instance['facebook'];
$twitter = $instance['twitter'];
$linkedin = $instance['linkedin'];
$rss = $instance['rss'];

// social media link
$facebook_link = '<a target="_blank" class=" social_link" id="facebook" href="' . $facebook . '">
<img id="facebook-logo">
<span>Facebook</span></a>';
$twitter_link = '<a target="_blank" class=" social_link" id="twitter" href="' . $twitter . '"><img id="twitter-logo"><span>Twitter</span></a>';
$linkedin_link = '<a target="_blank" class=" social_link" id="linkedin" href="' . $linkedin . '"><img id="linkedin-logo"><span>LinkedIn</span></a>';
$rss_link = '<a target="_blank" class=" social_link" id= "rss" href="' . $rss . '"><img id="rss-logo"><span>RSS</span></a>';

echo $args['before_widget'];

if ( $title ) {
echo $args['before_title'] . $title . $args['after_title'];
}
    ?>

<div class="social-media">
    <ul class=" social-media-list list-unstyled">
        <li>
            <?php echo (!empty($facebook) ) ? $facebook_link : ''; ?>
        </li>
        <li>
            <?php echo (!empty($twitter) ) ? $twitter_link : '';?>
        </li>
        <li>
            <?php echo (!empty($linkedin) ) ? $linkedin_link : ''; ?>
        </li>
        <li>
            <?php echo (!empty($rss) ) ? $rss_link : ''; ?>
        </li>

    </ul>
</div>

<?php
echo $args['after_widget'];
}

/**
* Back-end widget form.

*/
    
     public function update($new_instance, $old_instance) {
        $instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
        $instance['facebook']     = sanitize_text_field( $new_instance['facebook'] );
        $instance['twitter']     = sanitize_text_field( $new_instance['twitter'] );
        $instance['linkedin']     = sanitize_text_field( $new_instance['linkedin'] );
        $instance['rss']     = sanitize_text_field( $new_instance['rss'] );

        return $instance;
    }
    
public function form($instance) {
$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

    $facebook     = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
    $twitter     = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
    $linkedin     = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
    $rss     = isset( $instance['rss'] ) ? esc_attr( $instance['rss'] ) : '';

?>

<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">
        <?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo ($title); ?>">
</p>

<p>
    <label for="<?php echo $this->get_field_id('facebook'); ?>">
        <?php _e('Facebook:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="url" value="<?php echo ($facebook); ?>">
</p>

<p>
    <label for="<?php echo $this->get_field_id('twitter'); ?>">
        <?php _e('Twitter:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="url" value="<?php echo ($twitter); ?>">
</p>

<p>
    <label for="<?php echo $this->get_field_id('linkedin'); ?>">
        <?php _e('LinkedIn:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="url" value="<?php echo esc_attr($linkedin); ?>">
</p>

<p>
    <label for="<?php echo $this->get_field_id('rss'); ?>">
        <?php _e('RSS:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="url" value="<?php echo esc_attr($rss); ?>">
</p>

<?php
    }

}

// Register widget for posts from news category
function onyx_news_load() {
    register_widget('News_Category');
    register_widget('Social_Media');
}

add_action('widgets_init', 'onyx_news_load');

/**
 * Enqueue scripts and styles.
 */
function onyx_scripts() {
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/js/bootstrap.js', array( 'jquery' ), '4.3.1', true );
    
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/lib/css/bootstrap.css', array(), '4.3.1' );
     
	wp_enqueue_style( 'onyx-style', get_stylesheet_uri() );

	wp_enqueue_script( 'onyx-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'onyx-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
    
    wp_enqueue_script( 'onyx.js', get_template_directory_uri() . '/js/onyx.js', array(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'onyx_scripts' );

/*
 * Custom Post Type for slider
 */
function onyx_custom_slider() {
   // Labels for custom post type slider
	$slider_labels = array(
		'name' => _x('Slides', 'post type general name'),
		'singular_name' => _x('Slide', 'post type singular name'),
		'menu_name' => 'CPT Slider',
		'add_new' => _x('Add New', 'Slider'),
		'add_new_item' => __('Add New Slide'),
		'edit_item' => __('Edit Slide'),
		'new_item' => __('New Slide'),
		'view_item' => __('View Slide'),
		'search_items' => __('Search Slides'),
		'not_found' =>  __('No Slides Found'),
		'not_found_in_trash' => __('No Slides Found in Trash'),
		'parent_item_colon' => __('Parent Slide')
	);
	
	// Register post type
	register_post_type('custom-slides' , array(
		'labels' => $slider_labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail','excerpt')
	) );
}
add_action( 'init', 'onyx_custom_slider', 0 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
