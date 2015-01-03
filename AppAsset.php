<?php

namespace denar90\LazyLoad;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/denar90/LazyLoad/assets';
    public $css = [
		'css/lazyloading.css',
    ];
    public $js = [
        'http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.js',
		'js/lazyLoading.js'
    ];
}
