<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme        = wp_get_theme();
	wp_enqueue_style( 
		$parenthandle,
		get_template_directory_uri() . '/style.css',
		array(),  // If the parent theme code has a dependency, copy it to here.
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 
		'style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get( 'Version' )
	);
}

// Infinite Scroll
function infinite_scroll_handler(){
    $args = isset( $_POST['query'] ) 
     	? array_map( 'esc_attr', $_POST['query'] ) // Escaping for HTML attributes
     	: array();
    $args['post_type'] = isset( $args['post_type'] ) 
    	? esc_attr( $args['post_type'] ) 
    	: 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';

	ob_start();

	$the_query = new WP_Query( $args );
	get_template_part( 'loop', 'index', $the_query );

	wp_reset_postdata(); // Restores the $post global to the current post in the main query

	$data = ob_get_clean();
	wp_send_json_success( $data ); // Sends a JSON response back to an Ajax request

	wp_die(); // Wordpress version of php die or exit function
}
add_action('wp_ajax_infinite_scroll', 'infinite_scroll_handler'); // logged in
add_action('wp_ajax_nopriv_infinite_scroll', 'infinite_scroll_handler'); // logged out

function load_more_js() {
	if( is_singular( 'book' ) )
		return;

	$query = array( 
		'post_type' => 'book',
		'posts_per_page' => 6,
		'max_num_pages' => 3,
		'order' => 'ASC'
	);
	$args = array(
	    'url' => admin_url( 'admin-ajax.php' ),
	    'query' => $query,
	);

  wp_enqueue_script( 'load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
  wp_localize_script( 'load-more', 'infinite_scroll_settings', $args );
	
}
add_action( 'wp_enqueue_scripts', 'load_more_js' );


// Shortcode to allow the user to show a book review in a book post :)
function book_review_shortcode($atts) {
	$atts = shortcode_atts( [
		'title' => '', // Book review title
	], $atts );

	if (empty($atts['title'])) {
		return 'No title found in book_review.';
	}

	$bookId = get_the_ID(); 
	$query = array( 
		'post_type' => 'book-review',
		'posts_per_page' => 1,
		'max_num_pages' => 1,
		'order' => 'ASC',
		'meta_query' => array(
			array(
			    'key' => 'book_review_title',
			    'value' => $atts['title'],
			),
			array(
			    'key' => 'book_review_book',
			    'value' => $bookId,
			),
	    )
	);
	$the_query = new WP_Query( $query );
	while ( $the_query->have_posts() ) : $the_query->the_post();

	$bookReviewTitle = get_field('book_review_title');
	$bookReviewContent = get_field('book_review_content');

    $output .= 
    	'<div class="book-review">'                             
    		.'<div class="book-review_content">' 
    			. '<blockquote>' . $bookReviewContent . '</blockquote> - <cite>' . $bookReviewTitle . '</cite>'
    		. '</div>'
    	.'</div>';

    endwhile;
    wp_reset_postdata();

	return $output;
}
add_shortcode( 'book_review', 'book_review_shortcode' );


function book_review_publish_handler( $post_id ) {
	if ( get_post_type($post_id) != 'book-review' ) {
		return;
	}
	$post = get_post($post_id);
	$post_content = trim(strip_tags(apply_filters('the_content', $post->post_content)));
	update_post_meta($post_id, 'book_review_title', $post->post_title);
	update_post_meta($post_id, 'book_review_content', $post_content);
}
add_action( 'save_post', 'book_review_publish_handler' );


