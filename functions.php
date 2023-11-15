<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme = wp_get_theme();
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

// Add custom post types to theme
function create_post_types() {
	register_post_type( 'book',
		array(
			'labels' => array(
				'name' => __( 'Books' ),
				'singular_name' => __( 'Book' )
			),
			'description' => 'Book post type.',
			'public' => true,
			// 'publicly_queryable' => true, // default inherited from public
			// 'show_in_graphql' => true,
			// 'graphql_single_name' => 'BookReview', 
			// 'graphql_plural_name' => 'BookReviews',
		)
 	);
  	register_post_type( 'book-review',
		array(
			'labels' => array(
				'name' => __( 'Book Reviews' ),
				'singular_name' => __( 'Book Review' )
			),
			'description' => 'Book Review post type.',
			'public' => true,
		)
 	);
}
add_action( 'init', 'create_post_types' );

// Add Book Fields
function register_custom_acf_book_fields() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		// Field Group
		acf_add_local_field_group( array (
			'key' => 'book_fields',
			'title' => 'Book Fields',
			// 'graphql_field_name' => 'bookReviewFields',
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'book',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
		) );
		// Fields
		acf_add_local_field( array(
			'key' => 'book_title',
			'label' => 'Book Title',
			'name' => 'book_title',
			'type' => 'text',
			'parent' => 'book_fields',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_publisher',
			'label' => 'Book publisher',
			'name' => 'book_publisher',
			'type' => 'link',
			'parent' => 'book_fields',
			'return_format' => 'array',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_author',
			'label' => 'Book author',
			'name' => 'book_author',
			'type' => 'text',
			'parent' => 'book_fields',
			'default_value' => 'Zahra Marwan',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_publish_date',
			'label' => 'Book publish date',
			'name' => 'book_publish_date',
			'type' => 'date_picker',
			'display_format' => 'j F Y',
			'return_format' => 'm/d/Y',
			'parent' => 'book_fields',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_publish_date_format',
			'label' => 'Book publish date format',
			'name' => 'book_publish_date_format',
			'type' => 'text',
			'parent' => 'book_fields',
			'default_value' => 'j F Y',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_genre',
			'label' => 'Book genre',
			'name' => 'book_genre',
			'type' => 'text',
			'parent' => 'book_fields',
			'default_value' => 'Children books',
			'required' => 0,
		) );
		acf_add_local_field( array(
			'key' => 'book_thumbnail',
			'label' => 'Book Thumbnail',
			'name' => 'book_thumbnail',
			'type' => 'image',
			'instructions' => 'Select the book thumbnail image',
			'parent' => 'book_fields',
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'required' => 0,
		) );
	}
}
add_action( 'init', 'register_custom_acf_book_fields' );

// Add Book Review Fields
function register_custom_acf_book_review_fields() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		// Field Group
		acf_add_local_field_group( array (
			'key' => 'book_review_fields',
			'title' => 'Book Review Fields',
			// 'graphql_field_name' => 'bookReviewFields',
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'book-review',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'acf_after_title',
			'style' => 'seamless',
			'label_placement' => 'top',
			// 'instruction_placement' => 'label',
			// 'hide_on_screen' => '',
		) );
		// Fields
		acf_add_local_field( array(
			'key' => 'book_review_book',
			'label' => 'Book Review Book WIP',
			'name' => 'book_review_book',
			'type' => 'post_object',
			'parent' => 'book_review_fields',
			'post_type' => 'book',
			'return_format' => 'id',
			// 'instructions' => 'Select the book to attach this review to',
			'multiple' => 0,
			// 'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_review_title',
			'label' => 'Book Review Title',
			'name' => 'book_review_title',
			'type' => 'text',
			'parent' => 'book_review_fields',
			'instructions' => '',
			'required' => 1,
		) );
		acf_add_local_field( array(
			'key' => 'book_review_content',
			'label' => 'Book Review Content',
			'name' => 'book_review_content',
			'type' => 'text',
			'parent' => 'book_review_fields',
			'instructions' => '',
			'required' => 1,
		) );
	}
}
add_action( 'init', 'register_custom_acf_book_review_fields' );


// Get all the book with a specific title
function get_book_by_title($bookTitle) {
	$query = array( 
		'post_type' => 'book',
		'posts_per_page' => 1,
		'max_num_pages' => 1,
		'order' => 'ASC',
		'meta_query' => array(
			array(
			    'key' => 'book_title',
			    'value' => $bookTitle,
			)
	    )
	);
	$the_query = new WP_Query( $query );
	if ( !$the_query->have_posts() ) {
		return null;
	}
	return $the_query->posts[0];
}

