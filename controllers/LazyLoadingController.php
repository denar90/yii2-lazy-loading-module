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
                    'mode' => $module->mode
                ]
            ];

            //build additional urls depends on mode
            switch($module->mode) {
                case 'list':
                    break;
                case 'view':
                    $viewItemLink = $module->additionalLinks['view']['controller'] . '/' . $module->additionalLinks['view']['action'];
                    $data['additionalData']['urls'] = [
                        'viewItem' => Yii::$app->urlManager->createUrl([$viewItemLink]),
                    ];
                    break;
                case 'edit':
                    $viewItemLink = $module->additionalLinks['view']['controller'] . '/' . $module->additionalLinks['view']['action'];
                    $removeItemLink = $module->additionalLinks['delete']['controller'] . '/' . $module->additionalLinks['delete']['action'];
                    $data['additionalData']['urls'] = [
                        'viewItem' => Yii::$app->urlManager->createUrl([$viewItemLink]),
                        'removeItem' => Yii::$app->urlManager->createUrl([$removeItemLink])
                    ];
                    break;
            }

            //get data method from own model
            $data['items'] = $items->getAllItems($limit, $offset);
            Yii::$app->response->format = 'json';
            return $data;
        } else {
            return $this->render('index');
        }
    }
}
