<?php

namespace app\controllers;

use app\models\Template;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

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
        $model = self::findModel($id);
        $vars = $model->getVariablesWithValues();

        if (\Yii::$app->request->isPost) {
            $postParams = \Yii::$app->request->post();
            $varKeys = array_map(function ($item) {
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

    public function actionEdit($id)
    {
        $model = self::findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getVariables(),
        ]);

        if ($model->load(\Yii::$app->request->post()) /*&& $model->validate()*/) {
            $uploadedFile = UploadedFile::getInstance($model, 'templateFile');
            $model->templateFile = $uploadedFile;
            if ($model->validate()) {
                if ($uploadedFile->error == UPLOAD_ERR_OK &&
                    $uploadedFile->saveAs(\Yii::getAlias(Template::TEMPLATE_DIR) .
                        DIRECTORY_SEPARATOR . $uploadedFile->baseName . '.' . $uploadedFile->extension)
                ) {
                    $model->file_name = $uploadedFile->baseName . '.' . $uploadedFile->extension;
                }
                if ($model->save(false)) {
                    return $this->redirect('/template');
                }
            }
        }

        return $this->render('edit', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    private static function findModel($id)
    {
        return Template::findOne(['id' => $id]);
    }
}