function add_book_reviews() {
	// https://wordpress.stackexchange.com/questions/218715/fatal-error-call-to-undefined-function-post-exists
	if ( !function_exists( 'post_exists' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/post.php' );
	}

	$postsJson = file_get_contents(get_stylesheet_directory().'/data/posts.json');
	$posts = json_decode($postsJson, true);
	$postType = 'book-review';

	if ( !$posts || !$posts[$postType] ) {
		return;
	}
	foreach($posts[$postType] as $review) {
		$reviewPostId = null;
		if ( post_exists($review['title']) ) {
			$query = array(
				'post_type' => $postType,
				's' => $review['title'],
				'posts_per_page' => 1,
				'max_num_pages' => 1,
			);
			$the_query = new WP_Query( $query );
			if ( $the_query->have_posts() ) {
				$reviewPostId = $the_query->posts[0]->ID;
			}
		} else {
			$reviewPost = array(
				'post_title' => $review['title'],
				'post_content' => '<p>'.$review['content'].'</p>',
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type' => $postType
			);
			$reviewPostId = wp_insert_post( $reviewPost );
		}
		$book = get_book_by_title($review['book']);
		if ( $book ) {
			update_field( 'book_review_book', $book->ID, $reviewPostId );
		}
	}
}
add_action('init','add_book_reviews');


function add_books() {
	// https://wordpress.stackexchange.com/questions/218715/fatal-error-call-to-undefined-function-post-exists
	if ( !function_exists( 'post_exists' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/post.php' );
	}

	$postsJson = file_get_contents(get_stylesheet_directory().'/data/posts.json');
	$posts = json_decode($postsJson, true);
	$postType = 'book';

	if ( !$posts || !$posts['book'] ) {
		return;
	}
	foreach($posts[$postType] as $post) {
		if ( post_exists($post['title']) ) {
			return;
		}
		$postPost = array(
			'post_title' => $post['title'],
			'post_content' => $post['content'],
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type' => $postType
		);
		$postId = wp_insert_post( $postPost );
		foreach (array_keys($post) as $postKey) {
			if (in_array($postKey, array('title', 'content')) ) {
				continue;
			}
			update_field( $postKey, $post[$postKey], $postId );
		}
	}
}
// add_action('init','add_books');


function save_books_to_json() {
	$fileDirectory = get_stylesheet_directory().'/data/posts.json';
	$postsJson = file_get_contents($fileDirectory);
	$posts = json_decode($postsJson, true);

	if ($posts && $posts['book']) {
		return;
	}

	$query = array( 
		'post_type' => 'book',
		'posts_per_page' => -1,
		'order' => 'ASC',
	);
	$the_query = new WP_Query( $query );
	if ( !$the_query->have_posts() ) {
		return null;
	}

	$books = array();
	foreach ($the_query->posts as $post) {
		$title = $post->post_title;
		$content = $post->post_content;
		$bookTitle = get_field( 'book_title', $post->ID );
		$bookPublisher = get_field( 'book_publisher', $post->ID );
		$bookAuthor = get_field( 'book_author', $post->ID );
		$bookPublishDate = get_field( 'book_publish_date', $post->ID );
		$bookPublishDateFormat = get_field( 'book_publish_date_format', $post->ID );
		$bookGenre = get_field( 'book_genre', $post->ID );
		$bookThumbnail = get_field( 'book_thumbnail', $post->ID );
		array_push($books, array(
			'title' => $title,
			'content' => $content,
			'book_title' => $bookTitle,
			'book_publisher' => $bookPublisher,
			'book_author' => $bookAuthor,
			'book_publish_date' => $bookPublishDate,
			'book_publish_date_format' => $bookPublishDateFormat,
			'book_genre' => $bookGenre,
			// 'book_thumbnail' => $bookThumbnail
		));
	}
	$posts['book'] = $books;
	$newPosts = json_encode($posts, JSON_PRETTY_PRINT);

	$postsFile = fopen($fileDirectory, 'w') or die('Unable to open file');
	fwrite($postsFile, $newPosts);
	fclose($postsFile);
}
add_action('init','save_books_to_json');

// Infinite Scroll
function infinite_scroll_handler() {
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


