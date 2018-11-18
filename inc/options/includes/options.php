<?php

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options/' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Don't load if optionsframework_init is already defined
if (is_admin() && ! function_exists( 'optionsframework_init' ) ) :

function optionsframework_init() {

	//  If user can't edit theme options, exit
	if ( ! current_user_can( 'edit_theme_options' ) )
		return;

	// Loads the required Options Framework classes.
	require plugin_dir_path( __FILE__ ) . 'framework.php';
	require plugin_dir_path( __FILE__ ) . 'framework-admin.php';
	require plugin_dir_path( __FILE__ ) . 'interface.php';
	require plugin_dir_path( __FILE__ ) . 'media-uploader.php';
	require plugin_dir_path( __FILE__ ) . 'sanitization.php';

	// Instantiate the main plugin class.
	$options_framework = new Options_Framework;
	$options_framework->init();

	// Instantiate the options page.
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();
	wp_enqueue_style( 'optionsframework', OPTIONS_FRAMEWORK_DIRECTORY.'css/options.css' );
}

add_action( 'init', 'optionsframework_init', 20 );

endif;


/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */

if ( ! function_exists( 'zm_get_option' ) ) :

function zm_get_option( $name, $default = false ) {
	$config = get_option( 'optionsframework' );

	if ( ! isset( $config['id'] ) ) {
		return $default;
	}

	$options = get_option( $config['id'] );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}

endif;


/*  Add custom script to theme options  */
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
add_action('optionsframework_after','exampletheme_options_after', 100);
}

function exampletheme_options_after() { ?>
		<div id="scroll-a">
			<div class="scroll-t"><a href="#optionsframework-wrap" title="直达顶部"><span class="dashicons dashicons-arrow-up"></span></a></div>
			<div class="scroll-b"><a href="#optionsframework-submit" title="直达底部"><span class="dashicons dashicons-arrow-down"></span></a></div>
		</div>
<?php
}

/*
 * This is an example of how to override a default filter
 * for 'textarea' sanitization and $allowedposttags + embed and script.
 */
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
   remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
   add_filter( 'of_sanitize_textarea', create_function('$input', 'return $input;') );
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 *
 * You can delete it if you not using that option
 */

