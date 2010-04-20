<div id="Tags">
	<a href="<?=SITE_URI;?>/tags">Tags</a>: 
	<ul>
	<? foreach($page->tags as $tag): ?>
		<li>
			<a href="<?=SITE_URI;?>/tags/<?=$tag;?>"><?=$tag;?></a>
		</li>
	<? endforeach; ?>
	</ul>
</div>