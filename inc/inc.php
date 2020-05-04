<?php

function register_script() {
	wp_register_script( 'custom_jquery', plugins_url('/dist/js/bootstrap.min.js', __FILE__));
	wp_register_style( 'bootstrap_style', plugins_url('/dist/css/bootstrap.min.css', __FILE__));

	wp_enqueue_script( 'custom_jquery' );
	wp_enqueue_style( 'bootstrap_style' );
}
add_action('wp_enqueue_scripts', "register_script");
?>