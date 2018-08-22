<?php

namespace app\models;

use app\helpers\DateHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "var_value".
 *
 * @property int $id
 * @property int $company_id
 * @property int $var_id
 * @property string $start_date
 * @property string $end_date
 * @property string $value
 *
 * @property Company $company
 * @property Variable $var
 */
class VarValue extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'var_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['company_id', 'var_id'], 'required'],
            [['company_id', 'var_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['company_id', 'var_id', 'start_date'], 'unique', 'targetAttribute' => ['company_id', 'var_id', 'start_date']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['var_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variable::class, 'targetAttribute' => ['var_id' => 'id']],
        ];

        switch ($type = $this->var->type) {
            case 'string':
                $rules[] = [['value'], 'string'];
                break;
            case 'number':
                $rules[] = [['value'], 'number'];
                break;
            case 'date':
                $rules[] = [['value'], 'date', 'format' => 'php:d.m.Y'];
                break;
        }

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'var_id' => Yii::t('app', 'Var ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(Variable::class, ['id' => 'var_id']);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $company = $this->company;
        $templates = $this->var->getTemplates()
            ->where(['or', ['<=', 'template.start_date', DateHelper::getCurDate()], ['template.start_date' => null]])
            ->andWhere(['or', ['>=', 'template.end_date', DateHelper::getCurDate()], ['template.end_date' => null]])
            ->all();
        foreach ($templates as $template) {
            if (array_key_exists('value', $changedAttributes) &&
                $company->getVarValuesCount(
                    $template->id, DateHelper::getCurDate()) == $company->getVarsCount(
                    $template->id, DateHelper::getCurDate())) {
                $doc = Document::findOne([
                    'company_id' => $this->company_id,
                    'template_id' => $template->id,
                    'date' => DateHelper::getCurDate(),
                ]);
                if ($doc == null) $doc = new Document([
                    'company_id' => $this->company_id,
                    'template_id' => $template->id,
                    'date' => DateHelper::getCurDate(),
                ]);
                $doc->status = Document::STATUS_NEW;
                $doc->sent_at = null;
                //TODO check if file already exists and remove it
                $doc->save();
            }
        }
    }
}
