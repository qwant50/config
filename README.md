
ITCourses framework config component README
============

**ITCourses framework config component**



## Installation

The preferred way to install this ITCourses framework config component is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require "qwant50/config"
```

or add

```json
"qwant50/config": "~1.*.*"
```

to the require section of your composer.json.


## Usage

```php
$componentConfig = [];
$configObj = new Config(ROOT . '/src/configs');
$configObj->setConfigFile( 'componentConfigFileName.php');
$componentConfig['section'] = $configObj->loadConfig();
$componentConfig['section'] = 256;
$configObj->saveConfig($componentConfig);
```

###or

```php
$componentConfig = [];
$configObj = new Config(ROOT . '/src/configs');
$componentConfig['section'] = $configObj->loadConfig(componentConfigFileName.php);
$componentConfig['section' = 256;
$configObj->saveConfig($componentConfig);
```
