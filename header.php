<?
/**
 * $Id$
 */
?>
<div id="Header">
	<div id="login">
	<? if( $login->isLoggedIn() ): ?>
		<a href="http://<?=SITE_ROOT;?>/logout">logout</a>
	<? else: ?>
	<form method="POST" action="http://<?=HTTP_HOST;?><?=$_SERVER['REQUEST_URI'];?>">
		<input name="action" type="hidden" value="login" />
		u:<input name="username" type="text" size="10" maxlength="255" />
		p:<input name="password" type="password" size="10" maxlength="255" />
		<input type="submit" value="login" />
	</form>
	<? endif; ?>
	</div>

	<div id="pageLinks">
		[ <a href="http://<?=SITE_ROOT;?>">list</a>
	<? if($login->isLoggedIn()): ?>
		| <a href="http://<?=SITE_ROOT;?>/add">new</a>
		<? if( !empty($_REQUEST['page']) ): ?>
		| <a href="<?=Page::getURI($_REQUEST['page']);?>/edit">edit</a> 
	  <? endif; ?>
	<? endif; ?> ]
	</div>
<div class="clear"></div>
</div>

