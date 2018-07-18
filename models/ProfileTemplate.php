<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_template".
 *
 * @property int $profile_id
 * @property int $template_id
 *
 * @property Profile $profile
 * @property Template $template
 */
class ProfileTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'template_id'], 'required'],
            [['profile_id', 'template_id'], 'integer'],
            [['profile_id', 'template_id'], 'unique', 'targetAttribute' => ['profile_id', 'template_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'ID профиля',
            'template_id' => 'ID шаблона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
