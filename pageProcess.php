<?php
include('autohandler.php');
$error = false;
$page = new Page(@$_REQUEST['page']);
if( 'save' == $action ) {
  if( !empty($_REQUEST['pageDelete']) ) {
    $page->delete();
    lodPage("/");
  }
  else {
    $error = !$page->update();
    if( !$error ) {
      $page->save();
      loadPage("/{$page->title}");
    }
  }
}
?>

<? if($error): ?>
<div id="error">
An error occured, please try again.
</div>
<? endif; ?>
<form method="POST" action="http://<?=SITE_ROOT;?>/save">
  <? if( $page->exists() ): ?>
  <input name="page" type="hidden" value="<?=$page->title;?>" />
  <? endif;?>
  <fieldset><legend>Page Info</legend>
    <div><label for="pageDelete">Delete Page:</label>
      <input name="pageDelete" type="checkbox" value="1" />
    </div>
    <div><label for="pageTitle">Page Title:</label>
      <input name="pageTitle" type="text" size="30" maxlength="255" 
        id="pageTitle" value="<?=$page->title;?>" />
    </div>
    
    <div><label for="pageText">Page Text:</label>
      <textarea id="pageText" name="pageText" rows="40" cols="80"><?=$page->text;?></textarea>
    </div>
    <input type="submit" value="Submit" />
  </fieldset>
</form>

<? include('footer.php'); ?>
