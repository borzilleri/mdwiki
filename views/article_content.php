<?php
$header = new View('header');
$header->pageTitle = $article->title;
$header->render(true);
?>
<article>
	<header>
		<h1><?=$article->title;?></h1>
	</header>
	<?=$article->render();?>
	<div id="Tags">
		<a href="<?=sliMVC::config('core.site_uri');?>/tags">Tags</a>: 
		<ul>
		<? foreach($article->tags as $tag): ?>
			<li>
				<a href="<?=sliMVC::config('core.site_uri');?>/tags/<?=$tag;?>"><?=$tag;?></a>
			</li>
		<? endforeach; ?>
		</ul>
	</div>
</article>
<?php $footer=new View('footer');$footer->render(true);