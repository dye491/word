<?php

namespace app\controllers;

use app\models\Company;
use app\models\Document;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\web\Controller;

class DocumentController extends Controller
{
    /**
     * Displays all documents for the given company
     * @param $company_id
     * @param string|null $date
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($company_id, $date = null)
    {
        if (($company = Company::findOne(['id' => $company_id])) === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        Url::remember(Yii::$app->request->url);

        if ($date === null) $date = date('Y-m-d');
        $dataProvider = new ActiveDataProvider([
            'query' => Document::find()->with('template')
                ->where(['company_id' => $company_id])
                ->andWhere(['<=', 'date', $date]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'company' => $company,
        ]);
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
//            if ($template->makePdfByApi($model->company, $model))
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
        $path = $this->getPath($id, 'doc_path');

        return Yii::$app->response->sendFile($path);
    }

    public function actionDownloadPdf($id)
    {
        $path = $this->getPath($id, 'pdf_path');

        return Yii::$app->response->sendFile($path);
    }

    /**
     * @param $id
     * @param $field
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function getPath($id, $field)
    {
        $model = $this->findModel($id);
        $path = Yii::getAlias('@app/output') . DIRECTORY_SEPARATOR . $model->template_id;
        $path .= DIRECTORY_SEPARATOR . $model->company_id . DIRECTORY_SEPARATOR . $model->id;
        $path .= DIRECTORY_SEPARATOR . $model->$field;
        Yii::info("path = {$path}");

        if (!file_exists($path) || !is_file($path)) {
            throw new NotFoundHttpException(Yii::t('app', 'File not found'));
        }

        return $path;
    }

    public function actionSend($id)
    {
        $model = $this->findModel($id);

        if (empty($to = $model->company->email))
            throw new BadRequestHttpException("У организации \"{$model->company->name}\" не задан e-mail адрес.");

        if (empty($model->company->last_payment))
            throw new BadRequestHttpException("У организации \"{$model->company->name}\" отсутствует оплата сервиса. Отправка невозможна.");
        elseif (($end_date = (new \DateTime($model->company->last_payment))
                ->add(new \DateInterval("P1Y")))
                ->format('Y-m-d') < date('Y-m-d')) {
            throw new BadRequestHttpException("У организации \"{$model->company->name}\" оплата сервиса была более 1 года назад. Отправка невозможна.");
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
