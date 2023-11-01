<?php /* Template Name: Books Template */ ?>
<?php
	wp_enqueue_script('overlay-cursor', get_template_directory_uri().'/js/overlay-cursor.js', array('jquery'), '1.0', false );
	get_header();
?>

<div id="content-area" role="main">
	<?php
		$args = array(
		    'post_type' => 'book',
		    'posts_per_page' => 12,
		    'order' => 'ASC'
		);
		$the_query = new WP_Query( $args ); 
		if ( $the_query->have_posts() ) : 
	?>
		<div class="books">
		    <?php 
		    	while ( $the_query->have_posts() ) : $the_query->the_post();
		    	$bookThumbnail = get_field('book_thumbnail'); 
		    ?>
		    	<div class="book">
			    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			        	<figure>
			        		<div class="image">
			        			<div class="image-color-overlay"></div>
				        		<img 
				        			src="<?php echo $bookThumbnail['url']; ?>" 
				        			alt="<?php the_title(); ?>"
				        		/>
				        	</div>
			        		<figcaption>
			        			<div class="caption"><!-- extra div in case to mimic portfolio page (potential legacy css) -->
			        				<h2><?php the_title(); ?></h2>
			        			</div>
			        		</figcaption>
			        	</figure>
			        </a>
			    </div>
		    <?php endwhile; ?>
		</div>

	    <?php wp_reset_postdata(); ?>

	<?php endif; ?>
</div>


<!--//end content area-->
<?php get_footer(); ?>