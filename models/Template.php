<?php

namespace app\models;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\helpers\Json;
use yii\httpclient\Client;
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
 * @property TemplateVar[] $templateVars
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
            [['name', 'file_name', 'form_class'], 'string', 'max' => 255],
            [['vars'], 'string', 'max' => 2000],
            [['templateFile'], 'file', 'extensions' => ['docx'], 'maxSize' => 2000000,
                'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'file_name' => 'Файл шаблона',
            'form_class' => 'Form Class',
            'vars' => 'Vars',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVars()
    {
        return $this->hasMany(TemplateVar::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariables()
    {
        return $this->hasMany(Variable::class, ['id' => 'var_id'])->viaTable('template_var', ['template_id' => 'id']);
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

    /**
     * @return bool|string
     */
    public function getDocumentPath()
    {
        return $this->file_name ?
            Yii::getAlias(self::OUTPUT_DIR) . DIRECTORY_SEPARATOR . $this->file_name
            : false;

    }

    /**
     * @return bool|string
     */
    public function getPdfPath()
    {
        return $this->file_name ?
            Yii::getAlias(self::OUTPUT_DIR) . DIRECTORY_SEPARATOR . basename($this->file_name, '.docx') . '.pdf'
            : false;
    }

    /**
     * @return bool
     */
    public function hasDocument()
    {
        if (!($path = $this->getDocumentPath()))
            return false;

        return file_exists($path) && is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'docx';
    }

    /**
     * @return bool
     */
    public function hasPdf()
    {
        if (!($path = $this->getPdfPath()))
            return false;

        return file_exists($path) && is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'pdf';
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
                if (count($names['cols'])) {
                    $rowIndexCol = array_keys($names['cols'])[0];
                    $templateProcessor->cloneRow($rowIndexCol, count($names['rows']));
                    foreach ($names['rows'] as $key => $row) {
                        foreach ($row as $name => $value) {
                            $templateProcessor->setValue($name . '#' . ($key + 1), $value);
                        }
                        $rowNumber = $key + 1;
                        $templateProcessor->setValue("rowNumber#{$rowNumber}", $rowNumber);
                    }
                }
            } else {
                foreach ($names as $name => $value) {
                    $templateProcessor->setValue($name, $value['values']);
                }
            }
        }

        $templateProcessor->saveAs($this->getDocumentPath());
        return true;
    }

    /**
     * @return bool
     */
    public function makePdf()
    {
        $path = Yii::getAlias('@app/vendor/dompdf/dompdf');
        Settings::setPdfRendererPath($path);
        Settings::setPdfRendererName('DomPDF');
        Settings::setDefaultFontName('DejaVu Serif');
        $writers = [
            'Word2007' => 'docx',
            'HTML' => 'html',
            'PDF' => 'pdf',
        ];

        if (!$this->hasDocument())
            return false;

        $fileName = $this->getDocumentPath();
        $temp = IOFactory::load($fileName);
        $xmlWriter = IOFactory::createWriter($temp, 'PDF');
        $fileName = Yii::getAlias(self::OUTPUT_DIR . DIRECTORY_SEPARATOR .
            basename($this->file_name, '.docx') . '.pdf');
        $xmlWriter->save($fileName);

        return true;
    }

    public function makePdfByApi()
    {
        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://v2.convertapi.com/docx/to/pdf?Secret=qa3l5VtuaBQ6BNTj')
            ->addFile('File', $this->getDocumentPath());;

        $response = $request->send();
        Yii::error(print_r([
            'headers' => $response->getHeaders(),
            'format' => $response->getFormat(),
            'parser' => $response->client->getParser($response->getFormat()),
            'data' => $response->client->getParser($response->getFormat())->parse($response),
            'content' => $response->getContent()], true));

        if ($response->isOk) {
            $content = base64_decode($response->getData()['Files'][0]['FileData']);
            $result = file_put_contents($this->getPdfPath(), $content);
//            Yii::info('filesize: ' . $result);
            return ($result !== false);
        }

        return false;
    }
}
