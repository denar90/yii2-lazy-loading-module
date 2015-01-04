<?php
/**
 * @link https://github.com/denar90/yii2-lazy-loading-module
 * @copyright Copyright (c) 2014 denar90
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace denar90\lazyloading;

use yii\web\AssetBundle;

class LazyLoadingAssets extends AssetBundle {
    public $sourcePath = '@denar90/lazyloading/assets';
    public $css = [
		'css/lazyloading.css',
    ];
    public $js = [
        'http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.js',
		'js/lazyLoading.js'
    ];
}
