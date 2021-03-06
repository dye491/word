<?php

namespace app\controllers;

use Yii;
use app\models\Template;
use app\models\Variable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VariableController implements the CRUD actions for Variable model.
 */
class VariableController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new Variable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param $template_id integer
     * @return mixed
     */
    public function actionCreate($template_id)
    {
        $model = new Variable();
        $model->template_id = $template_id;
        $template = Template::findOne(['id' => $template_id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['template/edit', 'id' => $template_id]);
        }

        return $this->render('create', [
            'model'    => $model,
            'template' => $template,
        ]);
    }

    /**
     * Updates an existing Variable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $template = Template::findOne(['id' => $model->template_id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['template/edit', 'id' => $template->id]);
        }

        return $this->render('update', [
            'model'    => $model,
            'template' => $template,
        ]);
    }

    /**
     * Deletes an existing Variable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $template = Template::findOne(['id' => $model->template_id]);
        $model->delete();

        return $this->redirect(['template/edit', 'id' => $template->id]);
    }

    /**
     * Finds the Variable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Variable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Variable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
