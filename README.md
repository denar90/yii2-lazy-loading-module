Lazy loading Module for Yii2
========================
Yii2 module for content lazy loading

Main features:
* showing items mode. Probability to use both in backend and in frontend
* flexible module configuration

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

* Either run

```
php composer.phar require --prefer-dist "denar90/yii2-lazy-loading-module": "dev-master"
```
or add

```json
"denar90/yii2-lazy-loading-module": "dev-master"
```

to the require section of your application's `composer.json` file.

* Add a new module in `modules` section of your application's configuration file, for example:

```php
'modules' => [
    'lazyloading' => [
		'class' => 'denar90\lazyloading\LazyLoading',
		'modelNamespace' => '\app\models\Items' \\ your model with items
	],
],
```
This configuration will show only list, without links on each item. Mode by default is 'list'.

* Mode 'view' configurations, for example:

```php
'modules' => [
    'lazyloading' => [
		'class' => 'denar90\lazyloading\LazyLoading',
		'modelNamespace' => '\app\models\Items', \\ your model with items
		'mode' => 'edit',
		'additionalLinks' => [
			'view' => [
				'controller' => 'yourController',
				'action' => 'yourViewAction'
			]
		]
	],
],
```

* Mode 'edit' configurations, for example:

```php
'modules' => [
    'lazyloading' => [
		'class' => 'denar90\lazyloading\LazyLoading',
		'modelNamespace' => '\app\models\Items', \\ your model with items
		'mode' => 'edit',
		'additionalLinks' => [
			'view' => [
				'controller' => 'yourController',
				'action' => 'yourViewAction'
			],
			'delete' => [
				'controller' => 'yourController',
				'action' => 'yourDeleteItemAction'
			]
		]
	],
],
```
Usage
-----
In your action call module

For example:

```php
...
 	public function actionIndex() {
		$lazyLoading = Yii::$app->getModule('lazyloading');
		return $lazyLoading->runAction('lazyloading/index');
	}
...
```

Also you should create method in your model for getting list of items.
For example:

```php

namespace app\models\Items;
...
 	public function getAllItems($limit = 10, $offset = 0) {
		return $this->find()->offset($offset)->limit($limit)->all();
	}
...

```