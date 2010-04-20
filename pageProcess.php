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

$tagList = Tag::getTagList($page->title);
$pageTags = '';
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

<form method="post" name="editForm" action="<?=SITE_URI;?>/save">
<div id="PageEditForm">
  <input name="action" type="hidden" value="save" />
  <div id="form"><label for="pageTitle">Page Title:</label>
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
	<div id="tagBlock">
		<label>Tags:</label>
		<ul id="existingTagList">
		<? foreach($tagList as $tag): ?>
			<li onclick="javascript:tagClick(this);" 
				class="<?=$tag['hasTag']?'hasTag':'';?>"><?=$tag['name'];?></li>
			<? $pageTags.=$tag['hasTag']?$tag['name'].',':''; ?>
		<? endforeach; ?>
		</ul>
		<input type="hidden" name="tags" id="tags" value="<?=$pageTags;?>"/>
	</div>
	<div id="newTagBlock">
		<label for="textTags">New Tags:</label>
		<input type="text" name="textTags" id="textTags" size="75" />
		<span class="help" title="A comma-delimited list of new tags to create and add to this document. To add or remove an existing tag, click the above tag name.">?</span>
	</div>
</div>
</form>

<script type="text/javascript" charset="utf-8">
function tagClick(tagItem) {
	var tagField = document.getElementById('tags');
	var tagList = tagField.value;
	
	if( 'hasTag' == tagItem.className ) {
		tagItem.className = '';
		tagField.value = tagField.value.replace(tagItem.innerText+',','');
	}
	else {
		tagItem.className = 'hasTag';
		tagField.value += tagItem.innerText+',';
	}
}
</script>

<? endif; ?>
<? include('footer.php'); ?>
