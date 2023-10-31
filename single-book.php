<?php get_header(); ?>

<div id="content-area" role="main" class="clearfix">
	<div class="content entries">
		<?php
			$args = array(
			    'post_type' => 'book',
			    'posts_per_page' => 9,
			    'order' => 'ASC'
			);
			$the_query = new WP_Query( $args ); 
			if ( $the_query->have_posts() ) : 
		?>

			<div class="entry single-book-page">
				<?php 
			    	// Use the traditional Wordpress way to display the post details and additionally get some specific fields
			    	if (have_posts()) : while (have_posts()) : the_post(); 
			    	$bookTitle = get_field('book_title');
			    	$bookPublisher = get_field('book_publisher');
			    ?>
			    	<div class="single-book">
			    		<div class="book-header">
							<?php if (!empty($bookTitle)): ?>
								<h1 class="post-title"><?php echo $bookTitle; ?></h1>
							<?php endif; ?>
							<div class="book-publisher"><?php echo $bookPublisher; ?></div>
						</div>

						<?php the_content();?>
					</div>

				<?php endwhile; endif; ?>
			</div>

		<?php endif; ?>
	</div>
</div>
<!--//end content area-->

<?php get_footer(); ?>