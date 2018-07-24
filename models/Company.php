<?php

namespace app\models;

//use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property int $employee_count
 * @property string $org_form
 * @property int $profile_id
 *
 * @property Profile $profile
 */
class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['employee_count', 'profile_id'], 'integer'],
            [['name', 'org_form'], 'string', 'max' => 255],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'employee_count' => 'Количество сотрудников',
            'org_form' => 'Организационно-правовая форма',
            'profile_id' => 'Профиль',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->profile->getTemplates();
    }

    /**
     * @param null $template_id
     * @return ActiveQuery
     */
    public function getVars($template_id = null, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        if ($template_id === null) {
            $template_id = array_column($this->getTemplates()->asArray()->all(), 'id');
        }
        $query = TemplateVar::find()
            ->where(['template_id' => $template_id])
            ->andWhere(['or', ['>=', 'start_date', $date], ['start_date' => null]])
            ->andWhere(['or', ['<=', 'end_date', $date], ['end_date' => null]])
            ->with('var');

        return $query;
    }
}
