<?php 

while ( $args->have_posts() ) : $args->the_post();
$bookThumbnail = get_field('book_thumbnail'); 

?>
	<div class="book">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        	<figure>
        		<div class="image">
        			<div class="image-color-overlay"></div>
        			<?php if ($bookThumbnail): ?>
		        		<img 
		        			src="<?php echo $bookThumbnail['url']; ?>" 
		        			alt="<?php the_title(); ?>"
		        		/>
		        	<?php else : ?>
		        		<img 
		        			class="image-placeholder"
		        			src="<?php echo esc_url(get_stylesheet_directory_uri().'/images/image-placeholder.png'); ?>" 
		        			alt="<?php the_title(); ?> missing."
		        		/>
		        	<?php endif;  ?>
	        	</div>
        		<figcaption>
        			<div class="caption">
        				<h2><?php the_title(); ?></h2>
        			</div>
        		</figcaption>
        	</figure>
        </a>
    </div>
<?php endwhile; ?>