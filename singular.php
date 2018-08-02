<?php get_header(); the_post(); ?>
	<main id="<?=is_single() ? 'single' : ''?>">
		<h1><?=get_the_title();?></h1>
		<?php if(is_single()): ?>
			<p class="tit-part">
				<span><?=get_the_date('Y/m/d');?></span>
				<a href="/<?=get_post_type();?>/"><?=get_post_type_object(get_post_type())->label;?></a>
				<?php foreach(get_the_terms(get_the_ID(), 'ctag') as $tag): ?>
					<a href="<?=get_term_link($tag)?>"><?=$tag->name?></a>
				<?php endforeach; ?>
			</p>
			<img alt="アイキャッチ" src="<?=get_the_post_thumbnail_url();?>">
		<?php endif; ?>
		<?php if(0<get_field('price') && get_user_meta(get_current_user_id(), 'bought')[0][get_the_ID()]!==1): ?>
			<section>
				<p><?=get_the_excerpt()?></p>
				<p>価格:&yen;<?=get_field('price');?></p>
				<?php if(is_user_logged_in()): ?>
					<?php if(get_user_meta(get_current_user_id(), 'bought')[0][get_the_ID()] === 0): ?>
						<p>支払い処理中ですしばらくしてから再読み込みしてください。</p>
					<?php else: ?>
						<p>この記事は有料です。続きをお読みになりたい場合は、当ページからお支払い手続きをお願いいたします。</p>
						<div id="paypal-button"></div>
                        <script defer src="https://www.paypal.com/sdk/js?client-id=&currency=JPY"></script>
						<script>
							window.addEventListener("DOMContentLoaded", function() {
                                paypal.Buttons({
                                    // Set up the transaction
                                    createOrder: function(data, actions) {
                                        return actions.order.create({
                                            purchase_units: [{
                                                amount: {
                                                    value: '<?=get_field('price')?>',
                                                }
                                            }],
                                            application_context: {
                                                shipping_preference: 'NO_SHIPPING'
                                            }
                                        });
                                    },
                                    // Finalize the transaction
                                    onApprove: function(data, actions) {
                                        return actions.order.capture().then(function(data) {
                                            $.ajax({
                                                url:"<?=admin_url('admin-ajax.php');?>",
                                                type:"POST",
                                                data: {"action": "buser", "id":"<?=get_the_ID();?>", "uid":"<?=get_current_user_id();?>", "pid":data.id}
                                            }).then(function(data) {
                                                location.href="";
                                            }, function(data) {
                                                alert('購入に失敗しました管理者までお問い合わせください');
                                            });
                                        }, function() {
                                            alert('購入に失敗しました管理者までお問い合わせください');
                                        });
                                    }
                                }).render('#paypal-button');
							});

						</script>
					<?php endif; ?>
				<?php else: ?>
					<p>この記事は有料です。続きをお読みになりたい場合は、ログイン後当ページからお支払い手続きをお願いいたします。</p>
					<form method="post" action="<?=wp_login_url()?>?redirect_to=<?=$_SERVER['REQUEST_URI']?>">
						<input placeholder="メールアドレス" type="text" name="log" id="log">
						<input placeholder="パスワード" type="password" name="pwd" id="pwd">
						<button type="button" id="create">サインアップ</button><button>サインイン</button>
					</form>
					<script>
						window.addEventListener("DOMContentLoaded", function() {
							$("#create").on("click", function() {
								event.preventDefault();
								$.ajax({
									url:"<?=admin_url('admin-ajax.php');?>",
									type:"POST",
									dataType:"json",
									data: {"action": "cuser", "log": $('#log').val(), "pwd": $('#pwd').val()}
								}).then(function(data) {
									alert('アカウントの作成に成功しました自動ログインします');
									$('form').submit();
								}, function(data) {
									alert(data.responseJSON.status);
								});
							});
						});
					</script>
				<?php endif; ?>
			</section>
		<?php else:
			the_content();
		endif; ?>
	</main>
	<?php if(is_single()): ?>
		<aside>
			<section>
				<h2>最新の記事</h2>
				<?php
					$query = new WP_Query(array(
						'post_type'=>['cresec', 'tech',  'pay', 'other'],
						'posts_per_page'=>5
					));
					while($query->have_posts()): $query->the_post();
				?>
					<article onclick="location.href='<?=get_permalink()?>'">
						<img src="<?=get_the_post_thumbnail_url();?>">
						<div>
							<h3><?=get_the_title();?></h3>
							<p class="tit-part"><span><?=get_the_date('Y/m/d');?></span><a href="/<?=get_post_type();?>/"><?=get_post_type_object(get_post_type())->label;?></a></p>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</section>
			<section>
				<h2><?=get_post_type_object(get_post_type())->label?>の記事</h2>
				<?php
					$query = new WP_Query(array(
						'post_type'=>get_post_type(),
						'posts_per_page'=>5
					));
					while($query->have_posts()): $query->the_post();
				?>
					<article onclick="location.href='<?=get_permalink()?>'">
						<img src="<?=get_the_post_thumbnail_url();?>">
						<div>
							<h3><?=get_the_title();?></h3>
							<p class="tit-part"><span><?=get_the_date('Y/m/d');?></span><a href="/<?=get_post_type();?>/"><?=get_post_type_object(get_post_type())->label;?></a></p>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</section>
		</aside>
	<?php endif; ?>
<?php get_footer(); ?>
