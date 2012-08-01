<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;
use Nette\Config\Compiler;


// Load Nette Framework
require LIBS_DIR . '/autoload.php';


// Configure application
//$configurator = new Nette\Config\Configurator;
require_once APP_DIR . '/model/Configurator.php';
$configurator = new Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
//	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Setup router
$container->router[] = new \Nette\Application\Routers\SimpleRouter('Homepage:default');
//$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
//$container->router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');


// Configure and run the application!
$container->application->run();
