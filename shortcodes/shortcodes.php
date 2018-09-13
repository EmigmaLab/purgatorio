<?php
/**
 * Declaring shortcodes
 *
 *
 * @package purgatorio
 */
 
if(file_exists(PURGATORIO__PLUGIN_DIR.'/shortcodes/shortcode-organization.php')){
	require_once(PURGATORIO__PLUGIN_DIR.'/shortcodes/shortcode-organization.php');
	if( function_exists('pg_organization_render_html') ){
		add_shortcode( 'pg_organization', 'pg_organization_render_html' );
	}
}
	
?>