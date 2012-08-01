# Nette Sandbox with addons
This is an experiment which evaluates how easy/hard it is to add addons to a sample Nette project.
Please join the [discussion](http://forum.nette.org/cs/10875-nette-addons-konvence-a-architektura-aplikace).



## Overview
Supported Nette Addons are configured to `type=nette-addon` in `composer.json` file and Nette related info in section `extra`.
Here is an [example](https://github.com/juzna/kdyby-CurlExtension/blob/juznovo/composer.json) of such addon.


If you want to install an supported Addon, just put it as a requirement to your project's `composer.json`.


## How it works?
Custom installer copies the addon section from composer.json to `app/config/addons.neon` file which is then processed by the app.
For more details, see [nette/addon-installer](https://github.com/juzna/nette-addon-installer) which does half of the hard work.



## Try it yourself

Clone and run this project:

```
git clone git://github.com/juzna/nette-addons-sandbox.git sandbox
cd sandbox/
chmod 0777 temp log
composer install
```

Now the sandbox should work. To add an Addon, edit `composer.json` and add the addon. Example:
```js
{
	...
	"require": {
		"php": ">= 5.3.0",
		"nette/nette": "2.0.*",
		"JanMarek/WebLoader": "dev-juznovo",
		"juzna/nette-visual-paginator": "@dev",
	},
	...
}
```

Run `composer update` to download newly configured dependencies. [nette/addon-installer](https://github.com/juzna/nette-addon-installer) should
 handle all the hard work with setting up your addons and making them ready for you.



## Issues
There is common place for issues in the [nette/addon-installer](https://github.com/juzna/nette-addon-installer/issues) repository.
