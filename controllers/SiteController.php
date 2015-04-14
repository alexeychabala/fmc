<?php
//
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\ContactForm;
use app\models\Objects;
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [

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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {

        if(Yii::$app->request->post('obj')>0) {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'default_obj',
                'value' => Yii::$app->request->post('obj'),
                'expire' => time() + 86400 * 365,
            ]));
        }
        if(!Yii::$app->request->cookies->get('default_obj')>0){
            $id=Objects::getObjectCurUser(Yii::$app->user->id);
            if($id>0){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'default_obj',
                    'value' => $id,
                    'expire' => time() + 86400 * 365,
                ]));
            }
        }
        return $this->render('index');
    }



    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
