<?php
include('autohandler.php');
$error = false;
if( $login->isLoggedIn() ) {
	$page = new Page(@$_REQUEST['page']);
	if( 'save' == $action ) {
    $error = !$page->update();
	  if( !$error ) {
	    $page->save();
	    loadPage($page->getLink(true));
	  }
	}
	elseif( 'add' == $action ) {
		// If we're adding a page and the title has been suppplied
		// Set it in the object.
		// We have to strip out the first character, however, 
		// as that -should- be a slash character from the redirect.
		$page->setTitle(substr(@$_REQUEST['title'],1));
	}
	elseif( 'delete' == $action ) {
		$page->delete();
		loadPage("/");
	}
}
?>

<? if(!$login->isLoggedIn()): ?>
<div id="error">
You are not authorized for this page.
</div>
<? else: ?>

<? if($error): ?>
<div id="error">
An error occured, please try again.
</div>
<? endif; ?>

<div id="MarkdownCheatSheet">
  <?=Markdown(file_get_contents('includes/inc/md.text'));?>
</div>

<form method="POST" action="http://<?=SITE_ROOT;?>/save">
<input name="action" type="hidden" value="save" />
<div id="PageEditForm">
  <a name='form'></a>
  <div><label for="pageTitle">Page Title:</label>
		<input name="pageTitle" type="text" size="30" maxlength="255" 
			id="pageTitle" tabindex="1" accesskey="t"
			value="<?=$page->title;?>" />
		<input type="submit" value="Save" tabindex="3" accesskey="s" />
  <? if( $page->exists() ): ?>
		<input name="page" type="hidden" value="<?=$page->title;?>" />
		<input name="action" type="submit" value="Delete" 
		  tabindex="4" accesskey="d" />
	<? endif; ?>
  </div>
  <div><textarea id="pageText" name="pageText" rows="19" cols="78" 
	 tabindex="2" accesskey="b" style="align: left;"><?=$page->text;?></textarea>
	</div>
</div>
</form>
<? endif; ?>
<? include('footer.php'); ?>
