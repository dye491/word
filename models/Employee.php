<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $fio_ip
 * @property string $fio_rp
 * @property string $position_ip
 * @property string $position_rp
 * @property int $company_id
 * @property string $start_date
 * @property string $end_date
 *
 * @property Company $company
 */
class Employee extends ActiveRecord
{
    use ModelTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio_ip', 'fio_rp', 'position_ip', 'position_rp', 'company_id', 'start_date'], 'required'],
            [['company_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['fio_ip', 'fio_rp', 'position_ip', 'position_rp'], 'string', 'max' => 255],
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
            'fio_ip' => Yii::t('app', 'Name, nominative case'),
            'fio_rp' => Yii::t('app', 'Name, genitive case'),
            'position_ip' => Yii::t('app', 'Position, nominative case'),
            'position_rp' => Yii::t('app', 'Position, genitive case'),
            'company_id' => Yii::t('app', 'Company ID'),
            'start_date' => Yii::t('app', 'Hire Date'),
            'end_date' => Yii::t('app', 'Dismissal Date'),
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
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->formatDates();

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->updateVars([
            'company_member_name_ip' => null,
            'company_member_name_rp' => null,
            'company_member_post_ip' => null,
            'company_member_post_rp' => null,
        ]);
    }
}
