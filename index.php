<?php
/**
 * $Id$
 *
 */
include('autohandler.php');

$pages = Page::getAllPages(true);
?>

<ul>
  <? foreach($pages as $p): ?>
  <li>
    <a href="<?=Page::getURI($p);?>"><?=$p;?></a>
  </li>
<? endforeach; ?>
</ul>

<?php include('footer.php'); ?>
