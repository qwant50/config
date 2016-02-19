
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
"qwant50/config": "~3.*.*"
```

to the require section of your composer.json.


##Usage

####get all data (php | ini | yaml formats). Result file name to config file must be /path/to/config/development or /path/to/config/production
```php
$config = new Config('/path/to/configs');
$allConfigs = $config->getData();
```

####get component's data
```php
$config = new Config('/path/to/configs');
$data = $config->getData($fullFileName);
var_dump($config->getBasePath());
var_dump($data);
```

####save configuration data into a file with `$key` filename (support only '.php' file)  
````php
$config->saveConfig($key);
````

or

````php
$config->saveConfig($key, fullFileName);
````


