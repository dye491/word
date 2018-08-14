<?php

namespace app\models;

//use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\Cookie;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property int $employee_count
 * @property string $org_form
 * @property int $profile_id
 * @property string $last_payment
 * @property string $email
 *
 * @property Profile $profile
 * @property Document[] $documents
 * @property VarValue[] $varValues
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
            [['name', 'email'], 'required'],
            [['employee_count', 'profile_id'], 'integer'],
            [['name', 'org_form'], 'string', 'max' => 255],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['email'], 'email'],
            [['last_payment'], 'date', 'format' => 'php:d.m.Y'],
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
            'employee_count' => 'Кол. сотрудников',
            'org_form' => 'Орг.-прав. форма',
            'profile_id' => 'Профиль',
            'last_payment' => 'Дата заключения договора',
            'email' => 'E-mail',
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
     * Returns query to template_var table (with variable table)
     * @param integer|null $template_id
     * @param null|string $date
     * @return ActiveQuery
     */
    public function getVars($template_id = null, $date = null)
    {
        return $this->getVarsQuery($template_id, $date)
            ->with('var');
    }

    /**
     * Returns query to template_var table
     * @param null|integer $template_id
     * @param null $date
     * @return ActiveQuery
     */
    public function getVarsQuery($template_id = null, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        if ($template_id === null) {
            $template_id = array_column($this->getTemplates()->asArray()->all(), 'id');
        }

        return TemplateVar::find()
            ->where(['template_id' => $template_id])
            ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
            ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]]);
    }

    /**
     * Returns count of variables for company's template(s)
     * @param null $template_id
     * @param null $date
     * @return int|string
     */
    public function getVarsCount($template_id = null, $date = null)
    {
        return $this->getVarsQuery($template_id, $date)
            ->andWhere(['required' => true])
            ->count();
    }

    public function getVarValuesCount($template_id = null, $date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        if ($template_id === null) {
            $template_id = array_column($this->getTemplates()->asArray()->all(), 'id');
        }

        return $this->getVarsQuery($template_id, $date)
            ->andWhere(['required' => true])
            ->andWhere(['exists', (new Query())->select('*')->from('var_value')
                ->where(['company_id' => $this->id])
                ->andWhere('var_id=template_var.var_id')
                ->andWhere(['or', ['<=', 'start_date', $date], ['start_date' => null]])
                ->andWhere(['or', ['>=', 'end_date', $date], ['end_date' => null]])])
            ->count();
    }

    /**
     * @return ActiveQuery
     */
    public function getVarValues()
    {
        return $this->hasMany(VarValue::class, ['company_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['company_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->dirtyAttributes['last_payment']) {
            $this->last_payment = \Yii::$app->formatter->asDate($this->last_payment, 'php:Y-m-d');
        }
        if (!$this->email) {
            $this->email = null;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Remembers id of current company in cookie
     * @param $id
     */
    public static function setCurrent($id)
    {
        $cookies = \Yii::$app->getResponse()->getCookies();
        $cookies->add(new Cookie([
            'name' => 'currentCompany',
            'value' => $id,
            'expire' => time() + 7 * 24 * 3600,
        ]));
    }

    /**
     * Returns id of current company, saved in cookie, or null, if this cookie not set
     * @return null|string
     */
    public static function getCurrent()
    {
        if ($id = \Yii::$app->request->cookies->get('currentCompany')) {
            return $id->value;
        }

        return null;
    }

    /**
     * Clears current company id, saved in cookie
     */
    public static function deleteCurrent()
    {
        \Yii::$app->getResponse()->getCookies()->remove('currentCompany');
    }

}
