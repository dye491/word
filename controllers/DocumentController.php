<?php

namespace app\controllers;

use app\models\Document;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\web\Controller;

class DocumentController extends Controller
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

    /**
     * @param $id
     * @return null|Document
     * @throws NotFoundHttpException
     */
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
            $model->doc_path = $template->getDocumentPath($model->company, $model, false);
            $template->makePdfByUnoconv($model->company, $model);
//            $template->makePdf($model->company, $model);
            $model->pdf_path = $template->getPdfPath($model->company, $model, false);
            $model->status = Document::STATUS_READY;
            $model->save();
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Returns file in .docx format
     * @param $id document id
     * @throws NotFoundHttpException
     * @return Response
     */
    public function actionDownload($id)
    {
        $path = $this->getPath($id, 'getDocumentPath', 'docx');

        return Yii::$app->response->sendFile($path);
    }

    public function actionDownloadPdf($id)
    {
        $path = $this->getPath($id, 'getPdfPath', 'pdf');

        return Yii::$app->response->sendFile($path);
    }

    /**
     * @param $id
     * @param $method
     * @param $format
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function getPath($id, $method, $format)
    {
        $model = $this->findModel($id);
        $path = $model->template->$method($model->company, $model);

        if (!file_exists($path) || !is_file($path)
            || pathinfo($path, PATHINFO_EXTENSION) !== $format) {
            throw new NotFoundHttpException(Yii::t('app', 'File not found'));
        }

        return $path;
    }
}
