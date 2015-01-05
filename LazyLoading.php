<?php
/**
 * @link https://github.com/denar90/yii2-lazy-loading-module
 * @copyright Copyright (c) 2014 denar90
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace denar90\lazyloading;

use yii\base\Module;
use yii\base\InvalidConfigException;

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

    /** @var string $mode Mode can be:
     * 'list' - only list of items
     * 'view' - only list of items with link on item view
     * 'edit' - only list of items with link on item view and on remove
     */
    public $mode = 'list';

    /**
     * @var array $additionalLinks List of controllers and views.
     *
     * For example,
     *
     * ```php
     * [
     *  'view' => [
     *      'controller' => 'site',
     *      'action' => 'itemview'
     *  ],
     *  'delete' => [
     *      'controller' => 'site',
     *      'action' => 'itemremove'
     *  ],
     *
     * ]
     * ```
     */
    public $additionalLinks = [];

    public function init() {
        parent::init();
        $this->validateParams();
    }

    /**
     * Validate params for mode.
     * @throws \yii\base\InvalidConfigException
     */
    private function validateParams() {
        switch($this->mode) {
            case 'list' :
                if (!empty($this->additionalLinks)) {
                    throw new InvalidConfigException("Property 'additionalLinks' should not be felt");
                }
                break;
            case 'view' :
                if (empty($this->additionalLinks)) {
                    throw new InvalidConfigException("Property 'additionalLinks' should be felt");
                } else {
                    if (!array_key_exists('view', $this->additionalLinks)) {
                        throw new InvalidConfigException("Property 'view' with 'controller' and 'action' should be added in 'additionalLinks'");
                    } else {
                        if (!isset($this->additionalLinks['view']['controller']) || !isset($this->additionalLinks['view']['action'])) {
                            throw new InvalidConfigException("Property 'controller' and 'action' should be added");
                        }
                    }
                }
                break;
            case 'edit' :
                if (empty($this->additionalLinks)) {
                    throw new InvalidConfigException("Property 'additionalLinks' should be felt");
                } else {
                    if (!array_key_exists('view', $this->additionalLinks)) {
                        throw new InvalidConfigException("Property 'view' with 'controller' and 'action' should be added in 'additionalLinks'");
                    } else if (!isset($this->additionalLinks['view']['controller']) || !isset($this->additionalLinks['view']['action'])) {
                        throw new InvalidConfigException("Property 'controller' and 'action' should be added");
                    } else if (!array_key_exists('delete', $this->additionalLinks)) {
                        throw new InvalidConfigException("Property 'delete' with 'controller' and 'action' should be added in 'additionalLinks'");
                    } else if (!isset($this->additionalLinks['delete']['controller']) || !isset($this->additionalLinks['delete']['action'])) {
                        throw new InvalidConfigException("Property 'controller' and 'action' should be added");
                    }
                }
                break;
        }
    }
}
