<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 07.08.18
 * Time: 19:51
 */

namespace app\commands;


use app\models\Document;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionTestMakeDocument($id)
    {
        $document = Document::findOne(['id' => $id]);
        if (!$document) {
            echo "document not found (doc_id={$id})\n";
            return 404;
        }

        $template = $document->template;
        if ($template->makeDocument($document->company, $document)) {
            echo "document successfully made\n";
            return 0;
        }

        return 1;
    }
}