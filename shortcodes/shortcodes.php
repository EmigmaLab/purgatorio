<?php
/**
 * Declaring shortcodes
 *
 *
 * @package purgatorio
 */
 
if(file_exists(PURGATORIO__PLUGIN_DIR.'/shortcodes/shortcode-business-card.php')){
	require_once(PURGATORIO__PLUGIN_DIR.'/shortcodes/shortcode-business-card.php');
	if( function_exists('pg_business_card_render_html') ){
		add_shortcode( 'pg_business_card', 'pg_business_card_render_html' );
	}
}
	
?>