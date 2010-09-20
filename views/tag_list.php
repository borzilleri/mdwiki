<?php
$header = new View('header');
$header->pageTitle = $pageTitle;
$header->render(true);
?>
<ul>
  <? foreach($tagList as $tag): ?>
  <li>
    <a href="<?=sliMVC::config('core.site_uri');?>/tags/<?=$tag['name'];?>"><?=$tag['name'];?></a>
  </li>
<? endforeach; ?>
</ul>
<?php $footer=new View('footer');$footer->render(true);?>