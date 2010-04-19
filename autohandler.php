<?
/**
 * $Id$
 * 
 * @TODO:
 * - Add Markdown 'hints' to the page edit form (right hand side?)
 * - perhaps move list/new/edit links the right side, along with the
 * login form
 */
$s_time = microtime(true);
include(dirname(__FILE__).'/includes/inc/master.php');

$login = new LoginSession();
if( 'logout' == $action ) {
  loadPage("/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="generator" content="BBEdit 9.1" />
  <link rel="stylesheet" media="screen" 
		href="<?=SITE_URI;?>/includes/css/default.css" />
  
  <title>mdwiki</title>
</head>
<body>
<? include('header.php'); ?>
