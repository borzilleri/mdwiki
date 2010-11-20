<?php
require_once('Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register(array('Doctrine', 'modelsAutoload'));

$doctrineSetup = function() {
	$manager = Doctrine_Manager::getInstance();
	// Set Doctrine attributes.
	// TODO: Move these to a config file, or something?
	$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
	$manager->setAttribute(Doctrine::ATTR_VALIDATE, Doctrine::VALIDATE_ALL);
	$manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);
	$manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
	$manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
	
	$connection = Doctrine_Manager::connection(sliMVC::config('doctrine.dsn'));
};
$doctrineSetup();
unset($doctrineSetup);
Doctrine::loadModels(sliMVC::config('doctrine.model_path'));
?>