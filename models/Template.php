<?php

namespace app\models;

use app\helpers\TranslitHelper;
use PhpOffice\PhpWord\IOFactory;
//use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Unoconv\Unoconv;
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
 * @property string $start_date
 * @property string $end_date
 * @property int $is_active
 *
 * @property Document[] $documents
 * @property TemplateVar[] $templateVars
 * @property Variable[] $variables
 * @property ProfileTemplate[] $profileTemplates
 * @property Profile[] $profiles
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
            [['start_date', 'end_date'], 'safe'],
            [['is_active'], 'integer'],
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
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVars()
    {
        return $this->hasMany(TemplateVar::class, ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariables()
    {
        return $this->hasMany(Variable::class, ['id' => 'var_id'])->viaTable('template_var', ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileTemplates()
    {
        return $this->hasMany(ProfileTemplate::class, ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::class, ['id' => 'profile_id'])->viaTable('profile_template', ['template_id' => 'id']);
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
     * Returns path to document file
     * @param $company Company
     * @param $doc Document
     * @param $absolute bool whether to return absolute path or only filename
     * @return bool|string
     */
    public function getDocumentPath($company, $doc, $absolute = true)
    {
        $path = false;

        if ($this->file_name) {
            $filename = $company->name . '_' . $doc->date . '_' . $this->file_name;
            if ($absolute) {
                $path .= Yii::getAlias(self::OUTPUT_DIR);
                $path .= DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . $company->id;
                $path .= DIRECTORY_SEPARATOR . $doc->id . DIRECTORY_SEPARATOR;
            }
            $path .= $filename;
            $path = TranslitHelper::translit($path);
        }

        return $path;
    }

    /**
     * @param $company
     * @param $doc
     * @param $absolute
     * @return bool|string
     */
    public function getPdfPath($company, $doc, $absolute = true)
    {
        $path = $this->getDocumentPath($company, $doc, $absolute);
        if (!$path) return false;

        $filename = $company->name . '_' . $doc->date . '_' . basename($this->file_name, '.docx') . '.pdf';

        return $absolute ? dirname($path) . DIRECTORY_SEPARATOR . $filename : $filename;
    }

    /**
     * @param $company Company
     * @param $doc Document
     * @return bool
     */
    public function hasDocument($company, $doc)
    {
        if (!($path = $this->getDocumentPath($company, $doc)))
            return false;

        return file_exists($path) && is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'docx';
    }

    /**
     * @param $company
     * @param $doc
     * @return bool
     */
    public function hasPdf($company, $doc)
    {
        if (!($path = $this->getPdfPath($company, $doc)))
            return false;

        return file_exists($path) && is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'pdf';
    }

    /**
     * Makes Word 2007 document from this template
     * @param $company Company
     * @param $doc Document
     * @return bool
     */
    public function makeDocument($company, $doc)
    {
        $templatePath = $this->getTemplatePath();
        if (!$templatePath) return false;

        if (!file_exists($templatePath) || !is_file($templatePath)) return false;

//        $groupedVars = $this->getVariablesWithValues();
        $templateVars = $company->getVars($this->id, $doc->date)->all();
        $templateProcessor = new TemplateProcessor($templatePath);

        /**
         * @var $templateVar TemplateVar
         * @var $value VarValue|null
         */
        foreach ($templateVars as $templateVar) {
            $var = $templateVar->var;
            $value = $var->getValue($company->id, $doc->date);
            $templateProcessor->setValue($var->name, isset($value) ? $value->value : null);
        }

        /*        foreach ($groupedVars as $group => $names) {
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
                }*/

        $documentPath = $this->getDocumentPath($company, $doc);
        if (!file_exists($dir = dirname($documentPath))) mkdir($dir, 0775, true);
        $templateProcessor->saveAs($documentPath);

        return true;
    }

    /**
     * @param $company
     * @param $doc
     * @return bool
     */
    public function makePdf($company, $doc)
    {
        $path = Yii::getAlias('@app/vendor/mpdf/mpdf');
        Settings::setPdfRendererPath($path);
        Settings::setPdfRendererName('MPDF');
//        Settings::setDefaultFontName('DejaVu Serif');
        $writers = [
            'Word2007' => 'docx',
            'HTML' => 'html',
            'PDF' => 'pdf',
        ];

        if (!$this->hasDocument($company, $doc))
            return false;

        $fileName = $this->getDocumentPath($company, $doc);
        $temp = IOFactory::load($fileName);
        $xmlWriter = IOFactory::createWriter($temp, 'PDF');
        $fileName = $this->getPdfPath($company, $doc);
        $xmlWriter->save($fileName);

        return true;
    }

    /**
     * Generates document in .pdf format
     * @param $company Company
     * @param $doc Document
     */
    public function makePdfByUnoconv($company, $doc)
    {
        $doc_path = $this->getDocumentPath($company, $doc);
        $pdf_path = $this->getPdfPath($company, $doc);
        /*        $command = 'unoconv -vvv --format %s --output %s %s 2>/var/www/output.txt';
                $command = sprintf($command, 'pdf', escapeshellarg($pdf_path), escapeshellarg($doc_path));
                $str = exec($command, $output, $result);

                return $result;*/

        $unoconv = Unoconv::create(['timeout' => 42]);
        $unoconv->transcode($doc_path, 'pdf', $pdf_path);
    }

    public function makePdfByApi($company, $doc)
    {
        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://v2.convertapi.com/docx/to/pdf?Secret=qa3l5VtuaBQ6BNTj')
            ->addFile('File', $this->getDocumentPath($company, $doc));;

        $response = $request->send();
        Yii::error(print_r([
            'headers' => $response->getHeaders(),
            'format' => $response->getFormat(),
            'parser' => $response->client->getParser($response->getFormat()),
            'data' => $response->client->getParser($response->getFormat())->parse($response),
            'content' => $response->getContent()], true));

        if ($response->isOk) {
            $content = base64_decode($response->getData()['Files'][0]['FileData']);
            $result = file_put_contents($this->getPdfPath($company, $doc), $content);
//            Yii::info('filesize: ' . $result);
            return ($result !== false);
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['template_id' => 'id']);
    }

    /**
     * Returns Document model for given company and date
     * @param $company_id
     * @param null $date
     * @return array|null|Document
     */
    public function getDocument($company_id, $date = null)
    {
        if ($date === null) $date = date('Y-m-d');

        return $this->getDocuments()
            ->andWhere(['company_id' => $company_id])
            ->andWhere(['<=', 'date', $date])
            ->orderBy(['date' => SORT_DESC])->one();
    }
}
