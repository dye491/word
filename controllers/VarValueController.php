<?php

namespace app\controllers;

use app\models\Variable;
use Yii;
use app\models\VarValue;
use app\models\VarValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VarValueController implements the CRUD actions for VarValue model.
 */
class VarValueController extends Controller
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
     * Lists all VarValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VarValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VarValue model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VarValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VarValue();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VarValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VarValue model.
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
     * Finds the VarValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VarValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VarValue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionEdit($company_id, $var_id, $date = null)
    {
        if (($variable = Variable::findOne(['id' => $var_id])) === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $model = $variable->getValue($company_id, $date);
        if ($model === null) {
            $model = new VarValue(['company_id' => $company_id, 'var_id' => $var_id, 'start_date' => $date]);
        }

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            if ($model->isNewRecord) {
//                if ($model->save()) return $this->redirect(['company/var-index', 'id' => $company_id]);
                if ($model->save()) return $this->goBack();
            } else {
                if (isset($model->dirtyAttributes['value'])) {
                    if ($date === null) $date = (new \DateTime())->format('Y-m-d');
                    $new_model = new VarValue($model->attributes);
                    $new_model->start_date = $date;
                    $new_model->id = null;
                    $model->end_date = $date;
                    $model->value = $model->oldAttributes['value'];
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->save() && $new_model->save()) {
                            $transaction->commit();
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                }
                return $this->goBack();
//                return $this->redirect(['company/var-index', 'id' => $company_id]);
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }
}
