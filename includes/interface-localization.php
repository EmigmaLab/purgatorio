<?php

global $pg_localization;

interface PG_Localization {

    public function get_current_language();
    public function get_all_languages();
    public function get_translated_post($post_id);
    public function get_translated_term($term_id);

}

class PG_Localization_Polylang implements PG_Localization {

    private $current_lang;

    function __construct(){
        $this->current_lang = $this->get_current_language();
    }

    public function get_current_language(){
        $current_lang = pll_current_language();

        return $current_lang;
    }

    public function get_all_languages(){
        $all_languages = pll_the_languages(array('raw'=>1));

        return $all_languages;
    }

    public function get_translated_post($post_id){
        $post_id = pll_get_post($post_id, $this->current_lang);

        return $post_id;
    }

    public function get_translated_term($term_id){
        $term_id = pll_get_term($term_id, $current_lang);

        return $term_id;
    }
}

class PG_Localization_WPML implements PG_Localization {

    private $current_lang;

    function __construct(){
        $this->current_lang = $this->get_current_language();
    }

    public function get_current_language(){
        $current_lang = apply_filters( 'wpml_current_language', NULL );

        return $current_lang;
    }

    public function get_all_languages(){
        $all_languages = apply_filters( 'wpml_active_languages', NULL );

        return $all_languages;
    }

    public function get_translated_post($post_id){
        $post_to_translate = get_post($post_id);
        $post_id = apply_filters( 'wpml_object_id', intval($post_id), $post_to_translate->post_type, true, $current_lang );

        return $post_id;
    }

    public function get_translated_term($term_id){
        $term_to_translate = get_term($term_id);
        $term_id = apply_filters( 'wpml_object_id', intval($term_id), $term_to_translate->taxonomy, true, $current_lang );

        return $term_id;
    }

}

// Polylang
if ( is_plugin_active( 'polylang/polylang.php' ) ) {
    $pg_localization = new PG_Localization_Polylang();
}
// WPML
elseif( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ){
    $pg_localization = new PG_Localization_WPML();
}

/**
 * Get current language using Polylang or WPML
 *
 * @param
 * @return string
 *
**/
if ( ! function_exists('pg_get_current_language') ) {
    function pg_get_current_language() {
        global $pg_localization;
        $current_lang = $pg_localization->get_current_language();
        
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
        global $pg_localization;
        $all_languages = $pg_localization->get_all_languages();
        
        return $all_languages;
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
        global $pg_localization;
        $post_id = $pg_localization->get_translated_post($post_id);
        
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
        global $pg_localization;
        $term_id = $pg_localization->get_translated_term($term_id);
        
        return $term_id;
    }
}

?>