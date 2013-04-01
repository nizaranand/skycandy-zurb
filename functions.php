<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'tiny', 50, 50, TRUE );
		add_image_size( 'pod', 100, 120, TRUE );
		add_image_size( 'slide', 720, 250, TRUE );
	}	
	register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ======================================================================================================================== 
	
	Custom Post Types - include custom post types and taxonimies here
	
	======================================================================================================================== */

	require_once( 'custom-post-types/promos.php' );
	require_once( 'custom-post-types/classes.php' );
	require_once( 'custom-post-types/people.php' );
	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );

        wp_register_script( 'slideshow', get_template_directory_uri().'/js/vendor/bjqs-1.3.min.js', array(), 1, TRUE );
	}	

	function skycandy_zurb_enqueue_script() {
		wp_enqueue_script( 'slideshow', get_template_directory_uri().'/js/vendor/bjqs-1.3.min.js', array(), 1, TRUE );
		wp_enqueue_script( 'skycandy', get_template_directory_uri().'/js/skycandy.js', array(), 1, TRUE );
		wp_enqueue_style( 'bjqs', get_template_directory_uri().'/css/bjqs');
	}
	add_action( 'wp_enqueue_scripts', 'skycandy_zurb_enqueue_script' );

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}

	/* ========================================================================================================================
	
	Widgets
	
	======================================================================================================================== */

	require_once( 'parts/widgets.php' );

	/**
	 * Function to remove automatically loaded jQuery.
	 *
	 * @return void
	 * @author Keir Whitaker
	 */	
	function removejQuery() {
		if( !is_admin()){
			wp_deregister_script('jquery');
		}	
	}
	removejQuery();
	
	/**
	 * Register our sidebars and widgetized areas.
	 *
	 */
	
	function theH1() {
		?>
		<div class="large-3 columns">
			<h1><a href="<?php echo home_url(); ?>">
					<img src="<?php bloginfo('template_url'); ?>/images/logo-stacked.png" alt="<?php bloginfo( 'name' ); ?>" />
				</a>
			</h1>
		</div>
		<?php
	}

	function get_homepage_slideshow() {
		wp_enqueue_script( 'slideshow' );
		$slides = array();
		$i = 0;
		$args = array(
			'post_type' => 'promo',
		);
		$promos = new WP_Query( $args );
		if( $promos->have_posts() ) {
			while( $promos->have_posts() ) {
				$promos->the_post();
				$slides[$i]['title'] = get_the_title();
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($promos->post->ID), 'slide');
				$slides[$i]['image'] = $thumbnail[0];
				$url = get_post_meta( $promos->post->ID, 'promo_url', true );
				if($url == '') {
					$slides[$i]['url'] = get_permalink($promos->post->ID);
				} else {
					$slides[$i]['url'] = $url;
				}
				$i++;
			}
		//wp_reset_postdata();
		}
		else {
			echo 'Oh ohm no promos!';
		}
		switch($promos->post_count) {
			case 1:
				$rows = 12;
				break;
			case 2: 
				$rows = 6;
				break;
			case 3:
				$rows = 4;
				break;
			case 4:
				$rows = 3;
				break;			
		}
		
		foreach($slides as $slide) {
			?>
			<li><a href="<?php echo $slide['url']; ?>"><img src="<?php echo $slide['image']; ?>" title="<?php echo $slide['title']; ?>"></a></li>
			<?php
		}
	}	
	
	function get_home_page_posts() {
		add_filter('post_limits', 'post_query_limit_sidebar');
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish'
		);
		$posts = new WP_Query( $args );
		if( $posts->have_posts() ) {
			while( $posts->have_posts() ) {
				$posts->the_post();
				$url = get_permalink($posts->post->ID);
				$title = $posts->post->post_title;
				if($thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($posts->post->ID), 'tiny')) {
					$image = $thumbnail[0];
				} else {
					$image = get_bloginfo('template_url') . '/images/skycandy-default.jpg';
				}
				?>
				<li><img src="<?php echo $image; ?>"/><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
			<?php	
			}		
		}
		remove_filter('post_limits', 'post_query_limit');
	}
	
	function post_query_limit_sidebar($limit) {
		return 'LIMIT 4';
	}
