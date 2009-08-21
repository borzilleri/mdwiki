<?
/**
 * $Id$
 */
?>
<div id="Header">
	<div id="login">
	<? if( $login->isLoggedIn() ): ?>
		<a href="<?=SITE_URI;?>/logout">logout</a>
	<? else: ?>
	<form method="POST" action="http://<?=HTTP_HOST;?><?=$_SERVER['REQUEST_URI'];?>">
		<input name="action" type="hidden" value="login" />
		u:<input name="username" type="text" size="10" maxlength="255" 
		  accesskey="u"/>
		p:<input name="password" type="password" size="10" maxlength="255" 
		  accesskey="p"/>
		<input type="submit" value="login" />
	</form>
	<? endif; ?>
	</div>

	<div id="pageLinks">
		[ <a href="<?=SITE_URI;?>" accesskey="l">list</a>
	<? if($login->isLoggedIn()): ?>
		| <a href="<?=SITE_URI;?>/add#form" accesskey="n">new</a>
		<? if( !empty($_REQUEST['page']) ): ?>
		| <a href="<?=Page::getURI($_REQUEST['page']);?>/edit#form" accesskey="e">edit</a> 
	  <? endif; ?>
	<? endif; ?> ]
	</div>
<div class="clear"></div>
</div>

