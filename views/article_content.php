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
