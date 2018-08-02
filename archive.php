<?php get_header(); ?>
	<main>
		<?php global $template; ?>
		<h1><?=basename($template, '.php')=='home' ? '記事一覧' : get_post_type_object(get_post_type())->label;?></h1>
		<?php while(have_posts()): the_post(); ?>
			<article class="art-cont" onclick="location.href='<?=get_permalink();?>'">
				<img src="<?=get_the_post_thumbnail_url();?>">
				<div>
					<h2><?=get_the_title();?></h2>
					<p><?=get_the_excerpt();?></p>
					<p class="tit-part">
						<?php foreach(get_the_terms(get_the_ID(), 'ctag') as $tag): ?>
							<a href="<?=get_term_link($tag)?>"><?=$tag->name?></a>
						<?php endforeach; ?>
						<a href="/<?=get_post_type();?>/"><?=get_post_type_object(get_post_type())->label;?></a>
						<span><?=get_the_date('Y/m/d');?></span>
					</p>
				</div>
			</article>
		<?php endwhile; ?>
		<div id="nate"><?=paginate_links(array(
			'prev_text'=>'前へ',
			'next_text'=>'次へ'
		));?></div>
	</main>
<?php get_footer(); ?>
