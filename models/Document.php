<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $company_id
 * @property int $template_id
 * @property string $date
 * @property string $doc_path
 * @property string $pdf_path
 * @property string $status
 * @property string $sent_at
 *
 * @property Company $company
 * @property Template $template
 */
class Document extends \yii\db\ActiveRecord
{
    const
        STATUS_NEW = 'new',
        STATUS_READY = 'ready',
        STATUS_SEND = 'sent';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'template_id', 'date'], 'required'],
            [['company_id', 'template_id'], 'integer'],
            [['date', 'sent_at'], 'safe'],
            [['doc_path', 'pdf_path', 'status'], 'string', 'max' => 255],
            [['company_id', 'template_id', 'date'], 'unique', 'targetAttribute' => ['company_id', 'template_id', 'date']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'template_id' => Yii::t('app', 'Template ID'),
            'date' => Yii::t('app', 'Date'),
            'doc_path' => Yii::t('app', 'Doc Path'),
            'pdf_path' => Yii::t('app', 'Pdf Path'),
            'status' => Yii::t('app', 'Status'),
            'sent_at' => Yii::t('app', 'Sent At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
