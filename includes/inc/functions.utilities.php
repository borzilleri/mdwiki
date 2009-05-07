<?php
/**
 * $Id$
 *
 */
 
/**
 * Dynamically load a class file on demand.
 *
 * @param string $class The name of the class to load.
 * @return bool
 */
function autoLoad($class) {
    $filename = 'class.'.strtolower($class).'.php';
    $file = dirname(__FILE__).'/'.$filename;
    if( !file_exists($file) ) {
        return false;
    }
    include($file);
    return true;
}

/**
 * Uses the Location header to redirect the user to a new URI.
 *
 * @param string $path The URI path to load.
 * @param bool $include_query whether to include the current QUERY_STRING.
 */
function loadPage($path, $include_query = false) {
    $http = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    // TODO Clean up query?
    $query = $_SERVER['QUERY_STRING'];    
    header("Location: {$http}://".SITE_ROOT.$path.($include_query?"?{$query}":""));
    exit;
}
?>
