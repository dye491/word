<?php

namespace app\controllers;

use app\helpers\DateHelper;
use app\models\TemplateVar;
use app\models\Company;
use Yii;
use app\models\VarValue;
use app\models\VarValueSearch;
use yii\base\Model;
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

    /*    public function actionEdit($company_id, $var_id, $date = null)
        {
            if (($variable = Variable::findOne(['id' => $var_id])) === null) {
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }

            if ($date === null) $date = (new \DateTime())->format('Y-m-d');
            $model = $variable->getValue($company_id, $date);
            if ($model === null) {
                $model = new VarValue(['company_id' => $company_id, 'var_id' => $var_id, 'start_date' => $date]);
            }

            if ($model->load(Yii::$app->request->post())) {
                if ($model->isNewRecord || $model->start_date == $date) {
                    if ($model->save()) return $this->goBack();
                } else {
                    if (isset($model->dirtyAttributes['value'])) {
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
                }
            }

            return $this->render('edit', [
                'model' => $model,
            ]);
        }*/
    public function actionEdit($company_id, $date = null)
    {
        if ($date === null) $date = DateHelper::getCurDate();

        /**
         * @var $company \app\models\Company
         */
        $company = $this->findCompany($company_id);
        $variables = $company->getVarsQuery(null, $date)
            ->joinWith('var')
            ->andWhere(['variable.group' => null])
            ->all();

        $values = [];
        foreach ($variables as $variable) {
            /**
             * @var $variable TemplateVar
             */
            if (($value = $variable->var->getValue($company_id, $date)) === null) {
                $value = new VarValue([
                    'company_id' => $company_id,
                    'var_id' => $variable->var_id,
                    'start_date' => $date,
                    'end_date' => $variable->var->getEndDate($company_id, $date),
                ]);
            }
            $values[$variable->var->name] = $value;
        }

        if (Model::loadMultiple($values, Yii::$app->request->post()) && Model::validateMultiple($values)) {
            foreach ($values as $value) {
                /**
                 * @var $value VarValue
                 */
                if ($value->isNewRecord || $value->start_date == $date) {
                    $value->save(false);
                } else {
                    if (isset($value->dirtyAttributes['value'])) {
                        $newValue = new VarValue($value->attributes);
                        $newValue->start_date = $date;
                        $newValue->id = null;
                        $value->end_date = DateHelper::getPrevDate($date);
                        $value->value = $value->oldAttributes['value'];
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                            if ($value->save(false) && $newValue->save(false)) {
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
                }
            }
            return $this->goBack();
        }

        return $this->render('edit', [
            'values' => $values,
            'company' => $company,
        ]);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $id
     * @return null|Company
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
