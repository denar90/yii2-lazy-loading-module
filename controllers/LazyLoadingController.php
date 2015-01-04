<?php
/**
 * @link https://github.com/denar90/yii2-lazy-loading-module
 * @copyright Copyright (c) 2014 denar90
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace denar90\lazyloading\controllers;

use Yii;
use yii\web\Controller;

class LazyLoadingController extends Controller {

    /**
     * Action for getting data.
     * @param boolean $getDataFlag
     * @param string $limit How many items get from table
     * @param string $offset
     * @return json $data Data with items
     */
    public function actionIndex($getDataFlag = false, $limit = 10, $offset = 0) {
        if ($getDataFlag) {
            $module = $this->module;
            //create instance of model with items
            $items = new $module->modelNamespace;
            $data = [
                'additionalData' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ]
            ];
            //get data method from own model
            $data['items'] = $items->getAllItems($limit, $offset);
            Yii::$app->response->format = 'json';
            return $data;
        } else {
            return $this->render('index');
        }
    }
}
