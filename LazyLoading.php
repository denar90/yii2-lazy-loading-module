<?php
/**
 * @link https://github.com/denar90/yii2-lazy-loading-module
 * @copyright Copyright (c) 2014 denar90
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace denar90\lazyloading;

use yii\base\Module;

/**
 * Yii2 module for content lazy loading.
 *
 * @author denar90
 * @package denar90\lazyloading
 */
class LazyLoading extends Module {

    public $controllerNamespace = 'denar90\lazyloading\controllers';

    /** @var string $modelNamespace Namespace of your items model*/
    public $modelNamespace = '';

    public function init() {
        parent::init();
    }
}
