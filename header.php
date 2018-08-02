<?php global $template; $tempname=basename($template, '.php'); ?>
<!doctype html>
<html>
	<head>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WCR69NB');</script>
		<link rel="SHORTCUT ICON" href="<?=get_template_directory_uri();?>/img/favicon.ico">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?=get_template_directory_uri();?>/style.css?data=20180723">
		<script src="<?=get_template_directory_uri();?>/pr.js" async></script>
		<script src="<?=get_template_directory_uri();?>/jquery.js" defer></script>
		<script src="<?=get_template_directory_uri();?>/main.js?data=20180723" defer></script>
		<?php wp_head(); ?>
	</head>
	<body class="<?=$tempname;?>">
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCR69NB" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<header>
			<div id="hed-logo" onclick="location.href='<?=home_url();?>'">
				<div><i class="far fa-credit-card"></i><i class="fas fa-camera"></i></div>
				<div><p>Money</p><p>Hobby</p></div>
			</div>
			<nav>
				<a href="" id="draw-but" class="sp fas fa-bars"></a>
				<ul>
					<li>
						<a href="<?=home_url();?>" class="hed-tit">TOP</a>
						<ul>
							<li><a href="/author/">運営者について</a></li>
							<li><a href="/about/">このサイトについて</a></li>
						</ul>
					</li>
					<li><a class="hed-tit" href="/article/">記事一覧</a></li>
					<li>
						<p class="hed-tit">カテゴリ</p>
						<ul>
							<li><a href="/cresec/">クレカセキュリティ</a></li>
							<li><a href="/tech/">技術関連</a></li>
							<li><a href="/pay/">決済関連</a></li>
							<li><a href="/tech/">その他</a></li>
						</ul>
					</li>
					<li>
						<a href="/app/" class="hed-tit">アプリ</a>
						<ul>
							<li><a>準備中</a></li>
						</ul>
					</li>
					<li>
						<p class="hed-tit">タグ</p>
						<ul>
							<?php foreach(get_terms('ctag') as $tag): ?>
								<li><a href="<?=get_term_link($tag)?>"><?=$tag->name?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>
			</nav>
			<ul id="sns">
				<li><a rel="nofollow" onclick="ga('send', 'social', 'twitter', 'click', location.href);" href="https://twitter.com/share?url=<?=rawurlencode(get_the_permalink()).'&text='.rawurlencode(wp_get_document_title())?>" class="fab fa-twitter" target="_blank"></a></li>
				<li><a rel="nofollow" onclick="ga('send', 'social', 'facebook', 'click', location.href);" href="https://www.facebook.com/share.php?u=<?=rawurlencode(get_the_permalink())?>" class="fab fa-facebook-f" target="_blank"></a></li>
				<li><a rel="nofollow" onclick="ga('send', 'social', 'feedly', 'click', location.href);" href="https://feedly.com/i/subscription/feed%2Fhttps%3A%2F%2Fsiteyui.site%2Farticle%2Ffeed" class="fas fa-rss" target="_blank"></a></li>
			</ul>
		</header>
		<div id="wrap">
