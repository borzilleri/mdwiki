<?php
include('autohandler.php');
$page = new Page(@$_REQUEST['page']);

if( !$page->exists() ) {
  // redir or something
  loadPage('/add/'.@$_REQUEST['page']);
  echo "shit";
}

echo $page->render();
if( !empty($page->tags) )	include('pageTags.php');

include('footer.php');
?>