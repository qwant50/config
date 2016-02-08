
ITCourses framework config component README
============

**ITCourses framework config component**



## Installation

The preferred way to install this ITCourses framework config component is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require "qwant/config"
```

or add

```json
"qwant/config": "~1.*.*"
```

to the require section of your composer.json.


## Usage

```php
$configObj = new Config(ROOT . '/src/configs');
$configObj->setConfigFile( 'componentConfigFileName.php');
$componentConfig = $configObj->loadConfig();
$componentConfig = 256;
$configObj->saveConfig($componentConfig);
```

###or

```php
$configObj = new Config(ROOT . '/src/configs');
$componentConfig = $configObj->loadConfig(componentConfigFileName.php);
$componentConfig = 256;
$configObj->saveConfig($componentConfig);
```
