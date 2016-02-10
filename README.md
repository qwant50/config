
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
"qwant50/config": "~2.*.*"
```

to the require section of your composer.json.


##Usage

####get all data 
```php
$configObj = new Config('/path/to/configs');
$allConfigs = $configObj->getData();
```

####get component's data
```php
$configObj = new Config('/path/to/configs');
$componentConfig = $configObj->getData('componentFileName');
$componentConfig['componentFileName'][$key] = $value;
$configObj->saveConfig('componentFileName');
```


