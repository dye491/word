<?php

namespace app\controllers;

use app\models\Company;
use Yii;
use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models for given company.
     * @param $company_id integer
     * @param $date string|null current date
     * @return mixed
     */
    public function actionIndex($company_id, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        $company = $this->findCompany($company_id);

        $dataProvider = new ActiveDataProvider([
            'query' => Employee::find()->where(['company_id' => $company_id])
                ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
                ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'company' => $company,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $company_id integer
     * @return mixed
     */
    public function actionCreate($company_id)
    {
        $curDate = (new \DateTime())->format('Y-m-d');
        $model = new Employee(['company_id' => $company_id, 'start_date' => $curDate]);
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
     * Updates an existing Employee model.
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
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findCompany($company_id)
    {
        if (($model = Company::findOne($company_id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
