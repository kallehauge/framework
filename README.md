Introduction
---
This is a basic PHP-framework that I have started due to school purposes and learning. The project will slowly expand as I face more and more demands from my education since I plan to use it in my projects.

_**Disclaimer:** this isn’t finished software. If you’re looking for a framework to use for commercial purposes then I suggest you look at something like CodeIgniter, CakepPHP, Zend or Symfony instead._

Capabilities
---
* MVC structure.
* Choose between: PDO or MySQLi.
* Router: handles up to 5 arguments per route.
* Helpers: url.

Installation
---
  1. Download / clone repo.
  2. Edit "./config.php".
  3. You're done.

Router
---
This is an example of how the paths for the router could look like. Stars symbolises variable values and will be parsed to the provided function as arguments.

    $router['test'] = "index/test";
    $router['test/*'] = "index/test/*";
    $router['test/*/*'] = "index/test/*/*/";
    $router['test/*/*/*'] = "index/test/*/*/*";

Tree structure
---

    |-- application
    |   |-- controllers
    |   |-- models
    |   |-- views
    |-- public
    |   |-- css
    |   |-- js
    |-- system

Contributing
---
The project in itself have no real future plans nor will it be abandoned completely. I'm slowly adding to it and improving it over time when I need more for school purposes since I will continue to use it for exams projects.

With that said; if you have any improvements you feel like pushing, then I’ll be more than happy to accept them if they help in any way.

License
---
[MIT License](https://github.com/kallehauge/framework/blob/master/LICENSE)
