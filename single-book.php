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
					$bookPublishDateFormat = get_field('book_publish_date_format');

					// strtotime to convert string to timestamp and then wp_date to format date from timestamp
					$bookPublishDate = wp_date($bookPublishDateFormat, strtotime(get_field('book_publish_date')));
			    ?>
			    	<div class="single-book">
			    		<div class="book-header">
							<?php if (!empty($bookTitle)): ?>
								<h1 class="post-title"><?php echo $bookTitle; ?></h1>
							<?php endif; ?>
							<?php
							$bookPublisher = get_field('book_publisher');
							if( $bookPublisher ):
								$link_url = $bookPublisher['url'];
							    $link_title = $bookPublisher['title'];
							    $link_target = $bookPublisher['target'] ? $bookPublisher['target'] : '_self';
							?>
								<a 
									class="publisher-link" 
									href="<?php echo esc_url( $link_url ); ?>" 
									target="<?php echo esc_attr( $link_target ); ?>"
								>
									<?php echo esc_html( $link_title ); ?>
								</a>
							<?php endif; ?>
							 - 
							<span class="book-publishing-date"><?php echo $bookPublishDate; ?></span>
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