<?php

namespace backend\modules\LazyLoad\controllers;

use Yii;
use yii\web\Controller;

class LazyLoadController extends Controller {

    public function actionIndex($getDataFlag = false, $limit = 10, $offset = 0) {

        if ($getDataFlag) {
            $module = $this->module;
            $items = new $module->modelNamespace;
            $data = [
                'additionalData' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ]
            ];
            Yii::$app->response->format = 'json';
            //$data['items'] = $items->getAllItems($limit, $offset);
            $data['items'] = $items->find()->limit($limit)->offset($offset)->asArray()->all();
            return $data;
        } else {
            return $this->render('index');
        }
    }
}
