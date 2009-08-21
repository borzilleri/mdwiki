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
  <form method="post" 
    action="http://<?=HTTP_HOST;?><?=$_SERVER['REQUEST_URI'];?>">
    <div>
      <input name="action" type="hidden" value="login" />
      <label for="username">u:</label><input name="username" id="username"
        type="text" size="10" maxlength="255" accesskey="u" />
      <label for="password">p:</label>
      <input name="password" type="password" id="password"
        size="10" maxlength="255" accesskey="p" />
      <input type="submit" value="login" />
    </div>
  </form>
  <? endif; ?>
  </div>
  <div id="pageLinks">
    [ <a href="<?=SITE_URI;?>" accesskey="l">list</a>
  <? if($login->isLoggedIn()): ?>
    | <a href="<?=SITE_URI;?>/add#form" accesskey="n">new</a>
    <? if( !empty($_REQUEST['page']) ): ?>
    | <a href="<?=Page::getURI($_REQUEST['page']);?>/edit#form" 
        accesskey="e">edit</a> 
	  <? endif; ?>
  <? endif; ?> ]
  </div>
  <div class="clear"></div>
</div>