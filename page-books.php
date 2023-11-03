<?php /* Template Name: Books Template */ ?>
<?php
wp_enqueue_script('overlay-cursor', get_template_directory_uri().'/js/overlay-cursor.js', array('jquery'), '1.0', false );
get_header();
?>

<div id="content-area" role="main">
	<?php
	$args = array(
	    'post_type' => 'book',
	    'posts_per_page' => 6,
	    'order' => 'ASC'
	);
	$the_query = new WP_Query( $args ); 
	if ( $the_query->have_posts() ) : 
	?>

		<div id="books" class="books">
		    <?php get_template_part( 'loop', 'index', $the_query ); ?>
		</div>

	    <?php wp_reset_postdata(); ?>

	<?php endif; ?>
	
	<div id="infinite-scroll_loader">
		<svg 
			version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve"
		>
			<circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
			<animate
				attributeName="opacity"
				dur="1s"
				values="0;1;0"
				repeatCount="indefinite"
				begin="0.1"/>    
			</circle>
			<circle fill="#fff" stroke="none" cx="26" cy="50" r="6">
			<animate
				attributeName="opacity"
				dur="1s"
				values="0;1;0"
				repeatCount="indefinite" 
				begin="0.2"/>       
			</circle>
			<circle fill="#fff" stroke="none" cx="46" cy="50" r="6">
			<animate
				attributeName="opacity"
				dur="1s"
				values="0;1;0"
				repeatCount="indefinite" 
				begin="0.3"/>     
			</circle>
		</svg>
	</div>
</div>

<!--//end content area-->
<?php get_footer(); ?>