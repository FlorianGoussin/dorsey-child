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
	// echo 'Stylesheet uri: '.get_stylesheet_uri();

	// wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}

// add_filter( 'comment_feed_where', 'wpse_comment_feed_where' );
// function wpse_comment_feed_where( $where ) {
// 	return $where . " AND wp_posts.post_type NOT IN ( 'book' )";
// }