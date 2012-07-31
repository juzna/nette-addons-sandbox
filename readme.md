# Nette Sandbox with addons

This is an experiment which evaluates how easy/hard it is to add addons to a sample Nette project.
Please join the [discussion](http://forum.nette.org/cs/10875-nette-addons-konvence-a-architektura-aplikace).



## Custom Installer

Nette Addons should have set `type=nette-addon` in `composer.json` file and Nette related info in section `extra`.
Here is an [example](https://github.com/juzna/kdyby-CurlExtension/blob/juznovo/composer.json) of such file.

Custom installer makes copies this section into `app/config/addons.neon` file which is then processed by the app (not yet, wrk in progress).



## TODO
- custom-installer to update addons.neon
- form extensions support
- copy assets - images
