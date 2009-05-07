<?php
/**
 * $Id$
 *
 */
include('autohandler.php');

$pages = Page::getAllPages(true);
?>

<ul>
  <? if($login->isLoggedIn()): ?>
  <li><a href="http://<?=SITE_ROOT;?>/add">new page</a></li>
  <? endif; ?>
<? foreach($pages as $p): ?>
  <li>
    <a href="<?=Page::getURI($p);?>"><?=$p;?></a>
  </li>
<? endforeach; ?>
</ul>

<?php include('footer.php'); ?>
