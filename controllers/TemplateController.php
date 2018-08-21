<?php

namespace app\controllers;

use app\helpers\DateHelper;
use app\models\Branch;
use app\models\Event;
use app\models\Template;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class TemplateController extends Controller
{
    public function actionIndex($parent_id = null)
    {
        Url::remember(\Yii::$app->request->url);

        $parent_parent_id = $parent_id ? (($parent = (Template::findOne($parent_id))) ? $parent->parent_id : null) : null;

        $dataProvider = new ActiveDataProvider([
            'query' => Template::find()->where(['parent_id' => $parent_id]),
        ]);

        $path = Template::getPath($parent_id);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'parent_parent_id' => $parent_parent_id,
            'path' => $path,
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $model = new Template([
            'is_dir' => false,
            'parent_id' => $parent_id,
            'start_date' => DateHelper::getCurDate(),
        ]);
        if ($parent_id && (($parent = Template::findOne($parent_id)) !== null)) {
            $model->event_id = $parent->event_id;
            $model->branch = $parent->branch;
            $model->org_form = $parent->org_form;
            $model->emp_count = $parent->emp_count;
            $model->is_new = $parent->is_new;
        }

        if ($model->load(\Yii::$app->request->post())) {
            $uploadedFile = UploadedFile::getInstance($model, 'templateFile');
            $model->templateFile = $uploadedFile;
            if ($model->validate()) {
                if ($uploadedFile && $uploadedFile->error == UPLOAD_ERR_OK &&
                    $uploadedFile->saveAs(\Yii::getAlias(Template::TEMPLATE_DIR) .
                        DIRECTORY_SEPARATOR . $uploadedFile->baseName . '.' . $uploadedFile->extension)
                ) {
                    $model->file_name = $uploadedFile->baseName . '.' . $uploadedFile->extension;
                }
                if ($model->save(false)) {
                    return $this->goBack();
                }
            }
        }

        $events = ArrayHelper::map(Event::find()->all(), 'id', 'name', 'date');
        $branches = ArrayHelper::map(Branch::find()->asArray()->all(), 'id', 'name');
        return $this->render('create', [
            'model' => $model,
            'events' => $events,
            'branches' => $branches,
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
                $model->makeDocument();
//                $model->makePdf();
                $model->makePdfByApi();
                return $this->redirect('/template');
            }
        }

//        \Yii::error($model->errors);
        return $this->render('update', [
            'model' => $model,
            'vars' => $vars,
        ]);
    }

    public function actionEdit($id)
    {
        $model = self::findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getTemplateVars(),
        ]);

        $templateVars = $model->getTemplateVars()->joinWith('var')/*->select('var.name')*/
        ->asArray()->all();
        $undefinedVars = implode(', ', array_diff($model->getVarNamesFromTemplateFile(),
            array_column(array_column($templateVars, 'var'), 'name')));

        if ($model->load(\Yii::$app->request->post()) /*&& $model->validate()*/) {
            $uploadedFile = UploadedFile::getInstance($model, 'templateFile');
            $model->templateFile = $uploadedFile;
            if ($model->validate()) {
                if ($uploadedFile && $uploadedFile->error == UPLOAD_ERR_OK &&
                    $uploadedFile->saveAs(\Yii::getAlias(Template::TEMPLATE_DIR) .
                        DIRECTORY_SEPARATOR . $uploadedFile->baseName . '.' . $uploadedFile->extension)
                ) {
                    $model->file_name = $uploadedFile->baseName . '.' . $uploadedFile->extension;
                }
                if ($model->save(false)) {
                    return $this->goBack()/*redirect('/template')*/
                        ;
                }
            }
        }

        $events = ArrayHelper::map(Event::find()->all(), 'id', 'name', 'date');
        $branches = ArrayHelper::map(Branch::find()->asArray()->all(), 'id', 'name');
        return $this->render('edit', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'undefinedVars' => $undefinedVars,
            'events' => $events,
            'branches' => $branches,
        ]);
    }

    /**
     * @param $id
     * @param $template mixed whether to download template file. If null, then download document file
     * @return Response|bool
     */
    public function actionDownload($id, $template = null)
    {
        $model = self::findModel($id);

        if ($model) {
            $path = $template ? $model->getTemplatePath() : $model->getDocumentPath();
            if (!file_exists($path) || !is_file($path) ||
                pathinfo($path, PATHINFO_EXTENSION) !== 'docx')
                return false;

            return \Yii::$app->response->sendFile($path);
        }

        return false;
    }

    public function actionDownloadPdf($id)
    {
        $model = self::findModel($id);
        if ($model && $model->hasPdf()) {
            return \Yii::$app->response->sendFile($model->getPdfPath());
        }

        return false;
    }

    private static function findModel($id)
    {
        if (($model = Template::findOne(['id' => $id])) !== null) {
            return $model;
        };

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
