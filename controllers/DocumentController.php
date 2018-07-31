<?php

namespace app\controllers;

use app\models\Document;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
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

    public function actionMake($id)
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

    public function actionSend($id)
    {
        $model = $this->findModel($id);
        if (empty($to = $model->company->email)) {
            throw new BadRequestHttpException("У организации \"{$model->company->name}\" не задан e-mail адрес.");
        }
        $mailer = Yii::$app->mailer;
        $fileName = $model->template->getPdfPath($model->company, $model, false);
        $filePath = $model->template->getPdfPath($model->company, $model);
        $message = $mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($model->company->email)
            ->setSubject(mb_substr($fileName, 0, mb_strlen($fileName) - 4))
            ->setHtmlBody(Html::tag('p', Yii::t('app', 'See attachment')))
            ->attach($filePath, ['fileName' => $fileName]);
        if ($message->send()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Message sent successfully.'));
            $model->status = Document::STATUS_SENT;
            $model->sent_at = date('Y-m-d H:i:s');
            $model->save();
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Error occurred while sending message.'));
        }

        return $this->redirect(['view', 'id' => $id]);
    }
}
