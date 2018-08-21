<?php

namespace app\models;

use app\helpers\DateHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use Yii;

trait ModelTrait
{
    protected $models;
    protected $curDate;

    protected function defaultCallback($model, $name)
    {
        $attributeMap = [
            'company_member_name_ip' => $model->fio_ip,
            'company_member_name_rp' => $model->fio_rp,
            'company_member_post_ip' => $model->position_ip,
            'company_member_post_rp' => $model->position_rp,
        ];

        return $attributeMap[$name];
    }

    /**
     * @param $vars array the keys of an array are variable names and the values are callback functions which returns
     * variable values. The callback signature is function($model, $name), where
     * $model is ActiveRecord instance and
     * $name is variable name
     */
    protected function updateVars($vars)
    {
//        $this->curDate = date('Y-m-d');
        $this->curDate = DateHelper::getCurDate();
        $this->models = self::find()->where(['company_id' => $this->company_id])
            ->andWhere(['or', ['<=', 'start_date', $this->curDate], ['start_date' => null]])
            ->andWhere(['or', ['>=', 'end_date', $this->curDate], ['end_date' => null]])->all();

        foreach ($vars as $name => $callback) {
            if (!$callback) $callback = [$this, 'defaultCallback'];
            $this->updateVar($name, $callback);
        }
    }

    /**
     * @param $name string
     * @param $callback callable
     * @throws NotFoundHttpException
     */
    protected function updateVar($name, $callback)
    {
        $var = Variable::findOne(['name' => $name]);
        if ($var === null) throw new NotFoundHttpException();
        $value = [];
        foreach ($this->models as $model) {
            $value[] = call_user_func($callback, $model, $name);
        }
        $value = Json::encode($value);

        $oldValue = $var->getValue($this->company_id, $this->curDate);
        if ($oldValue !== null) {
            if ($oldValue->start_date == $this->curDate) {
                $oldValue->value = $value;
            }
            $oldValue->end_date = $var->getEndDate($this->company_id, $oldValue->start_date);
            $oldValue->save();
        }

        if ($oldValue === null || $oldValue->start_date != $this->curDate) {
            $newValue = new VarValue([
                'company_id' => $this->company_id,
                'var_id' => $var->id,
                'value' => $value,
                'start_date' => $this->curDate,
                'end_date' => $var->getEndDate($this->company_id, $this->curDate),
            ]);
            $newValue->save();
        }
    }

    protected function formatDates()
    {
        if (isset($this->dirtyAttributes['start_date'])) {
            $this->start_date = Yii::$app->formatter->asDate($this->start_date, 'php:Y-m-d');
        }
        if (isset($this->dirtyAttributes['end_date'])) {
            $this->end_date = Yii::$app->formatter->asDate($this->end_date, 'php:Y-m-d');
        }
    }
}