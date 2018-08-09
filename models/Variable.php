<?php

namespace app\models;

//use Yii;
use yii\db\ActiveRecord;

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
 * @property TemplateVar[] $templateVars
 * @property Template[] $templates
 * @property VarValue[] $values
 */
class Variable extends ActiveRecord
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
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя переменной',
            'label' => 'Подпись',
            'template_id' => 'Template ID',
            'group' => 'Группа',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }

    public static function getByName($name)
    {
        return self::findOne(['name' => $name]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVars()
    {
        return $this->hasMany(TemplateVar::class, ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::class, ['id' => 'template_id'])
            ->viaTable('template_var', ['var_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(VarValue::class, ['var_id' => 'id']);
    }

    /**
     * @param $company_id
     * @param null $date
     * @return array|null|ActiveRecord
     */
    public function getValue($company_id, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');

        return $this->getValues()
            ->andWhere(['company_id' => $company_id])
            ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
            ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]])
            ->orderBy(['start_date' => SORT_DESC])
            ->one();
    }

    /**
     * Returns 'end_date' for the given company's variable value and current date or null
     * @param $company_id integer
     * @param $date string|null current date
     * @return null|string
     */
    public function getEndDate($company_id, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        /**
         * @var $value VarValue
         */
        $value = $this->getValues()->where(['company_id' => $company_id])
            ->andWhere(['>', 'start_date', $date])
            ->orderBy(['start_date' => SORT_ASC])->one();

        if ($value) {
            return (new \DateTime($value->start_date))
                ->sub(new \DateInterval('P1D'))
                ->format('Y-m-d');
        }

        return null;
    }
}
