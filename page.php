<?php
include('autohandler.php');
$page = new Page(@$_REQUEST['page']);

if( !$page->exists() ) {
  // redir or something
  echo "shit";
}

echo $page->render();

include('footer.php');
?>
