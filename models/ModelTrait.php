<?php

namespace app\models;

use yii\helpers\Json;
use yii\web\NotFoundHttpException;

trait ModelTrait
{
    /**
     * @param $name string
     * @param $callback callable
     * @throws NotFoundHttpException
     */
    protected function updateVar($name, $callback)
    {
        $curDate = date('Y-m-d');

        $var = Variable::findOne(['name' => $name]);
        if ($var === null) throw new NotFoundHttpException();

        $models = self::find()->where(['company_id' => $this->company_id])
            ->andWhere(['or', ['<=', 'start_date', $curDate], ['start_date' => null]])
            ->andWhere(['or', ['>=', 'end_date', $curDate], ['end_date' => null]])->all();
        $value = [];
        foreach ($models as $model) {
            $value[] = call_user_func($callback, $model);
        }
        $value = Json::encode($value);

        $oldValue = $var->getValue($this->company_id, $curDate);
        if ($oldValue !== null) {
            if ($oldValue->start_date == $curDate) {
                $oldValue->value = $value;
            }
            $oldValue->end_date = $var->getEndDate($this->company_id, $oldValue->start_date);
            $oldValue->save();
        }

        if ($oldValue === null || $oldValue->start_date != $curDate) {
            $newValue = new VarValue([
                'company_id' => $this->company_id,
                'var_id' => $var->id,
                'value' => $value,
                'start_date' => $curDate,
                'end_date' => $var->getEndDate($this->company_id, $curDate),
            ]);
            $newValue->save();
        }
    }
}