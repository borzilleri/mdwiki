<?php
$header = new View('header');
$header->pageTitle = $pageTitle;
$header->render(true);
?>
<ul>
  <? foreach($articleList as $a): ?>
  <li>
    <a href="<?=Article::getURI($a);?>"><?=$a;?></a>
  </li>
	<? endforeach; ?>
</ul>
<?php $footer=new View('footer');$footer->render(true);?>