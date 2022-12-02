<?php

spl_autoload_register('bso_autoloader');
function bso_autoloader($class) {
	$namespace = 'ZipSearch';
 
	if (strpos($class, $namespace) !== 0) {
		return;
	}
 
	$class = str_replace($namespace, '', $class);
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
 
	$directory = get_template_directory();
	$path = $directory . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class;
 
	if (file_exists($path)) {
		include($path);
	}
}