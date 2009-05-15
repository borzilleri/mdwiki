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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="generator" content="BBEdit 9.1" />
	<link rel="stylesheet" media="screen" charset="utf-8"
	  href="http://<?=SITE_ROOT;?>/includes/css/default.css" />

	<title>mdwiki</title>
</head>
<body>
<? include('header.php'); ?>
