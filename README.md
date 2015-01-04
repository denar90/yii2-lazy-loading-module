Lazy loading Module for Yii2
========================
Yii2 module for content lazy loading

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
```