add_action( 'optionsframework_custom_scripts', 'optionsframework_custom_scripts' );

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#logos').click(function() {
		jQuery('#section-logo').fadeToggle(400);
	});

	if (jQuery('#logos:checked').val() !== undefined) {
		jQuery('#section-logo').show();
	}

	jQuery('#begin-news_model-news_list').click(function() {
		jQuery('#section-cms_new_img').fadeToggle(400);
	});
	jQuery('#slider').click(function() {
		jQuery('#section-show_order, #section-slider_n').fadeToggle(400);
	});

	if (jQuery('#slider:checked').val() !== undefined) {
		jQuery('#section-show_order, #section-slider_n').show();
	}


	jQuery('#grid_cat_new').click(function() {
		jQuery('#section-grid_cat_news_n').fadeToggle(400);
	});

	if (jQuery('#grid_cat_new:checked').val() !== undefined) {
		jQuery('#section-grid_cat_news_n').show();
	}

	jQuery('#grid_cat_a').click(function() {
		jQuery('#section-grid_cat_a_id, #section-grid_cat_a_n').fadeToggle(400);
	});

	if (jQuery('#grid_cat_a:checked').val() !== undefined) {
		jQuery('#section-grid_cat_a_id, #section-grid_cat_a_n').show();
	}

	jQuery('#grid_cat_b').click(function() {
		jQuery('#section-grid_cat_b_id, #section-grid_cat_b_n').fadeToggle(400);
	});

	if (jQuery('#grid_cat_b:checked').val() !== undefined) {
		jQuery('#section-grid_cat_b_id, #section-grid_cat_b_n').show();
	}

	jQuery('#grid_cat_c').click(function() {
		jQuery('#section-grid_cat_c_id, #section-grid_cat_c_n').fadeToggle(400);
	});

	if (jQuery('#grid_cat_c:checked').val() !== undefined) {
		jQuery('#section-grid_cat_c_id, #section-grid_cat_c_n').show();
	}

	jQuery('#news').click(function() {
		jQuery('#section-news_model, #section-news_n, #section-not_news_n, .news-catid, #section-news_s').fadeToggle(400);
	});
	if (jQuery('#news:checked').val() !== undefined) {
		jQuery('#section-news_model, #section-news_n, #section-not_news_n, .news-catid, #section-news_s').show();
	}

	jQuery('#post_img').click(function() {
		jQuery('#section-post_img_n').fadeToggle(400);
	});
	if (jQuery('#post_img:checked').val() !== undefined) {
		jQuery('#section-post_img_n').show();
	}

	jQuery('#cms_widget_one').click(function() {
		jQuery('#section-cms_widget_one_s').fadeToggle(400);
	});
	if (jQuery('#cms_widget_one:checked').val() !== undefined) {
		jQuery('#section-cms_widget_one_s').show();
	}

	jQuery('#picture').click(function() {
		jQuery('#section-picture_id, #section-picture_n, #section-rand_img, .pi-catid, #section-picture_s').fadeToggle(400);
	});

	if (jQuery('#picture:checked').val() !== undefined) {
		jQuery('#section-picture_id, #section-picture_n, #section-rand_img, .pi-catid, #section-picture_s').show();
	}

	jQuery('#cms_widget_two').click(function() {
		jQuery('#section-cms_widget_two_s').fadeToggle(400);
	});
	if (jQuery('#cms_widget_two:checked').val() !== undefined) {
		jQuery('#section-cms_widget_two_s').show();
	}

	jQuery('#cat_one_5').click(function() {
		jQuery('#section-cat_one_5_id, .ov-catid, #section-cat_one_5_s').fadeToggle(400);
	});

	if (jQuery('#cat_one_5:checked').val() !== undefined) {
		jQuery('#section-cat_one_5_id,.ov-catid, #section-cat_one_5_s').show();
	}

	jQuery('#cat_one_10').click(function() {
		jQuery('#section-cat_one_10_id, .os-catid, #section-cat_one_10_s').fadeToggle(400);
	});

	if (jQuery('#cat_one_10:checked').val() !== undefined) {
		jQuery('#section-cat_one_10_id,.os-catid, #section-cat_one_10_s').show();
	}

	jQuery('#video').click(function() {
		jQuery('#section-video_id, #section-picture_n, #section-rand_video, .vs-catid, #section-video_s').fadeToggle(400);
	});

	if (jQuery('#video:checked').val() !== undefined) {
		jQuery('#section-video_id, #section-picture_n, #section-rand_video, .vs-catid, #section-video_s').show();
	}

	jQuery('#cat_small').click(function() {
		jQuery('#section-cat_small_id, #section-cat_small_n, #section-cat_small_z, .sm-catid, #section-cat_small_s').fadeToggle(400);
	});

	if (jQuery('#cat_small:checked').val() !== undefined) {
		jQuery('#section-cat_small_id, #section-cat_small_n, #section-cat_small_z, .sm-catid, #section-cat_small_s').show();
	}

	jQuery('#tab_h').click(function() {
		jQuery('#section-tabt_n, #section-tab_a, #section-tabt_id, #section-tab_b, #section-tabz_n, #section-tab_c, #section-tabq_n, #section-tab_h_s').fadeToggle(400);
	});

	if (jQuery('#tab_h:checked').val() !== undefined) {
		jQuery('#section-tabt_n, #section-tab_a, #section-tabt_id, #section-tab_b, #section-tabz_n, #section-tab_c, #section-tabq_n, #section-tab_h_s').show();
	}

	jQuery('#products_on').click(function() {
		jQuery('#section-products_id, #section-products_n, .pr-catid, #section-products_on_s').fadeToggle(400);
	});

	if (jQuery('#products_on:checked').val() !== undefined) {
		jQuery('#section-products_id, #section-products_n, .pr-catid, #section-products_on_s').show();
	}

	jQuery('#cat_square').click(function() {
		jQuery('#section-cat_square_id, #section-cat_square_n, .cas-catid, #section-cat_square_s').fadeToggle(400);
	});

	if (jQuery('#cat_square:checked').val() !== undefined) {
		jQuery('#section-cat_square_id, #section-cat_square_n, .cas-catid, #section-cat_square_s').show();
	}

	jQuery('#cat_grid').click(function() {
		jQuery('#section-cat_grid_id, #section-cat_grid_n, #section-cat_grid_s').fadeToggle(400);
	});

	if (jQuery('#cat_grid:checked').val() !== undefined) {
		jQuery('#section-cat_grid_id, #section-cat_grid_n, #section-cat_grid_s').show();
	}

	jQuery('#flexisel').click(function() {
		jQuery('#section-key_n, #section-gallery_post, #section-gallery_id, #section-flexisel_n, .tpv-catid, #section-flexisel_s').fadeToggle(400);
	});

	if (jQuery('#flexisel:checked').val() !== undefined) {
		jQuery('#section-key_n, #section-gallery_post, #section-gallery_id, #section-flexisel_n, .tpv-catid, #section-flexisel_s').show();
	}

	jQuery('#cat_big').click(function() {
		jQuery('#section-cat_big_id, #section-cat_big_n, #section-cat_big_z, .dct-catid, #section-, #section-cat_big_s').fadeToggle(400);
	});

	if (jQuery('#cat_big:checked').val() !== undefined) {
		jQuery('#section-cat_big_id, #section-cat_big_n, #section-cat_big_z, .dct-catid, #section-, #section-cat_big_s').show();
	}

	jQuery('#tao_h').click(function() {
		jQuery('#section-tao_h_id, #section-tao_h_n, #section-rand_tao, .taoc-catid, #section-tao_h_s').fadeToggle(400);
	});

	if (jQuery('#tao_h:checked').val() !== undefined) {
		jQuery('#section-tao_h_id, #section-tao_h_n, #section-rand_tao, .taoc-catid, #section-tao_h_s').show();
	}

	jQuery('#product_h').click(function() {
		jQuery('#section-product_h_id, #section-product_h_n, .wooc-catid, #section-product_h_s').fadeToggle(400);
	});

	if (jQuery('#product_h:checked').val() !== undefined) {
		jQuery('#section-product_h_id, #section-product_h_n, .wooc-catid, #section-product_h_s').show();
	}

	jQuery('#cms_edd').click(function() {
		jQuery('#section-dow_tab_a, #section-cms_edd_a_id, #section-dow_tab_a_s, #section-dow_tab_b, #section-cms_edd_b_id, #section-dow_tab_b_s, #section-dow_tab_c, #section-cms_edd_c_id, #section-dow_tab_c_s, #section-cms_edd_n, .eddc-catid, #section-cms_edd_s').fadeToggle(400);
	});

	if (jQuery('#cms_edd:checked').val() !== undefined) {
		jQuery('#section-dow_tab_a, #section-cms_edd_a_id, #section-dow_tab_a_s, #section-dow_tab_b, #section-cms_edd_b_id, #section-dow_tab_b_s, #section-dow_tab_c, #section-cms_edd_c_id, #section-dow_tab_c_s, #section-cms_edd_n, .eddc-catid, #section-cms_edd_s').show();
	}

	jQuery('#cat_big_not').click(function() {
		jQuery('#section-cat_big_not_id, #section-cat_big_not_n, #section-cat_big_z, .nocat-catid, #section-cat_big_not_s').fadeToggle(400);
	});

	if (jQuery('#cat_big_not:checked').val() !== undefined) {
		jQuery('#section-cat_big_not_id, #section-cat_big_not_n, #section-cat_big_z, .nocat-catid, #section-cat_big_not_s').show();
	}

	jQuery('#group_slider').click(function() {
		jQuery('#section-group_slider_n, #section-group_slider_url, #section-group_slider_t').fadeToggle(400);
	});

	if (jQuery('#group_slider:checked').val() !== undefined) {
		jQuery('#section-group_slider_n, #section-group_slider_url, #section-group_slider_t').show();
	}

	jQuery('#group_contact').click(function() {
		jQuery('#section-group_contact_t, #section-contact_p, #section-group_more_z, #section-group_more_url, #section-group_contact_z, #section-group_contact_url, #section-group_contact_s, #section-bg_1').fadeToggle(400);
	});

	if (jQuery('#group_contact:checked').val() !== undefined) {
		jQuery('#section-group_contact_t, #section-contact_p, #section-group_more_z, #section-group_more_url, #section-group_contact_z, #section-group_contact_url, #section-group_contact_s, #section-bg_1').show();
	}

	jQuery('#dean').click(function() {
		jQuery('#section-dean_des, #section-dean_t, #section-dean_d, #section-dean_s, #section-bg_2').fadeToggle(400);
	});

	if (jQuery('#dean:checked').val() !== undefined) {
		jQuery('#section-dean_des, #section-dean_t, #section-dean_d, #section-dean_s, #section-bg_2').show();
	}

	jQuery('#group_products').click(function() {
		jQuery('#section-group_products_t, #section-group_products_des, #section-group_products_id, #section-group_products_n, #section-group_products_url, .gpr-catid, #section-group_products_s, #section-bg_3').fadeToggle(400);
	});

	if (jQuery('#group_products:checked').val() !== undefined) {
		jQuery('#section-group_products_t, #section-group_products_des, #section-group_products_id, #section-group_products_n, #section-group_products_url, .gpr-catid, #section-group_products_s, #section-bg_3').show();
	}

	jQuery('#service').click(function() {
		jQuery('#section-service_des, #section-service_t, #section-service_l_id, #section-service_r_id, #section-service_c_id, #section-service_c_img, #section-service_s, #section-bg_4').fadeToggle(400);
	});

	if (jQuery('#service:checked').val() !== undefined) {
		jQuery('#section-service_des, #section-service_t, #section-service_l_id, #section-service_r_id, #section-service_c_id, #section-service_c_img, #section-service_s, #section-bg_4').show();
	}

	jQuery('#g_product').click(function() {
		jQuery('#section-g_product_t, #section-g_product_des, #section-g_product_id, #section-g_product_n, #section-g_product_url, .grwoo-catid, #section-g_product_s, #section-bg_5').fadeToggle(400);
	});
	if (jQuery('#g_product:checked').val() !== undefined) {
		jQuery('#section-g_product_t, #section-g_product_des, #section-g_product_id, #section-g_product_n, #section-g_product_url, .grwoo-catid, #section-g_product_s, #section-bg_5').show();
	}

	jQuery('#group_features').click(function() {
		jQuery('#section-features_t, #section-features_des, #section-features_id, #section-features_n, #section-features_url, #section-group_features_s, #section-bg_6').fadeToggle(400);
	});

	if (jQuery('#group_features:checked').val() !== undefined) {
		jQuery('#section-features_t, #section-features_des, #section-features_id, #section-features_n, #section-features_url, #section-group_features_s, #section-bg_6').show();
	}

	jQuery('#group_wd_l').click(function() {
		jQuery('#section-group_wd_l_id, #section-group_wd_l_id_n, .wl-catid, #section-group_wd_l_s, #section-bg_7').fadeToggle(400);
	});
	if (jQuery('#group_wd_l:checked').val() !== undefined) {
		jQuery('#section-group_wd_l_id, #section-group_wd_l_id_n, .wl-catid, #section-group_wd_l_s, #section-bg_7').show();
	}

	jQuery('#group_wd_r').click(function() {
		jQuery('#section-group_wd_r_id, #section-group_wd_r_id_n, .wr-catid, #section-group_wd_r_s, #section-bg_8').fadeToggle(400);
	});
	if (jQuery('#group_wd_r:checked').val() !== undefined) {
		jQuery('#section-group_wd_r_id, #section-group_wd_r_id_n, .wr-catid, #section-group_wd_r_s, #section-bg_8').show();
	}

	jQuery('#group_explain').click(function() {
		jQuery('#section-group_explain_t, #section-explain_p, #section-group_explain_s, #section-bg_9').fadeToggle(400);
	});
	if (jQuery('#group_explain:checked').val() !== undefined) {
		jQuery('#section-group_explain_t, #section-explain_p, #section-group_explain_s, #section-bg_9').show();
	}

	jQuery('#group_widget_one').click(function() {
		jQuery('#section-group_widget_one_s, #section-bg_10').fadeToggle(400);
	});
	if (jQuery('#group_widget_one:checked').val() !== undefined) {
		jQuery('#section-group_widget_one_s, #section-bg_10').show();
	}

	jQuery('#group_new').click(function() {
		jQuery('#section-group_new_t, #section-group_new_des, #section-group_new_n, #section-not_group_new, .grne-catid, #section-group_new_s, #section-bg_11').fadeToggle(400);
	});
	if (jQuery('#group_new:checked').val() !== undefined) {
		jQuery('#section-group_new_t, #section-group_new_des, #section-group_new_n, #section-not_group_new, .grne-catid, #section-group_new_s, #section-bg_11').show();
	}

	jQuery('#group_edd').click(function() {
		jQuery('#section-group_edd_s, #section-group_edd_o, #section-bg_12').fadeToggle(400);
	});
	if (jQuery('#group_edd:checked').val() !== undefined) {
		jQuery('#section-group_edd_s, #section-group_edd_o, #section-bg_12').show();
	}

	jQuery('#group_widget_three').click(function() {
		jQuery('#section-group_widget_three_s, #section-bg_13').fadeToggle(400);
	});
	if (jQuery('#group_widget_three:checked').val() !== undefined) {
		jQuery('#section-group_widget_three_s, #section-bg_13').show();
	}

	jQuery('#group_cat_a').click(function() {
		jQuery('#section-group_cat_a_id, #section-group_cat_a_top, #section-group_cat_a_n, .grcata-catid, #section-group_cat_a_s, #section-bg_14').fadeToggle(400);
	});
	if (jQuery('#group_cat_a:checked').val() !== undefined) {
		jQuery('#section-group_cat_a_id, #section-group_cat_a_top, #section-group_cat_a_n, .grcata-catid, #section-group_cat_a_s, #section-bg_14').show();
	}

	jQuery('#group_widget_two').click(function() {
		jQuery('#section-group_widget_two_s, #section-bg_15').fadeToggle(400);
	});
	if (jQuery('#group_widget_two:checked').val() !== undefined) {
		jQuery('#section-group_widget_two_s, #section-bg_15').show();
	}

	jQuery('#group_cat_b').click(function() {
		jQuery('#section-group_cat_b_id, #section-group_cat_b_top, #section-group_cat_b_n, .grcatb-catid, #section-group_cat_b_s, #section-bg_16').fadeToggle(400);
	});

	if (jQuery('#group_cat_b:checked').val() !== undefined) {
		jQuery('#section-group_cat_b_id, #section-group_cat_b_top, #section-group_cat_b_n, .grcatb-catid, #section-group_cat_b_s, #section-bg_16').show();
	}

	jQuery('#group_tab').click(function() {
		jQuery('#section-anli_t, #section-anli_id, #section-cp_t, #section-cp_id, #section-sb_t, #section-sb_id, #section-group_tab_n, #section-group_tab_s, #section-bg_17').fadeToggle(400);
	});

	if (jQuery('#group_tab:checked').val() !== undefined) {
		jQuery('#section-anli_t, #section-anli_id, #section-cp_t, #section-cp_id, #section-sb_t, #section-sb_id, #section-group_tab_n, #section-group_tab_s, #section-bg_17').show();
	}

	jQuery('#group_cat_c').click(function() {
		jQuery('#section-group_cat_c_id, #section-group_cat_c_top, #section-group_cat_c_n, .grcatc-catid, #section-group_cat_c_s, #section-bg_18').fadeToggle(400);
	});

	if (jQuery('#group_cat_c:checked').val() !== undefined) {
		jQuery('#section-group_cat_c_id, #section-group_cat_c_top, #section-group_cat_c_n, .grcatc-catid, #section-group_cat_c_s, #section-bg_18').show();
	}

	jQuery('#group_carousel').click(function() {
		jQuery('#section-group_carousel_t, #section-carousel_des, #section-group_carousel_id, #section-group_gallery, #section-group_gallery_id, #section-carousel_n, #section-group_carousel_img, .grim-catid').fadeToggle(400);
	});

	if (jQuery('#group_carousel:checked').val() !== undefined) {
		jQuery('#section-group_carousel_t, #section-carousel_des, #section-group_carousel_id, #section-group_gallery, #section-group_gallery_id, #section-carousel_n, #section-group_carousel_img, .grim-catid').show();
	}


	jQuery('#front_tougao').click(function() {
		jQuery('#section-allow_files, #section-not_front_cat, .fep-catid').fadeToggle(400);
	});

	if (jQuery('#front_tougao:checked').val() !== undefined) {
		jQuery('#section-allow_files, #section-not_front_cat, .fep-catid').show();
	}

	jQuery('#qr_img').click(function() {
		jQuery('#section-qr_icon').fadeToggle(400);
	});

	if (jQuery('#qr_img:checked').val() !== undefined) {
		jQuery('#section-qr_icon').show();
	}

	jQuery('#qq_online').click(function() {
		jQuery('#section-qq_name, #section-qq_id, #section-weixing_qr').fadeToggle(400);
	});

	if (jQuery('#qq_online:checked').val() !== undefined) {
		jQuery('#section-qq_name, #section-qq_id, #section-weixing_qr').show();
	}

	jQuery('#single_weixin').click(function() {
		jQuery('#section-single_weixin_one, #section-weixin_h, #section-weixin_h_w, #section-weixin_h_img, #section-weixin_g, #section-weixin_g_w, #section-weixin_g_img').fadeToggle(400);
	});

	if (jQuery('#single_weixin:checked').val() !== undefined) {
		jQuery('#section-single_weixin_one, #section-weixin_h, #section-weixin_h_w, #section-weixin_h_img, #section-weixin_g, #section-weixin_g_w, #section-weixin_g_img').show();
	}

	jQuery('#ad_h_t').click(function() {
		jQuery('#section-ad_ht_c, #section-ad_ht_m').fadeToggle(400);
	});

	if (jQuery('#ad_h_t:checked').val() !== undefined) {
		jQuery('#section-ad_ht_c, #section-ad_ht_m').show();
	}

	jQuery('#ad_h').click(function() {
		jQuery('#section-ad_h_c, #section-ad_h_c_m').fadeToggle(400);
	});
	if (jQuery('#ad_h:checked').val() !== undefined) {
		jQuery('#section-ad_h_c, #section-ad_h_c_m').show();
	}

	jQuery('#ad_s').click(function() {
		jQuery('#section-ad_s_c, #section-ad_s_c_m').fadeToggle(400);
	});
	if (jQuery('#ad_s:checked').val() !== undefined) {
		jQuery('#section-ad_s_c, #section-ad_s_c_m').show();
	}

	jQuery('#ad_a').click(function() {
		jQuery('#section-ad_a_c, #section-ad_a_c_m').fadeToggle(400);
	});
	if (jQuery('#ad_a:checked').val() !== undefined) {
		jQuery('#section-ad_a_c, #section-ad_a_c_m').show();
	}

	jQuery('#ad_s_b').click(function() {
		jQuery('#section-ad_s_c_b, #section-ad_s_c_b_m').fadeToggle(400);
	});
	if (jQuery('#ad_s_b:checked').val() !== undefined) {
		jQuery('#section-ad_s_c_b, #section-ad_s_c_b_m').show();
	}

	jQuery('#ad_c').click(function() {
		jQuery('#section-ad_c_c, #section-ad_c_c_m').fadeToggle(400);
	});
	if (jQuery('#ad_c:checked').val() !== undefined) {
		jQuery('#section-ad_c_c, #section-ad_c_c_m').show();
	}

	jQuery('#bulletin').click(function() {
		jQuery('#section-bulletin_id, #catids, #section-bulletin_n').fadeToggle(400);
	});
	if (jQuery('#bulletin:checked').val() !== undefined) {
		jQuery('#section-bulletin_id, #catids, #section-bulletin_n').show();
	}

	jQuery('#check_admin').click(function() {
		jQuery('#section-admin_name, #section-admin_email').fadeToggle(400);
	});
	if (jQuery('#check_admin:checked').val() !== undefined) {
		jQuery('#section-admin_name, #section-admin_email').show();
	}

	jQuery('#profile').click(function() {
		jQuery('#section-login, #section-reset_pass, #section-user_l, #section-wel_come, #section-reg_url').fadeToggle(400);
	});
	if (jQuery('#profile:checked').val() !== undefined) {
		jQuery('#section-login, #section-reset_pass, #section-user_l, #section-wel_come, #section-reg_url').show();
	}

	jQuery('#wp_s').click(function() {
		jQuery('#section-search_cat, #section-search_title,#section-not_search_cat').fadeToggle(400);
	});
	if (jQuery('#wp_s:checked').val() !== undefined) {
		jQuery('#section-search_cat, #section-search_title,#section-not_search_cat').show();
	}

	jQuery('#baidu_s').click(function() {
		jQuery('#section-baidu_id, #section-baidu_url').fadeToggle(400);
	});
	if (jQuery('#baidu_s:checked').val() !== undefined) {
		jQuery('#section-baidu_id, #section-baidu_url').show();
	}
});
</script>

<?php
}