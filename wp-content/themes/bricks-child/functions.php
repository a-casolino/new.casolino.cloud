<?php
/**
 * Register/enqueue custom scripts and styles
 */
add_action( 'wp_enqueue_scripts', function() {
	// Enqueue your files on the canvas & frontend, not the builder panel. Otherwise custom CSS might affect builder)
	if ( ! bricks_is_builder_main() ) {
		wp_enqueue_style( 'bricks-child', get_stylesheet_uri(), ['bricks-frontend'], filemtime( get_stylesheet_directory() . '/style.css' ) );
	}
} );

/**
 * Register custom elements
 */
add_action( 'init', function() {
  $element_files = [
    __DIR__ . '/elements/title.php',
  ];

  foreach ( $element_files as $file ) {
    \Bricks\Elements::register_element( $file );
  }
}, 11 );

/**
 * Add text strings to builder
 */
add_filter( 'bricks/builder/i18n', function( $i18n ) {
  // For element category 'custom'
  $i18n['custom'] = esc_html__( 'Custom', 'bricks' );

  return $i18n;
} );

function enqueue_external_script() {
    // Controlla se non siamo nell'area di amministrazione
    if (!is_admin()) {
        // Aggiungi GSAP dalla CDN
        wp_enqueue_script(
            'gsap', // Handle
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', // URL di GSAP
            array(), // Dipendenze (nessuna in questo caso)
            '3.12.2', // Versione
            true // Carica nel footer
        );
        
        // Aggiungi ScrollTrigger dalla CDN
        wp_enqueue_script(
            'gsap-scrolltrigger', // Handle
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', // URL di ScrollTrigger
            array('gsap'), // Dipende da GSAP
            '3.12.2', // Versione
            true // Carica nel footer
        );
		
		// Aggiungi Split Text dalla CDN
        wp_enqueue_script(
            'split-text', // Handle
            'https://unpkg.com/split-type',
            array(),
            '0.3.4',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_external_script');