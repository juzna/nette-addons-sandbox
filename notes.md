# How to start new project with Nette

- composer create-project sandbox
- fix autoloader + omit robot
- privileges temp/ + log/
- WebLoader
  - install WebLoader as composer package - custom installer may suggest how to use (unless it is being already used)
  - create component in BasePresneter
  - use it in template
  - create www/temp/ with write privileges
  - register it as a service
  TODO: WebLoader should add CompilerExtension


- VisualPaginator
  - add visual-paginator to composer.json
  - add optional css to webLoader - custom installer may ask whether to include it or not
  TODO: suggest WebLoader; when available, register itself into config.neon in section webLoader.css.files (with a comment "autoinstalled by composer")


- NiftyGrid
  - add to composer.json
  - optional webloader dependancy should ask whether to register resources (if webloader is available)
  - show basic info how to use (?)
  - requires netteForms.js, jquery, jquery-UI - !!! how to solve these dependencies?
  - requires custom js file
  - custom CSS - refers to images in the same directory, paths must be preserved/fixed
  - custom images !!! - WebLoader won't help here


 - Kdyby CURL extension
   - add to composer.json
   - register CompilerExtension - in bootstrap in onCompile[]


- DatePicker+ (by JanTvrdik)
 - add to composer.json
 - register in bootstrap.php using Container::extensionMethod
 

 - DatePaginator
  - depends on DatePicker+
  - add to composer
