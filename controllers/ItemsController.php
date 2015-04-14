<?php

namespace app\controllers;

use Yii;
use app\models\Items;
use app\models\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
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

    /**
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = \Yii::createObject(ItemsSearch::className());
        $dataProvider = $searchModel->search($_GET);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $value=$this->findModel($id);
        //echo "<pre>";
        //print_r($value);
        //exit;
        return $this->render('view', [
            'model' => $value,
        ]);
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Items();
        /*
         *             'id' => 'ID',
                    'name' => 'Суть',
                    'description' => 'Подробности',
                    'id_category' => 'Категория',
                    'id_type' => 'Тип Заявки',
                    'date_vipolneniya' => 'Когда работа должны быть выполнена?',
                   // 'date_create' => 'Date Create',
                    //'date_update' => 'Date Update',
                    //'status' => 'Status',
                    //'id_coment' => 'Id Coment',
                    //'user_create' => 'User Create',
                    //'user_performer' => 'User Performer',
                    //'user_dispetcher' => 'User Dispetcher',
                    //'id_object' => 'Id Object',
         */
        $obj = Yii::$app->request->cookies->get('default_obj');

        if (!$obj->value) {
            throw new NotFoundHttpException('Object not select');
        }
        $data = Yii::$app->request->post();
        if (isset($data['Items'])) {
            $data['Items']['date_vipolneniya'] = strtotime($data['Items']['date_vipolneniya']);
            $data['Items']['date_create'] = strtotime(date("Y-m-d H:i:s"));
            $data['Items']['date_update'] = strtotime(date("Y-m-d H:i:s"));
            $data['Items']['status'] = 1;
            $data['Items']['user_create'] = Yii::$app->user->id;;
            $data['Items']['id_object'] = $obj->value;
        }

            if ($model->load($data) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
