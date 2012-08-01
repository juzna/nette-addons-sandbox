<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;
use Nette\Config\Compiler;
use Nette\Config\Configurator;


// Load Nette Framework
require LIBS_DIR . '/autoload.php';


// Configure application
$configurator = new Nette\Config\Configurator;

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

// Register Addons
$configurator->onCompile[] = function(Configurator $sender, Compiler $compiler) {
	$config = & $sender->config; // HACK: nette hack

	if (isset($config['addons'])) {
		foreach ($config['addons'] as $name => $params) {

			// Attach to DIC
			if (isset($params['config-extensions'])) foreach ($params['config-extensions'] as $extName => $className) {
				if ( ! class_exists($className)) throw new \Nette\InvalidStateException("Class '$className' not found for Addon $name'");
				$compiler->addExtension($extName, new $className);
			}


			// Assets
			if (isset($params['assets'])) foreach ($params['assets'] as $assetType => $files) {
				foreach ($files as $file) {
					if (!preg_match('~^[/%]~', $file)) $file = LIBS_DIR . "/$name/$file";
					$config['webLoader'][$assetType]['files'][] = $file;
				}

				// $config['webLoader'][$assetType]['files'] = array_merge($config['webLoader'][$assetType]['files'], $files);
			}
		}
	}

	unset ($config['addons']);
};

// Date picker
use Nette\Forms\Container;
Container::extensionMethod('addDatePicker', function (Container $container, $name, $label = NULL) {
	return $container[$name] = new JanTvrdik\Components\DatePicker($label);
});


$container = $configurator->createContainer();

// Setup router
$container->router[] = new \Nette\Application\Routers\SimpleRouter('Homepage:default');
//$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
//$container->router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');


// Configure and run the application!
$container->application->run();
