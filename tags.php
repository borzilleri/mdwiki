<?php
include('autohandler.php');

if( isset($_REQUEST['tag']) ) {
	$pageList = Tag::getPagesByTag(@$_REQUEST['tag']);
}
else {
	$tagList = Tag::getTagList();
}

?>

<? if( isset($pageList) ): ?>
<ul>
	<? foreach($pageList as $page): ?>
	<li><a href="<?=Page::getURI($page);?>"><?=$page;?></a></li>
	<? endforeach; ?>
</li>

<? else: ?>
<ul>
  <? foreach($tagList as $tag): ?>
  <li>
    <a href="<?=SITE_URI;?>/tags/<?=$tag['name'];?>"><?=$tag['name'];?></a>
  </li>
<? endforeach; ?>
</ul>
<? endif; ?>
<?php include('footer.php'); ?>
