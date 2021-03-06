<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\BaseController;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Post;

class SiteController extends BaseController
{

    public $layout = 'site';

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
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 4,
                'testLimit' => 2,
                'transparent' => true
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()
                ->where(['status' => [Post::STATUS_HIDDEN, Post::STATUS_PUBLISHED]])
                ->orderBy(['post_time' => SORT_DESC]),
            'pagination' => ['pageSize' => 10]
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionLogin()
    {
        $this->layout = 'column1';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
