<?php /* Template Name: Books Template */ ?>
<?php
	wp_enqueue_script('overlay-cursor', get_template_directory_uri().'/js/overlay-cursor.js', array('jquery'), '1.0', false );
	get_header();
?>

<div id="content-area" role="main">
	<!-- <h1>Books</h1> -->
	<?php
		$args = array(
		    'post_type' => 'book',
		    'posts_per_page' => 9,
		    'order' => 'ASC'
		);
		$the_query = new WP_Query( $args ); 
	?>
	<?php if ( $the_query->have_posts() ) : ?>
		<div class="books">
		    <?php 
		    	while ( $the_query->have_posts() ) : $the_query->the_post(); 
		    ?>
		    	<?php $bookThumbnail = get_field('book_thumbnail'); ?>
		    	<div class="book">
			    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			        	<figure>
			        		<div class="image">
				        		<img 
				        			src="<?php echo $bookThumbnail['url']; ?>" 
				        			alt="<?php the_title(); ?>" 
				        			style="width: 180px; height: 180px" 
				        		/>
				        	</div>
			        		<figcaption><?php the_title(); ?></figcaption>
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