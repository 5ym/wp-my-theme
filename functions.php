<?php
	//title
	add_theme_support('title-tag');
	//サムネイルサポート
	add_theme_support('post-thumbnails');
	//デフォルトjquery削除
	function my_delete_local_jquery() {
		wp_deregister_script('jquery');
	}
	add_action('wp_enqueue_scripts', 'my_delete_local_jquery');
	//絵文字削除
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	//embeded削除
	remove_action('wp_head','wp_oembed_add_host_js');
	//自動挿入タグ削除
	remove_filter('the_content', 'wpautop');
	remove_filter('the_excerpt', 'wpautop');
	remove_filter('the_content', 'wpautobr');
	remove_filter('the_excerpt', 'wpautobr');
	//home投稿一覧hook
	add_action('pre_get_posts', function($query) {
		if($query->is_home() || $query->is_author()) {
			$query->set('post_type', ['cresec', 'tech',  'pay', 'other']);
			$query->set('paged', get_query_var('paged'));
		}
	});
	//ログイン画面スタイル
	function login_logo() {
		echo '<style>#login h1 a {background: none;}</style>';
	}
	add_action('login_head', 'login_logo');
	//管理バーデザイン
	add_theme_support('admin-bar', array('callback' => '__return_false'));
	if(is_admin_bar_showing()) {
		add_action( 'wp_head', function() {
			echo '<style>body{margin-bottom:32px;}#wpadminbar{top:auto;bottom:0; position:fixed !important;}@media screen and (max-width: 782px){body{margin-bottom:46px;}}</style>';
		} );
	}
	//ビジュアルエディター非表示
	add_filter('user_can_richedit', function() {
		return false;
	});
	//イメージ属性削除
	add_filter( 'image_send_to_editor', 'remove_image_attribute', 10 );
	function remove_image_attribute( $html ){
	  $html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
	  $html = preg_replace( '/class=[\'"]([^\'"]+)[\'"]/i', '', $html );
	  $html = preg_replace( '/title=[\'"]([^\'"]+)[\'"]/i', '', $html );
	  $html = preg_replace( '/<a href=".+">/', '', $html );
	  $html = preg_replace( '/<\/a>/', '', $html );
		$html = preg_replace( '/  \/>/', '>', $html );
	  return $html;
	}
	//create user ajax
	add_action('wp_ajax_cuser', 'cuser');
	add_action('wp_ajax_nopriv_cuser', 'cuser');
	function cuser() {
		if(!filter_var($_POST['log'], FILTER_VALIDATE_EMAIL)) {
			http_response_code(400);
			echo '{"status": "メールアドレスを入力してください"}';
			exit;
		}
		$uid = wp_insert_user(array(
			'user_login' => $_POST['log'],
			'user_pass' =>  $_POST['pwd'],
			'user_email' => $_POST['log'],
			'role' => 'read'
		));
		update_user_meta($uid, 'show_admin_bar_front', 'false');
		update_user_meta($uid, 'show_admin_bar_admin', 'false');
		if(is_int($uid)) {
			echo '{"status": '.$uid.'}';
			exit;
		} else {
			http_response_code(400);
			foreach($uid->errors as $val)
				$vls .= $val[0];
			echo '{"status": "'.$vls.'"}';
			exit;
		}
	}
	//buy article ajax
	add_action('wp_ajax_buser', 'buser');
	add_action('wp_ajax_nopriv_buser', 'buser');
	function buser() {
		$bo = get_user_meta($_POST['uid'], 'bought')[0]; //購入済みデータ取得
		$bo[$_POST['id']] = 1;
		$st = update_user_meta($_POST['uid'], 'bought', $bo);

		//file_put_contents(__DIR__."/trans.txt", $_POST['id'].','.$_POST['uid'].','.$_POST['pid']."\n", FILE_APPEND);
	}
