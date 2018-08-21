<?php

namespace app\controllers;

use app\helpers\DateHelper;
use app\models\Template;
use Yii;
use app\models\ProfileTemplate;
use app\models\ProfileTemplateSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileTemplateController implements the CRUD actions for ProfileTemplate model.
 */
class ProfileTemplateController extends Controller
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
     * Lists all ProfileTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProfileTemplate model.
     * @param integer $profile_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($profile_id, $template_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($profile_id, $template_id),
        ]);
    }

    /**
     * Creates a new ProfileTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $profile_id integer
     * @return mixed
     */
    public function actionCreate($profile_id)
    {
        $model = new ProfileTemplate(['profile_id' => $profile_id]);
        $ids = array_column(ProfileTemplate::find()
            ->select('template_id')
            ->where(['profile_id' => $profile_id])
            ->asArray()
            ->all(), 'template_id');
        $date = DateHelper::getCurDate();
        $templates = ArrayHelper::map(Template::find()
            ->where(['not', ['id' => $ids]])
            ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
            ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]])
            ->asArray()->all(),
            'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/profile/view', 'id' => $model->profile_id/*, 'template_id' => $model->template_id*/]);
        }

        return $this->render('create', [
            'model' => $model,
            'templates' => $templates,
        ]);
    }

    /**
     * Updates an existing ProfileTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $profile_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($profile_id, $template_id)
    {
        $model = $this->findModel($profile_id, $template_id);
        $templates = ArrayHelper::map(Template::find()
            ->where(['not', ['id' => array_column(ProfileTemplate::find()
                ->where(['profile_id' => $profile_id])->asArray()->all(), 'template_id')]])
            ->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'profile_id' => $model->profile_id, 'template_id' => $model->template_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'templates' => $templates,
        ]);
    }

    /**
     * Deletes an existing ProfileTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $profile_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($profile_id, $template_id)
    {
        $this->findModel($profile_id, $template_id)->delete();

        return $this->redirect(['/profile/view', 'id' => $profile_id]);
    }

    /**
     * Finds the ProfileTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $profile_id
     * @param integer $template_id
     * @return ProfileTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($profile_id, $template_id)
    {
        if (($model = ProfileTemplate::findOne(['profile_id' => $profile_id, 'template_id' => $template_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
