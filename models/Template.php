<?php

namespace app\models;

use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $name
 * @property string $file_name
 * @property string $form_class
 * @property string $vars
 *
 * @property Variable[] $variables
 */
class Template extends ActiveRecord
{
    const
        TEMPLATE_DIR = '@app/templates',
        OUTPUT_DIR = '@app/output';

    /**
     * @var $templateFile UploadedFile
     */
    public $templateFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'file_name', 'form_class', 'vars'], 'string', 'max' => 255],
            [['templateFile'], 'file', 'extensions' => 'docx', 'maxSize' => 2000000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Название',
            'file_name'  => 'Файл шаблона',
            'form_class' => 'Form Class',
            'vars'       => 'Vars',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariables()
    {
        return $this->hasMany(Variable::class, ['template_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getVariablesFromVars()
    {
        return Json::decode($this->vars);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getVariableValues($name)
    {
        $vars = $this->getVariablesFromVars();
        if ($vars && isset($vars[$name])) {
            return $vars[$name];
        }

        return null;
    }

    public function getVariablesWithValues()
    {
        $result = [];

        $vars = $this->getVariables()->orderBy(['group' => SORT_ASC])->asArray()->all();
        foreach ($vars as $var) {
            $result[$var['group']][$var['name']] = $var;
            $result[$var['group']][$var['name']]['values'] = $this->getVariableValues($var['name']);
        }

        foreach ($result as $group => $names) {
            if ($group) {
                $result[$group] = [];
                $result[$group]['cols'] = $names;
                $result[$group]['rows'] = [];
                $row = [];
                foreach ($names as $name => $item) {
                    $row[0][$name] = null;
                    for ($rowNumber = 0; $rowNumber < count($item['values']); $rowNumber++) {
                        $row[$rowNumber][$name] = $item['values'][$rowNumber];
                    }
                }
                $result[$group]['rows'] = $row;
            }
        }

        return $result;
    }

    /**
     * @return bool|string
     */
    public function getTemplatePath()
    {
        return $this->file_name ?
            Yii::getAlias(self::TEMPLATE_DIR) . DIRECTORY_SEPARATOR . $this->file_name
            : false;
    }

    public function getDocumentPath()
    {
        return $this->file_name ?
            Yii::getAlias(self::OUTPUT_DIR) . DIRECTORY_SEPARATOR . $this->file_name
            : false;

    }
    /**
     * @return bool
     */
    public function makeDocument()
    {
        $templatePath = $this->getTemplatePath();
        if (!$templatePath) return false;

        if (!file_exists($templatePath) || !is_file($templatePath)) return false;

        $groupedVars = $this->getVariablesWithValues();
        $templateProcessor = new TemplateProcessor($templatePath);

        foreach ($groupedVars as $group => $names) {
            if ($group) {

            } else {
                foreach ($names as $name => $value) {
                    $templateProcessor->setValue($name, $value['values']);
                }
            }
        }

        $templateProcessor->saveAs($this->getDocumentPath());
    }
}
