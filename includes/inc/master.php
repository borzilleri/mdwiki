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

/**
 * Globals && Constant definitions
 */

/**
 * Our current domain.
 * DOES NOT have trailing slash.
 */
define("HTTP_HOST", $_SERVER['HTTP_HOST']);

/**
 * Our relative path under the domain
 * Contains an intial slash, regardless, if that is the entirety of the path
 * it also becomes the trailing slash.
 */
define("BASE_PATH", dirname($_SERVER['SCRIPT_NAME']));

/**
 * Root URI for the site, a combination of the above two constants.
 */
define("SITE_URI", 'http://'.HTTP_HOST.BASE_PATH.(strlen(BASE_PATH)>1?'/':''));

/**
 *
 * @name $action
 * @global string
 */
$GLOBALS['action'] = empty($_REQUEST['action']) ? 
  null : strtolower($_REQUEST['action']);

/**
 * Start the session and begin output buffering.
 *
 * We use output buffering to allow us to perform header redirects 
 * mid-page processing.
 */
session_start();
ob_start();
?>
