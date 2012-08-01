<?php

use Nette\Config\Helpers;
use Nette\Config\Compiler;


/**
 * Little bit better configurator
 *
 * @author Jan Dolecek <juzna.cz@gmail.com>
 */
class Configurator extends Nette\Config\Configurator
{
	/** @var array for easy access in registerSectionX methods */
	private $config;

	/** @var Compiler for easy access in registerSectionX methods */
	private $compiler;



	/**
	 * Copied from Nette's configurator
	 */
	protected function buildContainer(& $dependencies = NULL)
	{
		$loader = $this->createLoader();
		$config = array();
		$code = "<?php\n";
		foreach ($this->files as $tmp) {
			list($file, $section) = $tmp;
			$config = Helpers::merge($loader->load($file, $section), $config);
			$code .= "// source: $file $section\n";
		}
		$code .= "\n";

		$this->checkCompatibility($config);

		if (!isset($config['parameters'])) {
			$config['parameters'] = array();
		}
		$config['parameters'] = Helpers::merge($config['parameters'], $this->parameters);

		$compiler = $this->createCompiler();

		// only change HERE!
		$this->registerAddons($compiler, $config);
		unset($config['addons']);

		$this->onCompile($this, $compiler);

		$code .= $compiler->compile(
			$config,
			$this->parameters['container']['class'],
			$config['parameters']['container']['parent']
		);
		$dependencies = array_merge($loader->getDependencies(), $this->parameters['debugMode'] ? $compiler->getContainerBuilder()->getDependencies() : array());
		return $code;
	}



	/**
	 * Register addons
	 *
	 * @param Nette\Config\Compiler $compiler
	 * @param array $config
	 * @throws Nette\InvalidStateException
	 */
	protected function registerAddons(Compiler $compiler, array & $config)
	{
		if ( ! isset($config['addons'])) return;

		// for easy access
		$this->compiler = $compiler;
		$this->config = & $config;

		// register each section of each addon
		foreach ($config['addons'] as $addonName => $sections) {
			foreach ($sections as $sectionName => $params) {
				if (method_exists($this, $method = $this->formatMethodName($sectionName))) {
					$this->$method($addonName, $params);

				} else {
					\Nette\Diagnostics\Debugger::barDump("Unknown section '$sectionName' for addon '$addonName'");
				}
			}
		}
	}



	/*****************  addon register methods  *****************j*d*/



	protected function registerSectionConfigExtensions($addonName, $params)
	{
		foreach ($params as $extName => $className) {
			if ( ! class_exists($className)) throw new \Nette\InvalidStateException("Class '$className' not found for Addon '$addonName''");
			$this->compiler->addExtension($extName, new $className);
		}
	}



	protected function registerSectionAssets($addonName, $params)
	{
		foreach ($params as $assetType => $files) {
			$files = (array) $files;

			foreach ($files as $file) {
				if (!preg_match('~^[/%]~', $file)) $file = LIBS_DIR . "/$addonName/$file";
				$this->config['webLoader'][$assetType]['files'][] = $file;
			}

			// $config['webLoader'][$assetType]['files'] = array_merge($config['webLoader'][$assetType]['files'], $files);
		}
	}



	protected function registerSectionExtensionMethods($addonName, $params)
	{
		foreach($params as $ext) {
			\Nette\ObjectMixin::setExtensionMethod($ext['class'], $ext['method'], $ext['callback']);
		}
	}



	/*****************  utils  *****************j*d*/

	/**
	 * dash-and-dot-separated -> PascalCase:Presenter name.
	 * @param  string
	 * @return string
	 */
	private function formatMethodName($addonName)
	{
		$s = $addonName;
		$s = strtolower($s);
		$s = preg_replace('#([.-])(?=[a-z])#', '$1 ', $s);
		$s = ucwords($s);
		$s = str_replace('. ', ':', $s);
		$s = str_replace('- ', '', $s);
		return "registerSection$s";
	}

}
