<?php
/**
 * $Id$
 */
include('config.master.php');
include('functions.utilities.php');
include('markdown.php');

/**
 * Setup autoloading of classes
 */
spl_autoload_register('autoLoad');

define("BASE_PATH", dirname($_SERVER['SCRIPT_NAME']));
define("HTTP_HOST", $_SERVER['HTTP_HOST']);
define("SITE_ROOT", HTTP_HOST.BASE_PATH);
$GLOBALS['action'] = empty($_REQUEST['action']) ? null : strtolower($_REQUEST['action']);

/**
 * Start the session and begin output buffering.
 *
 * We use output buffering to allow us to perform header redirects 
 * mid-page processing.
 */
session_start();
ob_start();
?>
