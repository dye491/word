<?php

namespace app\models;

use Yii;

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
class TemplateVar extends \yii\db\ActiveRecord
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
            [['start_date', 'end_date'], 'safe'],
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
            'template_id' => 'Template ID',
            'required' => 'Required',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
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
}
