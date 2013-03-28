<?php
function skycandy_register_sidebars() {
	$args = array(
		'name' => 'Home Page Pods',
		'id' => 'home_page_pods',
		'before_widget' => '<div class="columns large-6">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	);
	register_sidebar($args);
}


function register_post_widget() {  
    register_widget( 'SK_Posts_Widget' );  
} 

class SK_Posts_Widget extends WP_Widget {

	function SK_Posts_Widget() {
		$widget_ops = array( 'classname' => 'home_page_pod', 'description' => __('Home Page Posts', 'sk-posts') );
		
		$control_ops = array( 'width' => 350, 'height' => 350, 'id_base' => 'sk-posts' );
		
		$this->WP_Widget( 'sk-posts', __('Home Page Posts', 'sk-posts'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$cta = $instance['cta'];
		$post_id = $instance['select_post'];
		$post = get_post( $post_id, 'OBJECT' );
		$url = get_permalink($post_id);

		if($thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'pod')) {
			$image = $thumbnail[0];
		} else {
			$image = get_bloginfo('template_url') . '/images/skycandy-pod.png';
		}
		?>
		<div class="columns large-6">
			<img src="<?php echo $image; ?>" alt="<?php echo $post->post_title; ?>" />
			<h2><?php echo $post->post_title; ?></h2>
			
			<?php if(strlen($post->post_excerpt) > 1){
				?>
				<p class="excerpt"><?php echo $post->post_excerpt; ?></p>
				<?php
			}
			?>
			<p class="cta"><a href="<?php echo $url; ?>"><?php echo $cta; ?></a></p>
		<?php
		echo $after_widget;
		
		
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['select_post'] = $new_instance['select_post'];
		$instance['cta'] = strip_tags( $new_instance['cta'] );

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'show_info' => true, 'post_id' => 0 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>Choose the blog post to appear in this home page pod.</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'select_post' ); ?>"><?php _e('Select post to display:', 'sk-posts'); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'select_post' ); ?>" name="<?php echo $this->get_field_name( 'select_post' ); ?>">
				<?php $this->get_posts_options($instance['select_post']); ?>
			</select>
			
		<p>
			<label for="<?php echo $this->get_field_id( 'cta' ); ?>"><?php _e('Call To Action:', 'sk-posts'); ?></label>
			<input id="<?php echo $this->get_field_id( 'cta' ); ?>" name="<?php echo $this->get_field_name( 'cta' ); ?>" value="<?php echo $instance['cta']; ?>" style="width:94%;" />
		</p>
		
	<?php
	}
	
	function get_posts_options($selected) {
		// The Query
		echo '<option value="0">Please Select a Post</option>';
		$args = array(
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'post',
			'posts_per_page' => -1,
		);
		$query = new WP_Query( $args );

		// The Loop
		while ( $query->have_posts() ) :
			$query->the_post();
			//var_dump($query->post);
			echo '<option value="'. $query->post->ID .'"';
			if($query->post->ID == $selected) {
				echo ' selected="selected" ';
			}
			echo '>' . get_the_title() . '</option>';
		endwhile;
	}
}

add_action( 'widgets_init', 'skycandy_register_sidebars' );
add_action( 'widgets_init', 'register_post_widget' );	
?>