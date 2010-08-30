<ul>
  <? foreach($articleList as $a): ?>
  <li>
    <a href="<?=Article::getURI($a);?>"><?=$a;?></a>
  </li>
	<? endforeach; ?>
</ul>
