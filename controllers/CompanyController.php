<?php

namespace app\controllers;

use app\models\Profile;
use Yii;
use app\models\Company;
use app\models\CompanySearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getTemplates(),
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays Company Templates
     * @param $id
     * @return string
     */
    public function actionTemplateIndex($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getTemplates(),
        ]);

        return $this->render('template-index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays variables tied to one or all Company template(s)
     * @param $id
     * @param null $date
     * @param null $template_id
     * @return string
     */
    public function actionVarIndex($id, $template_id = null, $date = null)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getVars($template_id),
        ]);

        return $this->render('var-index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVarEdit($id, $var_id, $date = null)
    {

    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        $profiles = ArrayHelper::map(Profile::find()->select('id, name')->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $profiles = ArrayHelper::map(Profile::find()->select('id, name')->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Deletes an existing Company model.
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
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
