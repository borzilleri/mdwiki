<?
/**
 * $Id$
 */
?>
<? if( $login->isLoggedIn() ): ?>
<a href="http://<?=SITE_ROOT;?>/logout">logout</a>
<? else: ?>
<div id="login">
<form method="POST" action="http://<?=HTTP_HOST;?><?=$_SERVER['REQUEST_URI'];?>">
<input name="action" type="hidden" value="login" />
  u:<input name="username" type="text" size="10" maxlength="255" />
  p:<input name="password" type="password" size="10" maxlength="255" />
  <input type="submit" value="login" />
</form>
</div>
<? endif; ?>
