<?php
$header = new View('header');
$header->pageTitle = $article->title;
$header->render(true);
?>
<article>
	<section>
		<?=$article->render();?>
	</section>

	<!-- Replies should go in <section> blogs in this area, probably. -->

	<section id="Tags">
		<a href="<?=sliMVC::config('core.site_uri');?>/tags">Tags</a>: 
		<ul>
		<? foreach($article->tags as $tag): ?>
			<li>
				<a href="<?=sliMVC::config('core.site_uri');?>/tags/<?=$tag;?>"><?=$tag;?></a>
			</li>
		<? endforeach; ?>
		</ul>
	</section>
</article>
<?php $footer=new View('footer');$footer->render(true);