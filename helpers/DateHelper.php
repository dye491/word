<?php

namespace app\helpers;

use yii\web\Cookie;

class DateHelper
{
    /**
     * Save current date in cookie
     * @param null $date
     */
    public static function setCurDate($date = null)
    {
        $date = (new \DateTime($date))->format('Y-m-d');
        $cookie = new Cookie([
            'name' => 'curDate',
            'value' => $date,
            'expire' => time() + 7 * 24 * 3600,
        ]);
        \Yii::$app->response->cookies->add($cookie);
    }

    /**
     * Returns current date, saved in cookie
     * @return false|mixed|string
     */
    public static function getCurDate()
    {
        $cookies =\Yii::$app->request->cookies;
        if ($cookies->has('curDate')) {
            return $cookies->getValue('curDate');
        }

        return date('Y-m-d');
    }

    /**
     * Removes cookie that stores current date
     */
    public static function clearCurDate()
    {
        \Yii::$app->response->cookies->remove('curDate');
    }

    public static function getPrevDate($date)
    {
        return (new \DateTime($date))->sub(new \DateInterval('P1D'))->format('Y-m-d');
    }
}