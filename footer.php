<?
/**
 * $Id$
 *
 */

$e_time = microtime(true);
?>

<div id="pageLinks">[ 
  <a href="http://<?=SITE_ROOT;?>">list</a>
<? if($login->isLoggedIn()): ?>
  <? if( !empty($page) && $page->exists() ): ?>
 | <a href="http://<?=SITE_ROOT;?>/<?=$page->title;?>/edit">edit</a>
  <? endif; ?>
 | <a href="http://<?=SITE_ROOT;?>/add">new</a>
<? endif; ?>
]
</div>

<div id="timer"><?=$e_time-$s_time;?></div>
</body>
</html>
