<?php

namespace app\controllers;

use app\models\Template;
use app\models\Variable;
use Yii;
use app\models\TemplateVar;
use app\models\TemplateVarSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateVarController implements the CRUD actions for TemplateVar model.
 */
class TemplateVarController extends Controller
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
     * Lists all TemplateVar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateVarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TemplateVar model.
     * @param integer $var_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($var_id, $template_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($var_id, $template_id),
        ]);
    }

    /**
     * Creates a new TemplateVar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param $template_id string
     * @return mixed
     */
    public function actionCreate($template_id)
    {
        $model = new TemplateVar(['template_id' => $template_id]);
        $template = Template::findOne(['id' => $template_id]);
        $templateVars = $template->getTemplateVars()->select('var_id')->asArray()->all();
        $ids = [];
        foreach ($templateVars as $templateVar) {
            $ids[] = $templateVar['var_id'];
        }
        $varList = Variable::find()
            ->select(['id', 'CONCAT(name, ": ", label) as label'])
            ->where(['not', ['id' => $ids]])->asArray()->all();
        $varList = ArrayHelper::map($varList, 'id', 'label');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/template/edit', 'id' => $model->template_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'varList' => $varList,
        ]);
    }

    /**
     * Updates an existing TemplateVar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $var_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($var_id, $template_id)
    {
        $model = $this->findModel($var_id, $template_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/template/edit', 'id' => $model->template_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'varList' => [],
        ]);
    }

    /**
     * Deletes an existing TemplateVar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $var_id
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($var_id, $template_id)
    {
        $this->findModel($var_id, $template_id)->delete();

        return $this->redirect(['/template/edit', 'id' => $template_id]);
    }

    /**
     * Finds the TemplateVar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $var_id
     * @param integer $template_id
     * @return TemplateVar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($var_id, $template_id)
    {
        if (($model = TemplateVar::findOne(['var_id' => $var_id, 'template_id' => $template_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
    }
}
