<?php
/**
 * Functions and definitions
 */

if ( ! function_exists( 'seismicnyc_setup' ) ):

function seismicnyc_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 650;
	
	load_theme_textdomain( 'seismic-manhattan', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
		
	/**
	 * Let WP handle the title tag
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'seismic-manhattan' ),
	) );

	/**
	 * This theme allows users to set a custom background.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => '333333',
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
}
endif; // seismicnyc_setup

/**
 * Tell WordPress to run seismicnyc_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'seismicnyc_setup' );

/**
 * Tell WordPress to add a customizable header image.
 */
function seismicnyc_custom_header_function() {
	/**
	 * This theme allows users to set a custom header image.
	 */
	$args = array(
		'width'         => 690,
		'height'        => 350,
		'default-image' => get_template_directory_uri() . '/imgs/header/brooklyn-bridge.jpg',
		'default-text-color' => 'fff',
		'header-text' => true,
		'uploads' => true,
		'wp-head-callback' => 'seismicnyc_custom_header_image',
		'admin-head-callback' => 'seismicnyc_admin_header_style',
	);
	add_theme_support( 'custom-header', $args );

	/*
	 * Default custom headers packaged with the theme.
	 */
	register_default_headers( array(
		'brooklyn-bridge' => array(
			'url'           => '%s/imgs/header/brooklyn-bridge.jpg',
			'thumbnail_url' => '%s/imgs/header/brooklyn-bridge-thumbnail.jpg',
			'description'   => _x( 'Brooklyn Bridge', 'header image description', 'seismic-manhattan' )
		),
		'times-square' => array(
			'url'           => '%s/imgs/header/times-square.jpg',
			'thumbnail_url' => '%s/imgs/header/times-square-thumbnail.jpg',
			'description'   => _x( 'Times Square', 'header image description', 'seismic-manhattan' )
		),
	) );
}
add_action( 'after_setup_theme', 'seismicnyc_custom_header_function' );

/**
 * Tell WordPress to customize the page title.
 */
function seismicnyc_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'seismic-manhattan' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'seismicnyc_wp_title', 10, 2 );

/**
 * Style the WordPress admin section header.
 */
if ( ! function_exists( 'seismicnyc_admin_header_style' ) ) :

function seismicnyc_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	background: #e4e4e4;
}
#headimg #name {
	color: #fff;
	font-size: 35px;
	font-weight: 100;
	padding: 15px 0 0 13px;
	text-decoration: none;
	text-shadow: 2px 2px 2px #333;
}
#headimg #desc {
	color: #fff;
	font-size: 12px;
	font-weight: normal;
	margin: -10px 0 0 33px;
	padding-bottom: 21px;
	text-shadow: 1px 1px 1px #333;
}
</style>
<?php
}
endif;

/**
 * Tell WordPress to add a custom header image.
 */
function seismicnyc_custom_header_image() { ?>
	<style type="text/css">
		<?php if ( get_header_image() != '' ) { ?>
		#branding {
			background: #e4e4e4 url("<?php header_image(); ?>") no-repeat; 
			height: 350px;
			width: 690px;
		}
		<?php } 
		if ( (get_header_textcolor() != 'fff') || (get_header_textcolor() != 'ffffff') ) { ?>
		#site-title,
		#site-title a,
		#site-title a:hover,
		#site-description {
			color: #<?php header_textcolor(); ?>;
		}
		<?php } ?>
	</style>
<?php
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function seismicnyc_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'seismicnyc_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function seismicnyc_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'seismic-manhattan' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'seismicnyc_widgets_init' );

if ( ! function_exists( 'seismicnyc_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function seismicnyc_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'seismic-manhattan' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'seismic-manhattan' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'seismic-manhattan' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'seismic-manhattan' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'seismic-manhattan' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // seismicnyc_content_nav


if ( ! function_exists( 'seismicnyc_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function seismicnyc_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'seismic-manhattan' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'seismic-manhattan' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'seismic-manhattan' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'seismic-manhattan' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'seismic-manhattan' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'seismic-manhattan' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for seismicnyc_comment()

if ( ! function_exists( 'seismicnyc_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function seismicnyc_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'seismic-manhattan' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'seismic-manhattan' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function seismicnyc_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so seismicnyc_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so seismicnyc_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in seismicnyc_categorized_blog
 */
function seismicnyc_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'seismicnyc_category_transient_flusher' );
add_action( 'save_post', 'seismicnyc_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function seismicnyc_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'seismicnyc_enhanced_image_navigation' );

/**
 * Tell WordPress to add our stylesheets to the head.
 */
function seismicnyc_theme_scripts() {
	wp_enqueue_style('normalize', get_stylesheet_directory_uri().'/css/normalize.css', false, '2.0.1');
	wp_enqueue_style('seismicnyc-style', get_bloginfo('stylesheet_url'), false, '0.1');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'seismicnyc_theme_scripts');