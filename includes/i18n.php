<?php

/**
 * Get current language using Polylang or WPML
 *
 * @param
 * @return string
 *
**/
if ( ! function_exists('pg_get_current_language') ) {
    function pg_get_current_language() {
        $current_lang = 'en';
        
        if( function_exists('pll_current_language') ){
            $current_lang = pll_current_language();
        }
        elseif( has_filter('wpml_current_language') ){
            $current_lang = apply_filters( 'wpml_current_language', NULL );
        }
        
        return $current_lang;
    }
}

/**
 * Get all languages using Polylang or WPML
 *
 * @param
 * @return string
 *
**/
if ( ! function_exists('pg_get_all_languages') ) {
    function pg_get_all_languages() {
        $current_lang = 'en';
        
        if( function_exists('pll_current_language') ){
            $current_lang = pll_current_language();
        }
        elseif( has_filter('wpml_current_language') ){
            $current_lang = apply_filters( 'wpml_current_language', NULL );
        }
        
        return $current_lang;
    }
}

/**
 * Get translated post using Polylang or WPML
 *
 * @param integer
 * @return integer
 *
**/
if ( ! function_exists('pg_get_translated_post') ) {
    function pg_get_translated_post($post_id) {
        $current_lang = pg_get_current_language();
        if( function_exists('pll_get_post') ){
            $post_id = pll_get_post($post_id, $current_lang);
        }
        elseif( has_filter('wpml_object_id') ){
            $post_to_translate = get_post($post_id);
            $post_id = apply_filters( 'wpml_object_id', intval($post_id), $post_to_translate->post_type, true, $current_lang );
        }
        
        return $post_id;
    }
}

/**
 * Get translated term using Polylang or WPML
 *
 * @param integer
 * @return integer
 *
**/
if ( ! function_exists('pg_get_translated_term') ) {
    function pg_get_translated_term($term_id) {
        $current_lang = pg_get_current_language();
        if( function_exists('pll_get_term') ){
            $term_id = pll_get_term($term_id, $current_lang);
        }
        elseif( has_filter('wpml_object_id') ){
            $term_to_translate = get_term($term_id);
            $term_id = apply_filters( 'wpml_object_id', intval($term_id), $term_to_translate->taxonomy, true, $current_lang );
        }
        
        return $term_id;
    }
}
	
?>