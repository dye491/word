<?php

namespace app\controllers;

use app\helpers\DateHelper;
use app\models\Company;
use app\models\CurrentCompanyForm;
use app\models\CurrentDateForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $this->layout = 'main-login';
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSetCompany()
    {
        $model = new CurrentCompanyForm();
        $companies = ArrayHelper::map(Company::find()->filterWhere(['not in', 'id', Company::getCurrent()])->asArray()->all(),
            'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->company_id) {
                $company = Company::findOne(['id' => $model->company_id]);
                Yii::$app->session->setFlash('success', 'Текущая организация: ' . $company->name);
                Company::setCurrent($model->company_id);

                return $this->refresh();
            }
        }

        return $this->render('set-company', [
            'model' => $model,
            'companies' => $companies,
        ]);
    }

    public function actionUnsetCompany()
    {
        Company::deleteCurrent();

        return $this->redirect('/');
    }

    public function actionSetDate()
    {
        $model = new CurrentDateForm(['curDate' => (new \DateTime(DateHelper::getCurDate()))->format('d.m.Y')]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->curDate)
                DateHelper::setCurDate($model->curDate);
            else
                DateHelper::clearCurDate();

            return $this->goHome();
        }

        return $this->render('set-date', ['model' => $model]);
    }
}
