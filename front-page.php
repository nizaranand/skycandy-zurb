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
	<div class="columns large-3" id="home_page_blog_posts">
		<h3>Latest Blog Posts</h3>
		<ul>
			<?php get_home_page_posts(); ?>
		</ul>	
	</div>
</div><!--row-->

<div class="row">
	<div class="columns large-9">
		<div class="row">
			<?php dynamic_sidebar('home_page_pods'); ?> 
		</div>
	</div>
	<div class="columns large-3">
		<h3>Class Descriptions</h3>
	</div>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>