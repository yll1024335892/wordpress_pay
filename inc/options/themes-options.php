<?php
	//https://www.chiser.cc
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

function optionsframework_options() {

	$blogpath =  get_stylesheet_directory_uri() . '/img';

	// 将所有分类（categories）加入数组
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// 将所有标签（tags）加入数组
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// 将所有页面（pages）加入数组
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = '选择页面:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
	$options = array();
	// 首页设置
	$options[] = array(
		'name' => '支付宝设置',
		'type' => 'heading'
	);
	$options[] = array(
		'name' => 'app_id',
		'desc' => '应用ID,您的APPID',
		'id' => 'app_id',
		'std' => '',
		'class' => '',
		'type' => 'text'
	);
	$options[] = array(
		'name' => 'merchant_private_key',
		'desc' => '商户私钥',
		'id' => 'merchant_private_key',
		'std' => '',
		'type' => 'textarea'
	);
	$options[] = array(
		'name' => 'alipay_public_key',
		'desc' => '支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥',
		'id' => 'alipay_public_key',
		'std' => '',
		'type' => 'textarea'
	);


	$options[] = array(
		'name' => '商品推荐设置',
		'type' => 'heading'
	);
	$options[] = array(
		'name' => '类别中的推荐商品(6个以内，大于6随机显示6个)文档必须是发布的ID',
		'desc' => '文档的id中间用@隔开,如1@2且结尾不能够是@',
		'id' => 'cat_post_id',
		'std' => '',
		'class' => '',
		'type' => 'text'
	);
	$options[] = array(
		'id' => 'clear'
	);
	$options[] = array(
		'name' => '具体页面中的推荐商品(6个以内，大于6随机显示6个)文档必须是发布的ID',
		'desc' => '文档的id中间用@隔开,如1@2且结尾不能够是@',
		'id' => 'single_post_id',
		'std' => '',
		'class' => '',
		'type' => 'text'
	);



	return $options;
}