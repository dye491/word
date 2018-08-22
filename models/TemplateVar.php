<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_var".
 *
 * @property int $var_id
 * @property int $template_id
 * @property int $required
 * @property string $start_date
 * @property string $end_date
 *
 * @property Template $template
 * @property Variable $var
 */
class TemplateVar extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template_var';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['var_id', 'template_id'], 'required'],
            [['var_id', 'template_id', 'required'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:d.m.Y'],
            [['var_id', 'template_id'], 'unique', 'targetAttribute' => ['var_id', 'template_id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
            [['var_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variable::className(), 'targetAttribute' => ['var_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'var_id' => 'Var ID',
            'template_id' => 'ID шаблона',
            'required' => 'Обязательна',
            'start_date' => 'Дата начала действия',
            'end_date' => 'Дата окончания действия',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(Variable::className(), ['id' => 'var_id']);
    }

    /**
     * @inheritdoc
     */
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
}
