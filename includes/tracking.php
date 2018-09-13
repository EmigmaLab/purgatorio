<?php

if( ! function_exists('pg_google_tag_manager_head_tracking') ){
	add_action('wp_head','pg_google_tag_manager_head_tracking');
	function pg_google_tag_manager_head_tracking(){
		$gtm_id = pg_get_option('google_tag_manager_id');
		if( ! $gtm_id ){
			return;
		}
		?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','<?php echo $gtm_id; ?>');</script>
		<!-- End Google Tag Manager -->
		<?php
	}
}

if( ! function_exists('pg_google_tag_manager_body_tracking') ){
	add_action('after_body_open_tag','pg_google_tag_manager_body_tracking');
	function pg_google_tag_manager_body_tracking(){
		$gtm_id = pg_get_option('google_tag_manager_id');
		if( ! $gtm_id ){
			return;
		}
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_id; ?>"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}
}

?>