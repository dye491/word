<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ved".
 *
 * @property int $id
 * @property string $code
 * @property string $text
 * @property int $company_id
 * @property string $start_date
 * @property string $end_date
 *
 * @property Company $company
 */
class Ved extends ActiveRecord
{
    use ModelTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ved';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'text', 'company_id'], 'required'],
            [['company_id'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:d.m.Y'],
            [['code', 'text'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'text' => Yii::t('app', 'Text'),
            'company_id' => Yii::t('app', 'Company ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function beforeSave($insert)
    {
        if ($this->dirtyAttributes['start_date']) {
            $this->start_date = Yii::$app->formatter->asDate($this->start_date, 'php:Y-m-d');
        }
        if ($this->dirtyAttributes['end_date']) {
            $this->end_date = Yii::$app->formatter->asDate($this->end_date, 'php:Y-m-d');
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->updateVars([
            'OKVED' => function ($model) {
                return $model->text . ' (код ОКВЭД ' . $model->code . ')';
            },
        ]);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $this->updateVar('OKVED', function ($model) {
            return $model->text . ' (код ОКВЭД ' . $model->code . ')';
        });
    }
}
