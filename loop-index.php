<?php 

while ( $args->have_posts() ) : $args->the_post();
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