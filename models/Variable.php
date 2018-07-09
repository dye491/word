<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "variable".
 *
 * @property int $id
 * @property string $name
 * @property string $label
 * @property int $template_id
 * @property string $group
 * @property string $type
 *
 * @property Template $template
 */
class Variable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['template_id'], 'integer'],
            [['name', 'label', 'group', 'type'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Имя переменной',
            'label'       => 'Подпись',
            'template_id' => 'Template ID',
            'group'       => 'Группа',
            'type'        => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    public static function getByName($name)
    {
        return self::findOne(['name' => $name]);
    }
}
