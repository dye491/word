<?php

namespace app\controllers;

use app\models\Document;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class DocumentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    private function findModel($id)
    {
        if (($model = Document::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionMakeDoc($id)
    {
        $model = $this->findModel($id);
        $template = $model->template;
        if ($template->makeDocument($model->company, $model)) {
            $model->doc_path = $template->getDocumentPath($model->company, $model);
            $model->pdf_path = $template->makePdfByUnoconv($model->doc_path);
            $model->status = Document::STATUS_READY;
            $model->save();
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Returns file in .docx format
     * @param $id document id
     * @throws NotFoundHttpException
     * @return Response
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        if (!file_exists($model->doc_path) || !is_file($model->doc_path)
            || pathinfo($model->doc_path, PATHINFO_EXTENSION) !== 'docx') {
            throw new NotFoundHttpException(Yii::t('app', 'File not found'));
        }

        return Yii::$app->response->sendFile($model->doc_path);
    }
}
