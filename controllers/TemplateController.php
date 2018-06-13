<?php

namespace app\controllers;

use app\models\Template;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TemplateController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Template::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Template::findOne(['id' => $id]);
        $vars = $model->getVariablesWithValues();

        if (\Yii::$app->request->isPost) {
            $postParams = \Yii::$app->request->post();
            $varKeys = array_map(function($item) {
                return isset($item['name']) ? $item['name'] : null;
            }, $model->getVariables()->asArray()->all());
            foreach ($postParams as $key => $postParam) {
                if (!in_array($key, $varKeys)) {
                    unset($postParams[$key]);
                }
            }
            $model->vars = Json::encode($postParams);
            if ($model->save()) {
                return $this->redirect('/template');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'vars'  => $vars,
        ]);
    }

}
