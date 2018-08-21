<?php

namespace app\controllers;

use app\helpers\DateHelper;
use app\models\Company;
use Yii;
use app\models\Ved;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VedController implements the CRUD actions for Ved model.
 */
class VedController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ved models.
     * @param $company_id integer
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($company_id/*, $date = null*/)
    {
        $company = $this->findCompany($company_id);

//        $date = (new \DateTime($date))->format('Y-m-d');
        $date = DateHelper::getCurDate();

        $dataProvider = new ActiveDataProvider([
            'query' => Ved::find()->where(['company_id' => $company_id])
                ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
                ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'company' => $company,
        ]);
    }

    /**
     * Creates a new Ved model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $company_id integer
     * @return mixed
     */
    public function actionCreate($company_id/*, $date = null*/)
    {
        $date = DateHelper::getCurDate();
        $model = new Ved(['company_id' => $company_id, 'start_date' => $date]);
        $company = $this->findCompany($company_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'company_id' => $company_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'company' => $company,
        ]);
    }

    /**
     * Updates an existing Ved model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $company = $this->findCompany($model->company_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'company_id' => $company->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'company' => $company,
        ]);
    }

    /**
     * Deletes an existing Ved model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        ($model = $this->findModel($id))->delete();

        return $this->redirect(['index', 'company_id' => $model->company_id]);
    }

    /**
     * Finds the Ved model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ved the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ved::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @param $id integer
     * @return Company
     * @throws NotFoundHttpException
     */
    protected function findCompany($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
