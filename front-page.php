<?php
/**
 * The Front Page template file
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage Sky Candy	
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="row">
	<div class="columns large-9" id="home_page_slideshow">
		<ul class="bjqs">
<?php get_homepage_slideshow(); ?>
		</ul>
	</div><!--columns-->
	<div class="columns large-3 sidebar" id="home_page_blog_posts">
		<h2>Latest Blog Posts</h2>
		<ul>
			<?php get_home_page_posts(); ?>
		</ul>	
	</div>
</div><!--row-->

<div class="row">
	<div class="columns large-9">
		<div class="row pods">
			<?php dynamic_sidebar('home_page_pods'); ?> 
		</div>
	</div>
	<div class="columns large-3 sidebar">
		<h2>Class Descriptions</h2>
		<?php get_classes(); ?> 
	</div>
</div>

<div class="wrap" style="background: #333; overflow:auto">
<div class="row">
	<div class="columns large-12" id="masonry-container">
		<?php
			$query_images_args = array(
    		'post_type' => 'attachment', 
				'post_mime_type' =>'image', 
				'post_status' => 'inherit', 
				'posts_per_page' => 10,
			);

			$query_images = new WP_Query( $query_images_args );
			$images = array();
			foreach ( $query_images->posts as $image) {
				//var_dump($image);
				echo wp_get_attachment_image( $image->ID, 'masonry' );
			}
			wp_reset_query();
    	wp_reset_postdata();
		?>
		<?php wp_enqueue_script( 'masonry' ); ?>
		<style type="text/css">
			.attachment-masonry {
  			margin: 3px;
  			float: left;
			}
		</style>

	</div>
</div>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
